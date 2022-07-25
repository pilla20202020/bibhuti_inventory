<?php

namespace App\Modules\Service\Category;

use App\Modules\Models\Category\Category;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class categoryService extends Service
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->category->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()

            ->editColumn('status',function(Category $category) {
                if($category->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Category $category) {
                if(isset($category->image_path)){
                    return '<a href="http://127.0.0.1:8000/'.($category->image_path).'" data-lightbox="http://127.0.0.1:8000/'.($category->image_path).'"> <img src="http://127.0.0.1:8000/'.($category->image_path).'" class="example-image" width="70px" height="70px" style="border-radius:50%">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Category $category) {
                $editRoute =  route('category.edit',$category->id);
                $deleteRoute =  route('category.destroy',$category->id);
                return getTableHtml($category,'actions',$editRoute,$deleteRoute);
                return getTableHtml($category,'image');
            })->rawColumns(['status','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::user()->id;
            //dd($data);
            $category = $this->category->create($data);
            return $category;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all User
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->category->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->category->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($categoryId)
    {
        try {
            return $this->category->whereIsDeleted('no')->find($categoryId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($categoryId, array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subcategory'] = (isset($data['has_subcategory']) ?  $data['has_subcategory'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $category= $this->category->find($categoryId);

            $category = $category->update($data);
            //$this->logger->info(' created successfully', $data);

            return $category;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a User
     *
     * @param Id
     * @return bool
     */
    public function delete($categoryId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $category = $this->category->find($categoryId);
            $data['is_deleted']='yes';
            return $category = $category->update($data);

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->category->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->category->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/category';
            return $fileName = $this->uploadFromAjax($file);
        }
    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);
        } catch (\Exception $e) {

        }
    }

    public function updateImage($categoryId, array $data)
    {
        try {
            $category = $this->category->find($categoryId);
            $category = $category->update($data);

            return $category;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
