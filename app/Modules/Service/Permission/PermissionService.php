<?php

namespace App\Modules\Service\Permission;

use App\Modules\Models\Permission\Permission;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission as SepPermission;



class PermissionService extends Service
{
    protected $Permission;

    public function __construct(Permission $Permission)
    {
        $this->Permission = $Permission;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->Permission->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            // ->editColumn('brand',function(Permission $Permission) {
            //     if($Permission->brand->name) {
            //         return $Permission->brand->name;
            //     }
            // })
            // ->editColumn('category',function(Permission $Permission) {
            //     if($Permission->category->name) {
            //         return $Permission->category->name;
            //     }
            // })
            ->editColumn('visibility',function(Permission $Permission) {
                if($Permission->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(Permission $Permission) {
                if($Permission->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(Permission $Permission) {
                if($Permission->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Permission $Permission) {
                if(isset($Permission->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($Permission->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Permission $Permission) {
                $editRoute =  route('permission.edit',$Permission->id);
                $deleteRoute =  route('permission.destroy',$Permission->id);
                return getTableHtml($Permission,'actions',$editRoute,$deleteRoute);
                return getTableHtml($Permission,'image');
            })->rawColumns(['visibility','availability','status','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            //dd($data);
            // DB::table('permissions')->insert(['guard_name' => 'web']);
            $Permission = SepPermission::create($data);
            return $Permission;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all Permission
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->Permission->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }
    /**
     * Get all Permission
     *
     * @return Collection
     */
    public function all()
    {
        return $this->Permission->whereIsDeleted('no')->all();
    }

    /**
     * Get all Permissions with supervisor type
     *
     * @return Collection
     */


    public function find($PermissionId)
    {
        try {
            return $this->Permission->whereIsDeleted('no')->find($PermissionId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($PermissionId, array $data)
    {
        try {
            $data['last_updated_by']= Auth::user()->id;
            $Permission= $this->Permission->find($PermissionId);
            $Permission = $Permission->update($data);
            //$this->logger->info(' created successfully', $data);

            return $Permission;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a Permission
     *
     * @param Id
     * @return bool
     */
    public function delete($PermissionId)
    {
        try {

            $data['last_deleted_by']= Auth::Permission()->id;
            $data['deleted_at']= Carbon::now();
            $Permission = $this->Permission->find($PermissionId);
            $data['is_deleted']='yes';
            return $Permission = $Permission->update($data);

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
        return $this->Permission->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->Permission->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/Permission';
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

    public function updateImage($PermissionId, array $data)
    {
        try {
            $Permission = $this->Permission->find($PermissionId);
            $Permission = $Permission->update($data);

            return $Permission;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function getPermissionByGroupWise()
    {
        $groupPermissions = $this->Permission->all();
        return $groupPermissions;
    }
}
