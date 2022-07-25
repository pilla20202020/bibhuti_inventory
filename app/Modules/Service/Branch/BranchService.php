<?php

namespace App\Modules\Service\Branch;

use App\Modules\Models\branch\branch;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BranchService extends Service
{
    protected $branch;

    public function __construct(Branch $branch)
    {
        $this->branch = $branch;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->branch->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status',function(Branch $branch) {
                if($branch->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('is_main',function(Branch $branch) {
                if($branch->is_main == 'yes'){
                    return '<span class="badge badge-success">Yes</span>';
                } else {
                    return '<span class="badge badge-danger">No</span>';
                }
            })
            ->editColumn('image',function(Branch $branch) {
                if(isset($branch->image_path)){
                    return '<a href="http://127.0.0.1:8000/'.($branch->image_path).'" data-lightbox="http://127.0.0.1:8000/'.($branch->image_path).'"> <img src="http://127.0.0.1:8000/'.($branch->image_path).'" class="example-image" width="70px" height="70px" style="border-radius:50%">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Branch $branch) {
                $editRoute =  route('branch.edit',$branch->id);
                $deleteRoute =  route('branch.destroy',$branch->id);
                return getTableHtml($branch,'actions',$editRoute,$deleteRoute);
                return getTableHtml($branch,'image');
            })->rawColumns(['status','image','is_main'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['is_main'] = (isset($data['is_main']) ?  $data['is_main'] : '')=='on' ? 'yes' : 'no';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::user()->id;
            //dd($data);
            $branch = $this->branch->create($data);
            return $branch;

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

        return $this->branch->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->branch->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($branchId)
    {
        try {
            return $this->branch->whereIsDeleted('no')->find($branchId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($branchId, array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['is_main'] = (isset($data['is_main']) ?  $data['is_main'] : '')=='on' ? 'yes' : 'no';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subbranch'] = (isset($data['has_subbranch']) ?  $data['has_subbranch'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $branch= $this->branch->find($branchId);

            $branch = $branch->update($data);
            //$this->logger->info(' created successfully', $data);

            return $branch;
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
    public function delete($branchId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $branch = $this->branch->find($branchId);
            $data['is_deleted']='yes';
            return $branch = $branch->update($data);

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
        return $this->branch->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->branch->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/branch';
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

    public function updateImage($branchId, array $data)
    {
        try {
            $branch = $this->branch->find($branchId);
            $branch = $branch->update($data);

            return $branch;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
