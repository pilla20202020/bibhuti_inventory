<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\BranchRequest;
use App\Modules\Service\Branch\BranchService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $branch;

    function __construct(BranchService $branch)
    {
        $this->branch = $branch;
    }

    public function index()
    {
        //
        $branchs = $this->branch->paginate();
        return view ('branch.index',compact('branchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('branch.create');

    }

    public function getAllData()
    {
        // dd($this->branch);
        return $this->branch->getAllData();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        //
        // dd($request->all());
        if($branch = $this->branch->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $branch);
            }
            return redirect()->route('branch.index');

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
        $branch = $this->branch->find($id);
        return view('branch.edit',compact('branch'));
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
        if($this->branch->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $branch = $this->branch->find($id);
                $this->uploadFile($request, $branch);
            }
            return redirect()->route('branch.index');
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
        if($this->branch->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $branch)
    {
        $file = $request->file('image');
        $fileName = $this->branch->uploadFile($file);
        if (!empty($branch->image))
            $this->branch->__deleteImages($branch);


        $data['image'] = $fileName;
        $this->branch->updateImage($branch->id, $data);

    }
}
