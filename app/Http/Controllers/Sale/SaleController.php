<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\SaleRequest;
use App\Modules\Models\SaleDetail\SaleDetail;
use App\Modules\Service\Category\CategoryService;
use App\Modules\Service\Customer\CustomerService;
use App\Modules\Service\Price\PriceService;
use App\Modules\Service\Product\ProductService;
use App\Modules\Service\Purchase\PurchaseService;
use App\Modules\Service\Sale\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $product, $customer, $sale, $category, $price,$purchase;

    function __construct(ProductService $product, CustomerService $customer, SaleService $sale, CategoryService $category, PriceService $price,PurchaseService $purchase)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->sale = $sale;
        $this->category = $category;
        $this->price = $price;
        $this->purchase = $purchase;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sale = $this->sale->paginate();
        return view ('sale.index',compact('sale'));
    }

    public function getAllData()
    {
        return $this->sale->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $customer = $this->customer->paginate();
        $product = $this->product->paginate();
        $category = $this->category->paginate();
        return view('sale.create',compact('customer','product','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request)
    {
        //
        if($sale = $this->sale->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $sale);
            }

            if($request->product_id){
                $p = 0;
                foreach ($request->product_id as $sale_detail) {
                    $purchase = $this->purchase->getByProductId($sale_detail);
                    $saledetail = new SaleDetail();
                    $saledetail->sale_id = $sale->id;
                    $saledetail->product_id = $sale_detail;
                    $saledetail->quantity = $request->quantity[$p];
                    if($saledetail->quantity > $purchase->available_stock) {
                        return redirect()->back();
                    } else {
                        $updatepurchase = $purchase->available_stock - $saledetail->quantity;
                    }
                    $saledetail->price = $request->price[$p];
                    $saledetail->discount = $request->discount[$p];
                    $saledetail->totalprice = $request->totalprice[$p];
                    $saledetail->save();
                    $this->purchase->updateStock($purchase->id,$updatepurchase);
                    $p = $p + 1;
                }

            }
            return redirect()->route('sale.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sale = $this->sale->find($id);
        $sale_details = SaleDetail::where('sale_id',$sale->id)->get();
        return view('sale.show',compact('sale','sale_details'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if($this->sale->delete($id)) {
            $sale_details = SaleDetail::where('sale_id',$id)->delete();
            return redirect()->route('sale.index');
        }
    }
}
