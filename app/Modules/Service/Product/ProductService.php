<?php

namespace App\Modules\Service\Product;

use App\Modules\Models\Product\Product;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProductService extends Service
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->product->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('supplier',function(Product $product) {
                if($product->supplier->name) {
                    return $product->supplier->name;
                }
            })
            ->editColumn('category',function(Product $product) {
                if($product->category->name) {
                    return $product->category->name;
                }
            })
            ->editColumn('status',function(Product $product) {
                if($product->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Product $product) {
                if(isset($product->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($product->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Product $product) {
                $editRoute =  route('product.edit',$product->id);
                $deleteRoute =  route('product.destroy',$product->id);
                return getTableHtml($product,'actions',$editRoute,$deleteRoute);
                return getTableHtml($product,'image');
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
            $product = $this->product->create($data);
            return $product;

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

        return $this->product->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->product->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($productId)
    {
        try {
            return $this->product->whereIsDeleted('no')->find($productId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($productId, array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subproduct'] = (isset($data['has_subproduct']) ?  $data['has_subproduct'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $product= $this->product->find($productId);

            $product = $product->update($data);
            //$this->logger->info(' created successfully', $data);

            return $product;
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
    public function delete($productId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $product = $this->product->find($productId);
            $data['is_deleted']='yes';
            return $product = $product->update($data);

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
        return $this->product->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->product->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getByCategoryId($id){
        return $this->product->whereIsDeleted('no')->whereCategory_id($id)->get();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/product';
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

    public function updateImage($productId, array $data)
    {
        try {
            $product = $this->product->find($productId);
            $product = $product->update($data);

            return $product;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
