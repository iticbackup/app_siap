<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Carbon\Carbon;
use DB;
use Validator;
use DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(
        Role $role,
        Permission $permission
    )
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->role = $role;
        $this->permission = $permission;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = $this->role->orderBy('id','DESC')->paginate(10);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);

        // $roles = Role::orderBy('id','DESC')->paginate(5);
        // return view('roles.index',compact('roles'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
        
        // if ($request->ajax()) {
        //     $data = Role::all();
        //     return DataTables::of($data)
        //                     ->addIndexColumn()
        //                     ->addColumn('access_detail', function($row){
        //                         $permission = Permission::where('role_id',$row->id)->get();
        //                         return $permission;
        //                         // return Carbon::parse($row->created_at)->isoFormat('LLLL');
        //                     })
        //                     ->addColumn('created_at', function($row){
        //                         return Carbon::parse($row->created_at)->isoFormat('LLLL');
        //                     })
        //                     ->addColumn('updated_at', function($row){
        //                         return Carbon::parse($row->updated_at)->isoFormat('LLLL');
        //                     })
        //                     ->addColumn('action', function($row){
        //                         $btn = '<button type="button" onclick="edit(`'.$row->id.'`)" class="btn btn-warning btn-icon">
        //                                     <i class="fa fa-edit"></i>
        //                                 </button>
        //                                 <button type="button" onclick="hapus(`'.$row->id.'`)" class="btn btn-danger btn-icon">
        //                                     <i class="fa fa-trash"></i>
        //                                 </button>';
        //                         return $btn;
        //                     })
        //                     ->rawColumns(['action'])
        //                     ->make(true);
        // }
        // $data['permission'] = Permission::get();
        // return view('roles.index',$data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permission = $this->permission->get();
        // return view('roles.create',compact('permission'));
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();
        foreach($role_permission as $per){
            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }
        }
        return view('roles.create',$data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = $this->role->create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $role = $this->role->find($id);
        // $rolePermissions = $this->permission->join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        //                             ->where("role_has_permissions.role_id",$id)
        //                             ->get();
    
        // return view('roles.show',compact('role','rolePermissions'));
        $data['role'] = $this->role->find($id);
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }

        }
        return view('roles.show',$data);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $role = $this->role->find($id);
        // $permission = $this->permission->get();
        // $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        //     ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        //     ->all();
    
        // return view('roles.edit',compact('role','permission','rolePermissions'));

        $data['role'] = $this->role->find($id);
        DB::statement("SET SQL_MODE=''");
        $role_permission = $this->permission->select('name','id')->groupBy('name')->get();
        $data['custom_permission'] = array();

        foreach($role_permission as $per){

            $key = substr($per->name, 0, strpos($per->name, "-"));
            if(str_starts_with($per->name, $key)){
                $data['custom_permission'][$key][] = $per;
            }

        }

        return view('roles.edit',$data);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
