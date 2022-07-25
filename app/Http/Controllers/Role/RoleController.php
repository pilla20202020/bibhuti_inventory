<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Modules\Service\Permission\PermissionService;
use App\Modules\Service\Role\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $role, $permission ;

    function __construct(RoleService $role, PermissionService $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:role-create', ['only' => ['create','store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = $this->role->paginate();
        return view ('role.index',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        //
        $permission = $this->permission->paginate();
        $groupPermissions = $this->permission->getPermissionByGroupWise()->groupBy('group_name')->chunk(3);
        // dd($groupPermissions->groupBy('group_name')->chunk(3));
        return view('role.create',compact('permission','groupPermissions'));

    }

    public function getAllData()
    {
        // dd($this->role);
        return $this->role->getAllData();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        // dd($request->all());
        $role = Role::create(['name' => $request->input('name'),'role' => 'web']);
        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('role.index');

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
        $role = $this->role->find($id);
        $rolePermission = $this->role->getAssignedPermission($role->id);
        $permission = $this->permission->paginate();
        $groupPermissions = $this->permission->getPermissionByGroupWise()->groupBy('group_name')->chunk(3);
        return view('role.edit',compact('role','rolePermission','permission','groupPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        //
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permissions'));
        return redirect()->route('role.index');
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
        if($this->role->delete($id)) {
            return response()->json(['status'=>true]);
        }
    }
}
