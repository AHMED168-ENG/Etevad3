<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermissionExcel;
use Validator;
class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware("AuthAdmin" , ["except" => "excelFile"]);
        $this->middleware('can:كل الاوذونات', ['only' => ['index']]);
        $this->middleware('can:اضافه اذون', ['only' => ['create', 'store']]);
        // $this->middleware('can:تعديل اذون', ['only' => ['edit', 'update']]);
        // $this->middleware('can:حذف اذون', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(){
        try {
            $permissions = Permission::all();
            return success(["permissions" => $permissions]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
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
            $permissions = Permission::where("name" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["permissions" => $permissions]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    // /**
    //  * create Permission .
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {

    //     try {
    //         $request = $request->all();
    //         $validation = Validator::make($request , [
    //             "name" => "required|unique:permissions",

    //         ] , [
    //             "name.required" => "يجب عليك ادخال اسم الاذون",
    //             "name.unique" => "هذا الاذون تم تسجيله مسبقا",
    //         ]);
    //         if($validation->fails()) {
    //             return validationError($validation->errors());
    //         }
    //         $permission = Permission::create(["name" => $request["name"] , "guard_name" => "Admin"]);
    //         return success(["Permission" => $permission]);
    //     } catch (\Throwable $th) {
    //         return errorMessage($th);
    //     }
    // }

    // /**
    //  * update Permission .
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request , $id)
    // {
    //     try {
    //         $permission = Permission::find($id);
    //         if(!$permission) return notFoundElement();
    //         $request = $request->all();
    //         $validation = Validator::make($request , [
    //             "name" => "required|unique:permissions,name," . $id,

    //         ] , [
    //             "name.unique" => "هذا الاذون تم تسجيله مسبقا",
    //             "name.required" => "يجب عليك ادخال اسم الاذون",
    //         ]);
    //         if($validation->fails()) {
    //             return validationError($validation->errors());
    //         }
    //         $permission->update(["name" => $request["name"]]);
    //         return success(["permission" => $request]);
    //     } catch (\Throwable $th) {
    //         return errorMessage($th);
    //     }
    // }

    // /**
    //  * delete Permission .
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function delete($id)
    // {
    //     try {
    //         $permission = Permission::find($id);
    //         if(!$permission) return notFoundElement();
            
    //         $permissions = $permission->delete();
    //         return success(["permission" => $permissions]);
    //     } catch (\Throwable $th) {
    //         return errorMessage($th);
    //     }
    // }

    
    /**
     * excel permissions
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new PermissionExcel, 'roles.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}