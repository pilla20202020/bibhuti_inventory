<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Modules\Service\supplier\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $supplier ;

    function __construct(SupplierService $supplier)
    {
        $this->supplier = $supplier;
    }

    public function index()
    {
        //
        $supplier = $this->supplier->paginate();
        return view ('supplier.index',compact('supplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllData()
    {
        // dd($this->supplier);
        return $this->supplier->getAllData();
    }
    public function create()
    {
        //
        return view('supplier.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        //
        if($supplier = $this->supplier->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $supplier);
            }
            return redirect()->route('supplier.index');

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
        $supplier = $this->supplier->find($id);
        return view('supplier.edit',compact('supplier'));
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
        if($this->supplier->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $supplier = $this->supplier->find($id);
                $this->uploadFile($request, $supplier);
            }
            return redirect()->route('supplier.index');
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
        if($this->supplier->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $supplier)
    {
        $file = $request->file('image');
        $fileName = $this->supplier->uploadFile($file);
        if (!empty($supplier->image))
            $this->supplier->__deleteImages($supplier);

        $data['image'] = $fileName;
        $this->supplier->updateImage($supplier->id, $data);

    }
}
