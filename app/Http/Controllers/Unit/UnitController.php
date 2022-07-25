<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\UnitRequest;
use App\Modules\Service\Unit\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $unit;

    function __construct(UnitService $unit)
    {
        $this->unit = $unit;
    }

    public function index()
    {
        //
        $unit = $this->unit->paginate();
        return view ('unit.index',compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllData()
    {
        // dd($this->unit);
        return $this->unit->getAllData();
    }
    public function create()
    {
        //
        return view('unit.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        //
        if($unit = $this->unit->create($request->all())) {
            return redirect()->route('unit.index');

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
        $unit = $this->unit->find($id);
        return view('unit.edit',compact('unit'));
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
        if($this->unit->update($id,$request->all()))
        return redirect()->route('unit.index');
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
        if($this->unit->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    public function unitStore(Request $request) {
        if($unit = $this->unit->create($request->all())) {
            $unit = $this->unit->paginate();
            return response()->json([
                'data' => $unit,
                'status' => true,
                'message' => "Unit Added Successfully."
            ]);
        }
    }

}
