<?php

namespace App\Http\Controllers\PurchaseEntry;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Modules\Service\Category\categoryService;
use App\Modules\Service\Product\ProductService;
use App\Modules\Service\Purchase\PurchaseService;
use App\Modules\Service\PurchaseEntry\PurchaseEntryService;
use App\Modules\Service\PurchaseOrder\PurchaseOrderService;
use App\Modules\Service\supplier\SupplierService;
use Illuminate\Http\Request;

class PurchaseEntryController extends Controller
{
    protected $product, $purchase_entry, $purchase_order;
    function __construct(ProductService $product, PurchaseEntryService $purchase_entry, PurchaseOrderService $purchase_order)
    {
        $this->product = $product;
        $this->purchase_entry = $purchase_entry;
        $this->purchase_order = $purchase_order;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $purchase_entry = $this->purchase_entry->paginate();
        return view('purchase_entry.index',compact('purchase_entry'));

    }

    public function getAllData()
    {
        // dd($this->product);
        return $this->purchase_entry->getAllData();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $product = $this->product->paginate();
        $purchase_order = $this->purchase_order->getOnlyUnApproved();
        return view('purchase_entry.create',compact('product','purchase_order'));

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
            try {
                if(isset($request->product_order_id)) {
                    $purchase_order = $this->purchase_order->find($request->product_order_id);
                    $purchase_order->is_approved = "approved";
                    $purchase_order->save();
                }
                $purchase_entry = $this->purchase_entry->getByProductId($request->product_id);
                if(isset($purchase_entry)) {
                    $purchase_entry = $this->purchase_entry->updateStockWhilePurchase($purchase_entry->id, $request->available_stock, $request->defective_stock);
                } else {
                    if($purchase_entry = $this->purchase_entry->create($request->all())) {
                        if($request->hasFile('image')) {
                            $this->uploadFile($request, $purchase_entry);
                        }
                        Toastr()->success('Purchase Entry Created Successfully','Success');
                    }
                }
                return redirect()->route('purchase_entry.index');
            } catch (Exception $e) {
                return false;
            }

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

    public function getProductOrder(Request $request)
    {
        $data = $this->purchase_order->find($request->product_order);
        $data['product_name'] = $data->product->name;
        $data['product_id'] = $data->product->id;
        return response()->json([
            'data' => $data,
            'status' => true,
            'message' => "Purchase Order Fetched"
        ]);


    }
}
