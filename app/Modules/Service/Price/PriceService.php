<?php

namespace App\Modules\Service\price;

use App\Modules\Models\Price\Price;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PriceService extends Service
{
    protected $price;

    public function __construct(Price $price)
    {
        $this->price = $price;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->price->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('product',function(Price $price) {
                if($price->product->name) {
                    return $price->product->name;
                }
            })
            ->editColumn('visibility',function(Price $price) {
                if($price->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(Price $price) {
                if($price->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(Price $price) {
                if($price->status == 'active'){
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('is_default',function(Price $price) {
                if($price->is_default == 'yes'){
                    return '<span class="badge badge-warning">Yes</span>';
                } else {
                    return '<span class="badge badge-danger">No</span>';
                }
            })
            ->editColumn('image',function(Price $price) {
                if(isset($price->image_path)){
                    return '<a href="http://127.0.0.1:8000/'.($price->image_path).'" data-lightbox="http://127.0.0.1:8000/'.($price->image_path).'"> <img src="http://127.0.0.1:8000/'.($price->image_path).'" class="example-image" width="70px" height="70px" style="border-radius:50%">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Price $price) {
                $editRoute =  route('price.edit',$price->id);
                $deleteRoute =  route('price.destroy',$price->id);
                return getTableHtml($price,'actions',$editRoute,$deleteRoute);
                return getTableHtml($price,'image');
            })->rawColumns(['visibility','availability','status','is_default','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['is_default'] = (isset($data['is_default']) ?  $data['is_default'] : '')=='on' ? 'yes' : 'no';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::user()->id;
            //dd($data);
            $price = $this->price->create($data);
            return $price;

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

        return $this->price->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->price->whereIsDeleted('no')->all();
    }

    public function isDefault()
    {
        return $this->price->whereIsDefault('no')->first();
    }


    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($priceId)
    {
        try {
            return $this->price->whereIsDeleted('no')->find($priceId);
        } catch (Exception $e) {
            return null;
        }
    }

    public function findProduct($productId)
    {
        try {
            return $this->price->whereIsDeleted('no')->where('product_id',$productId)->get();
        } catch (Exception $e) {
            return null;
        }
    }

    public function getByProductId($id){
        return $this->price->whereIsDeleted('no')->whereProduct_id($id)->whereIs_default('yes')->first();
    }




    public function update($priceId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['is_default'] = (isset($data['is_default']) ?  $data['is_default'] : '')=='on' ? 'yes' : 'no';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subprice'] = (isset($data['has_subprice']) ?  $data['has_subprice'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $price= $this->price->find($priceId);

            $price = $price->update($data);
            //$this->logger->info(' created successfully', $data);

            return $price;
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
    public function delete($priceId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $price = $this->price->find($priceId);
            $data['is_deleted']='yes';
            return $price = $price->update($data);

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
        return $this->price->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->price->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/price';
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

    public function updateImage($priceId, array $data)
    {
        try {
            $price = $this->price->find($priceId);
            $price = $price->update($data);

            return $price;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
