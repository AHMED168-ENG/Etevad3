<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RoleExcel;
use Validator;
class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware("AuthAdmin" , ["except" => "excelFile"]);
        $this->middleware('can:كل الصلحيات', ['only' => ['index']]);
        $this->middleware('can:تفاصيل الصلاحيه', ['only' => ['show']]);
        $this->middleware('can:اضافه صلاحيه', ['only' => ['store']]);
        $this->middleware('can:تعديل صلاحيه', ['only' => ['edit', 'update']]);
        // $this->middleware('can:حذف صلاحيه', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query("search");
            $roles = Role::where("name" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["roles" => $roles]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        try {
            $roles = Role::all();
            return success(["roles" => $roles]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * create role .
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request = $request->all();
            $validation = Validator::make($request , [
                "name" => "required|unique:Roles",
                "permissions" => ["required","array","min:1"],
            ] , [
                "name.required" => "يجب عليك ادخال اسم الدور",
                "name.unique" => "هذا الدور تم تسجيله مسبقا",
                "permissions.required" => "يجب ادخال الاوذونات الخاصه بالصلاحيه",
                "permissions.array" => "هذا الحقل يستقبل array",
                "permissions.min" => "يجب ادخال علي الاقل اوذون واحد لهذه الصلاحيه",
            ]);
            if($validation->fails()) {
                return validationError($validation->errors());
            }
            $roles = Role::create(["name" => $request["name"] , "guard_name" => "Admin"]);
            $roles->syncPermissions([$request["permissions"]]);
            return success(["role" => $roles]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * update role .
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        try {
            $role = Role::find($id);
            if(!$role) return notFoundElement();
            $roleRequest = $request->all();
            $validation = Validator::make($roleRequest , [
                "name" => "required|unique:roles,name," . $id,
                "permissions" => ["required","array","min:1"],

            ] , [
                "name.unique" => "هذا الدور تم تسجيله مسبقا",
                "name.required" => "يجب عليك ادخال اسم الدور",
                "permissions.required" => "يجب ادخال الاوذونات الخاصه بالصلاحيه",
                "permissions.array" => "هذا الحقل يستقبل array",
                "permissions.min" => "يجب ادخال علي الاقل اوذون واحد لهذه الصلاحيه",
            ]);
            if($validation->fails()) {
                return validationError($validation->errors());
            }
            $role->update(["name" => $roleRequest["name"]]);            

            if($request->exists("permissions")) {
                $role->syncPermissions($roleRequest["permissions"]);
            }
            return success(["role" => $roleRequest]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * delete role .
     *
     * @return \Illuminate\Http\Response
     */
    // public function delete($id)
    // {
    //     try {
    //         $role = Role::find($id);
    //         if(!$role) return notFoundElement();
            
    //         $role = $role->delete();
    //         return success(["role" => $role]);
    //     } catch (\Throwable $th) {
    //         return errorMessage($th);
    //     }
    // }

    /**
     * show role .
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $role = Role::with("permissions")->find($id);
            if(!$role) return notFoundElement();

            return success(["role" => $role]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * excel roles
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new RoleExcel, 'roles.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}