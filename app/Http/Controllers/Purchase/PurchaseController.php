<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Modules\Service\Category\categoryService;
use App\Modules\Service\Product\ProductService;
use App\Modules\Service\Purchase\PurchaseService;
use App\Modules\Service\supplier\SupplierService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $product, $supplier, $purchase, $category;
    function __construct(ProductService $product, SupplierService $supplier, PurchaseService $purchase, CategoryService $category)
    {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->purchase = $purchase;
        $this->category = $category;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $purchase = $this->purchase->paginate();
        return view ('purchase.index',compact('purchase'));

    }

    public function getAllData()
    {
        // dd($this->product);
        return $this->purchase->getAllData();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $supplier = $this->supplier->paginate();
        $product = $this->product->paginate();
        $category = $this->category->paginate();
        return view('purchase.create',compact('supplier','product','category'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request)
    {
        //
            // if($product = $this->purchase->getByProductForUpdate($request->except('_token','pageSubmit'))) {
            //     if($request->hasFile('image')) {
            //         $this->uploadFile($request, $product);
            //     }
            //     return redirect()->route('purchase.index');
            // };
            $purchase = $this->purchase->getByProductId($request->product_id);
            if(isset($purchase)) {
                $purchase = $this->purchase->updateStockWhilePurchase($purchase->id, $request->available_stock);
            } else {
                if($purchase = $this->purchase->create($request->all())) {
                    if($request->hasFile('image')) {
                        $this->uploadFile($request, $purchase);
                    }


                }
            }
            return redirect()->route('purchase.index');

            // if($product) {
            //     $this->purchase->update($product->id,$request->all());
            // }

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
        $purchase = $this->purchase->find($id);
        $category_search = $this->category->find($purchase->category_id);
        $category =$this->category->paginate();
        $supplier = $this->supplier->paginate();
        $supplier_search = $this->supplier->find($purchase->supplier_id);
        $product = $this->product->paginate();
        $product_search = $this->supplier->find($purchase->product_id);
        return view('purchase.edit',compact('purchase','category','category_search','supplier','supplier_search','product','product_search'));



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
        if($this->purchase->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $purchase = $this->purchase->find($id);
                $this->uploadFile($request, $purchase);
            }
            return redirect()->route('purchase.index');
        }
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
        if($this->purchase->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $purchase)
    {
        $file = $request->file('image');
        $fileName = $this->purchase->uploadFile($file);
        if (!empty($purchase->image))
            $this->purchase->__deleteImages($purchase);

        $data['image'] = $fileName;
        $this->purchase->updateImage($purchase->id, $data);

    }

    public function quantityCheckAjax(Request $request)
    {
        $purchase = $this->purchase->getByProductId($request->product_id);
        if($request->quantity >= $purchase->available_stock) {
            return response()->json([
                'status' => false,
                'message' => "The requested quantity is greater than avialable stock."
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "The requested quantity is avialable."
            ]);
        }
    }
}
