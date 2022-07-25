<?php

namespace App\Modules\Service\Role;

use App\Modules\Models\Role\Role;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleService extends Service
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;

    }


    /*For DataTable*/
    public function getAllData()
    {
        $query = $this->role->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            // ->editColumn('brand',function(role $role) {
            //     if($role->brand->name) {
            //         return $role->brand->name;
            //     }
            // })
            // ->editColumn('role',function(role $role) {
            //     if($role->role->name) {
            //         return $role->role->name;
            //     }
            // })
            ->editColumn('visibility',function(Role $role) {
                if($role->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(Role $role) {
                if($role->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(Role $role) {
                if($role->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editcolumn('actions',function(Role $role) {
                $editRoute =  route('role.edit',$role->id);
                $deleteRoute =  route('role.destroy',$role->id);
                return getTableHtml($role,'actions',$editRoute,$deleteRoute);
                return getTableHtml($role,'image');
            })->rawColumns(['visibility','availability','status','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::role()->id;
            //dd($data);
            $role = $this->role->create($data);
            return $role;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all role
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->role->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all role
     *
     * @return Collection
     */
    public function all()
    {
        return $this->role->whereIsDeleted('no')->all();
    }

    /**
     * Get all roles with supervisor type
     *
     * @return Collection
     */


    public function find($roleId)
    {
        try {
            return $this->role->whereIsDeleted('no')->find($roleId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($roleId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subrole'] = (isset($data['has_subrole']) ?  $data['has_subrole'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::role()->id;
            $role= $this->role->find($roleId);

            $role = $role->update($data);
            //$this->logger->info(' created successfully', $data);

            return $role;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a role
     *
     * @param Id
     * @return bool
     */
    public function delete($roleId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $role = $this->role->find($roleId);
            $data['is_deleted']='yes';
            return $role = $role->update($data);

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
        return $this->role->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->role->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getAssignedPermission($id){
        try{
            $role = Role::with('permissions')->find($id);
            $per = $role->permissions;
            return $per;
        }catch (Exception $e){
            return false;
        }
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/role';
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

    public function updateImage($roleId, array $data)
    {
        try {
            $role = $this->role->find($roleId);
            $role = $role->update($data);

            return $role;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
