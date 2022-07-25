<?php
/**
 * Created by PhpStorm.
 * User: aarrunyal
 * Date: 03/01/2019
 * Time: 17:53
 */

namespace App\Modules\Service\UserRole;

use App\Modules\Models\Role\PermissionRole;
use App\Modules\Models\User\RoleUser;

class UserRoleService
{
    protected $userRole;
    protected  $rolePermission;

    function __construct(
        RoleUser $userRoleModel,
        PermissionRole $rolePermissionModel
    )
    {
        $this->userRole = $userRoleModel;
        $this->rolePermission = $rolePermissionModel;
    }

    //User role deletion using roleid and userid
    public function deleteUserRoleByUserId($id){
        try{
            $role = $this->userRole->where('user_id', '=', $id)->delete();
                return true;
        }catch (Exception $e){
            return false;
        }
    }

    public function deleteUserRoleByRoleId($id){
        try{
            $role = $this->userRole->where('role_id', '=', $id)->delete();
                return true;
        }catch (Exception $e){
            return false;
        }
    }

    //permission deletion using roleid and permissionid
    public function deleteRolePermissionByPermissionId($id){
        try{
            $permission = $this->rolePermission->where('permission_id', '=', $id)->delete();
                return true;
        }catch (Exception $e){
            return false;
        }
    }

    public function deleteRolePermissionByRoleId($id){
        try{
            $permission = $this->rolePermission->where('role_id', '=', $id)->delete();
                return true;
        }catch (Exception $e){
            return false;
        }
    }

    public function getAllUserWithRoleId($roleId){
        try{
            $users = $this->userRole->where('role_id','=', $roleId)->get();
            return $users;
        }catch (\Exception $e){
            return false;
        }
    }

}