<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExcel;

class UserController extends Controller

{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => "excelFile"]);
        $this->middleware('can:كل المستخدمين', ['only' => ['index']]);
        $this->middleware('can:تفاصيل المستخدم', ['only' => ['show']]);
        $this->middleware('can:حاله المستخدم', ['only' => ['activation']]);
        $this->middleware('can:اضافه مستخدم', ['only' => ['store']]);
        $this->middleware('can:تعديل مستخدم', ['only' => ['update']]);
        $this->middleware('can:حذف مستخدم', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره المستخدم', ['only' => ['uploadFile']]);
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
            $users = User::NotMe()->where(function ($query ) use  ($search) {
                $query->where("name" , "like" , "%" . $search . "%")
                    ->orWhere("email" , "like" , "%" . $search . "%");
            })->with("roles")->paginate(+env("ELEMENTS_PER_PAGE"));

            return success(["users" => $users]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           $validation = Validator::make($request->all(),[
                "name" => "required",
                "email" => "required|email|unique:users",
                "password" => "required",
                "role" => "required",
            ] , [
                "name.required" => "ادخل اسم المستخدم",
                "role.required" => "ادخل صلاحيه المستخدم",
                "email.unique" => "هذا الايميل مسجل من قبل",
                "email.email" => "ادخل ايميل صحيح",
                "email.required" => "ادخل ايميل المستخدم",
                "status.required" => "ادخل حاله المستخدم",
                "password.required" =>  "ادخل الرقم السري",
                "password.min" =>  "يجب ادخال 10 ارقام علي الاقل",
            ]);


            if ($validation->fails()) {
                return validationError($validation->errors());
            } else {

                $userData = $request->all();
                $userData["status"] = $userData["status"] == "1" ? true : false ;
                $userData["password"] = bcrypt($userData["password"]);
                $user = User::create($userData);
                $user->assignRole($userData["role"]);
                return success(["user" => $user]);
            }
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::NotMe()->with("roles")->find($id);
            if(!$user) return notFoundElement();
            return success(["user" => $user]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
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
        try {
            $request->request->remove('image');
            $user = User::NotMe()->with("roles")->find($id);
            if(!$user) return notFoundElement();
            $validation = Validator::make($request->all(),
                [
                    "name" => "required",
                    "email" => "required|email|unique:users,email,$id" ,
                    "password" => "nullable|min:10",
                    "role" => "required",
                ] ,
                [
                    "name.required" => "ادخل اسم المستخدم",
                    "role.required" => "ادخل صلاحيه المستخدم",
                    "email.unique" => "هذا الايميل مسجل من قبل",
                    "email.required" => "ادخل ايميل المستخدم",
                    "password.min" =>  "يجب ادخال 10 ارقام علي الاقل",
                ]);

            if ($validation->fails()) {
                return validationError($validation->errors());
            } else {
                $userData = $request->all();
                $userData["status"] = $request->status == "1" ? true : false ;
                $userData["password"] = isset($userData["password"]) ? bcrypt($userData["password"]) : $user -> password;
                if($userData["role"] != $user->roles[0]->name) {
                    $user->roles()->detach();
                    $user->assignRole($userData["role"]);
                }
                $user->update($userData);
                return success(["user" => $userData]);
            }
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePersonalData(Request $request)
    {
        try {
            $request->request->remove('image');
            $validation = Validator::make($request->all(),
                [
                    "name" => "required",
                    "email" => "required|email|unique:users,email," . auth()->user()->id ,
                    "password" => "nullable|min:10",
                    "role" => "required",
                ] ,
                [
                    "name.required" => "ادخل اسم المستخدم",
                    "role.required" => "ادخل صلاحيه المستخدم",
                    "email.unique" => "هذا الايميل مسجل من قبل",
                    "email.required" => "ادخل ايميل المستخدم",
                    "password.min" =>  "يجب ادخال 10 ارقام علي الاقل",
                ]);

            if ($validation->fails()) {
                return validationError($validation->errors());
            } else {
                $userData = $request->all();
                $userData["status"] = $request->status == "1" ? true : false ;
                $userData["password"] = isset($userData["password"]) ? bcrypt($userData["password"]) : auth()->user()->password;
 
                auth()->user()->update($userData);
                return success(["user" => auth()->user()]);
            }
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::NotMe()->with("roles")->find($id);
            if(!$user) return notFoundElement();
            $user->delete();
            return success(["user" => $user]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * activation user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $user = User::NotMe()->with("roles")->find($id);
            if(!$user) return notFoundElement();
            $user->update([
                "status" => !$user["status"],
            ]);
            return success(["active" => $user["status"]]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * upload image user
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request , $id)
    {
        try {
            $validation = Validator::make($request->all() ,
            [
                "image" => "required|mimes:jpg,jpeg,png,bmp,tiff|max:4096",

            ] , [
                "image.required" => "يجب ارفاق الصوره",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);
            if($validation->fails()) {
                return validationError($validation->errors());
            }
            $user = User::with("roles")->find($id);
            if(!$user) return notFoundElement();

            if($user->image) {
                 deleteFile($user->image , "images/user");
                $file = uploud_file($request -> image , "images/user");

            } else {
                $file = uploud_file($request -> image , "images/user");

            }
            $user->update([
                    "image" => $file
                ]);
            return success(["file" => $file] , );
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }


    /**
     * excel user
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new UserExcel, 'users.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }


}
