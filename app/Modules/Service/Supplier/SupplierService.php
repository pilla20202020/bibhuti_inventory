<?php

namespace App\Modules\Service\Supplier;

use App\Modules\Models\Supplier\Supplier;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SupplierService extends Service
{
    protected $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->supplier->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            // ->editColumn('brand',function(supplier $supplier) {
            //     if($supplier->brand->name) {
            //         return $supplier->brand->name;
            //     }
            // })
            // ->editColumn('category',function(Supplier $supplier) {
            //     if($supplier->category->name) {
            //         return $supplier->category->name;
            //     }
            // })
            ->editColumn('status',function(Supplier $supplier) {
                if($supplier->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Supplier $supplier) {
                if(isset($supplier->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($supplier->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Supplier $supplier) {
                $editRoute =  route('supplier.edit',$supplier->id);
                $deleteRoute =  route('supplier.destroy',$supplier->id);
                return getTableHtml($supplier,'actions',$editRoute,$deleteRoute);
                return getTableHtml($supplier,'image');
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
            $supplier = $this->supplier->create($data);
            return $supplier;

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

        return $this->supplier->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->supplier->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($supplierId)
    {
        try {
            return $this->supplier->whereIsDeleted('no')->find($supplierId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($supplierId, array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subsupplier'] = (isset($data['has_subsupplier']) ?  $data['has_subsupplier'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $supplier= $this->supplier->find($supplierId);

            $supplier = $supplier->update($data);
            //$this->logger->info(' created successfully', $data);

            return $supplier;
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
    public function delete($supplierId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $supplier = $this->supplier->find($supplierId);
            $data['is_deleted']='yes';
            return $supplier = $supplier->update($data);

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
        return $this->supplier->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->supplier->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/supplier';
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

    public function updateImage($supplierId, array $data)
    {
        try {
            $supplier = $this->supplier->find($supplierId);
            $supplier = $supplier->update($data);

            return $supplier;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
