<?php

namespace App\Modules\Service\User;

use App\Modules\Models\User;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserService extends Service
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->user->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            // ->editColumn('brand',function(user $user) {
            //     if($user->brand->name) {
            //         return $user->brand->name;
            //     }
            // })
            // ->editColumn('category',function(user $user) {
            //     if($user->category->name) {
            //         return $user->category->name;
            //     }
            // })
            ->editColumn('visibility',function(user $user) {
                if($user->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(user $user) {
                if($user->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(user $user) {
                if($user->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(user $user) {
                if(isset($user->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($user->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(user $user) {
                $editRoute =  route('user.edit',$user->id);
                $deleteRoute =  route('user.destroy',$user->id);
                return getTableHtml($user,'actions',$editRoute,$deleteRoute);
                return getTableHtml($user,'image');
            })->rawColumns(['visibility','availability','status','image'])->make(true);
    }

    public function create(array $data)
    {
        try {
            // dd($data);
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::user()->id;
            $data['password'] = Hash::make($data['password']);
            //dd($data);
            $user = $this->user->create($data);
            return $user;

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

        return $this->user->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->user->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($userId)
    {
        try {
            return $this->user->whereIsDeleted('no')->find($userId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($userId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subuser'] = (isset($data['has_subuser']) ?  $data['has_subuser'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $user= $this->user->find($userId);

            $user = $user->update($data);
            //$this->logger->info(' created successfully', $data);

            return $user;
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
    public function delete($userId)
    {
        try {
            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $user = $this->user->find($userId);
            $data['is_deleted']='yes';
            return $user = $user->update($data);
            dd($user);

        } catch (Exception $e) {
            return false;
        }
    }

    public function getUserRoles($id){
        try{
            $user = User::with('roles')->find($id);
            $roles = $user->roles;
            return $roles;
        }catch (Exception $e){
            return false;
        }
    }


    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->user->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($id){
        return $this->user->whereIsDeleted('no')->whereId($id)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/user';
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

    public function updateImage($userId, array $data)
    {
        try {
            $user = $this->user->find($userId);
            $user = $user->update($data);

            return $user;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function profileUpdate(array $data, $userId)
    {
        try {
            $data['email'] = $data['email'];
            $data['password'] = Hash::make($data['password']);
            $data['last_updated_by']= Auth::user()->id;
            $user= $this->user->find($userId);
            $user = $user->update($data);
            //$this->logger->info(' created successfully', $data);

            return $user;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function passwordUpdate(array $data)
    {
        try {
            $user= $this->user->where('email',$data['email'])->first();
            if(isset($user)) {
                $data['password'] = Hash::make($data['password']);
                $user = $user->update($data);
            } else {
                Toastr()->error('The requested email does not exist','Sorry');
                return false;
            }
            //$this->logger->info(' created successfully', $data);

            return true;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
