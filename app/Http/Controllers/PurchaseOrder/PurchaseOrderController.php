<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use App\Modules\Service\Product\ProductService;
use App\Modules\Service\PurchaseOrder\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    protected $product, $purchaseorder;
    function __construct(ProductService $product, PurchaseOrderService $purchaseorder)
    {
        $this->product = $product;
        $this->purchaseorder = $purchaseorder;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $purchaseorder = $this->purchaseorder->paginate();
        return view ('purchase_order.index',compact('purchaseorder'));
    }

    public function getAllData()
    {
        return $this->purchaseorder->getAllData();
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
        return view('purchase_order.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            if($purchaseorder = $this->purchaseorder->create($request->all())) {
                if($request->hasFile('image')) {
                    $this->uploadFile($request, $purchaseorder);
                }
                Toastr()->success('Purchase Order Created Successfully','Success');
                return redirect()->route('purchaseorder.index');
            }

        } catch (Exception $e) {
            return false;
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
        $purchaseorder = $this->purchaseorder->find($id);
        $product = $this->product->paginate();
        $product_search = $this->product->find($purchaseorder->product_id);
        return view('purchase_order.edit',compact('purchaseorder','product','product_search'));
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
        if($this->purchaseorder->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $purchaseorder = $this->purchaseorder->find($id);
                $this->uploadFile($request, $purchaseorder);
            }
            Toastr()->success('Purchase Order Updated Successfully.','Success');
            return redirect()->route('purchaseorder.index');
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
        if($this->purchaseorder->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $purchaseorder)
    {
        $file = $request->file('image');
        $fileName = $this->purchaseorder->uploadFile($file);
        if (!empty($purchaseorder->image))
            $this->purchaseorder->__deleteImages($purchaseorder);

        $data['image'] = $fileName;
        $this->purchaseorder->updateImage($purchaseorder->id, $data);

    }

}
