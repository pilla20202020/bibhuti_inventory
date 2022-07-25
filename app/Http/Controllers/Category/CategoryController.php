<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Modules\Service\Category\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected $category;

    function __construct(CategoryService $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        //
        $category = $this->category->paginate();
        return view ('category.index',compact('category'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('category.create');

    }

    public function getAllData()
    {
        // dd($this->category);
        return $this->category->getAllData();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
        if($category = $this->category->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $category);
            }
            return redirect()->route('category.index');

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
        $category = $this->category->find($id);
        return view('category.edit',compact('category'));
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
        if($this->category->update($id,$request->all()))
        {
            if ($request->hasFile('image')) {
                $category = $this->category->find($id);
                $this->uploadFile($request, $category);
            }
            return redirect()->route('category.index');
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
        if($this->category->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }

    function uploadFile(Request $request, $category)
    {
        $file = $request->file('image');
        $fileName = $this->category->uploadFile($file);
        if (!empty($category->image))
            $this->category->__deleteImages($category);


        $data['image'] = $fileName;
        $this->category->updateImage($category->id, $data);

    }


}
