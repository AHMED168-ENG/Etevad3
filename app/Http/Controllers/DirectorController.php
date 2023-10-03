<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectorExcel;
class DirectorController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "activeDirectors"]]);
        $this->middleware('can:كل المديرين', ['only' => ['index']]);
        $this->middleware('can:تفاصيل المدير', ['only' => ['show']]);
        $this->middleware('can:حاله المدير', ['only' => ['activation']]);
        $this->middleware('can:اضافه مدير', ['only' => ['store']]);
        $this->middleware('can:تعديل مدير', ['only' => ['update']]);
        $this->middleware('can:حذف مدير', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره المدير', ['only' => ['uploadFile']]);
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
            $directors = Director::where("title" , "like" , "%" . $search . "%")->orWhere("name" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["directors" => $directors]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeDirectors(Request $request)
    {
        try {
            $directors = Director::Active()->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["directors" => $directors]);
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
            $request = $request->all();
            $validation = Validator::make($request,[
                "name" => "required",
                "title" => "required",
                "jop" => "required",
                "image" => "required|mimes:jpg,jpeg,png,bmp,svg,tiff|max:4096",
                "active" => "required",
            ] , [
                "name.required" => "ادخل اسم العضو",
                "title.required" => "ادخل لقب العضو",
                "jop.required" => "ادخل الوظيفه",
                "image.required" => "يجب ارفاق الصوره",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,svg,tiff",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
                "active.required" =>  "ادخل حاله العضو",

            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $image = uploud_file($request["image"] , "images/directors");
            $request["image"] = $image;
            $request["active"] = $request["active"] == "1" ? true : false;
            $director = Director::create($request);
            return success(["director" => $director]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $director = Director::find($id);
            if(!$director) return notFoundElement();
            return success(["director" => $director]);
        } catch (\Throwable $th) {
            return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->request->remove('image');
            $director = Director::find($id);
            if(!$director) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request,[
                "name" => "required",
                "title" => "required",
                "jop" => "required",
                "active" => "required",
            ] , [
                "name.required" => "ادخل اسم العضو",
                "title.required" => "ادخل لقب العضو",
                "jop.required" => "ادخل الوظيفه",
                "active.required" =>  "ادخل حاله العضو",

            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $director = $director->update($request);
            return success(["director" => $director]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try {
            $director = Director::find($id);
            if(!$director) return notFoundElement();
            if($director -> image) {
                deleteFile($director->image , "images/directors");
            }
            $director = $director->delete();
            return success(["director" => $director]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * activation the special director
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function activation( $id)
    {
        try {
            $director = Director::find($id);
            if(!$director) return notFoundElement();
            if($director -> image) {
                deleteFile($director->image , "images/directors");
            }
            $director->update([
                "active" => !$director->active
            ]);
            return success(["active" => $director->active]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }


    /**
     * change director image
     *
     * @param  \App\Models\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request , $id)
    {
        try {
            $director = director::find($id);
            if(!$director) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "image" => "required|mimes:jpg,jpeg,png,bmp,svg,tiff|max:4096",
            ] , [
                "image.required" => "يجب ارفاق الصوره",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,svg,tiff",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($director->image) {
                deleteFile($director->image , "images/directors");
                $file = uploud_file($request -> image , "images/directors");

            } else {
                $file = uploud_file($request -> image , "images/directors");

            }
            $director->update([
                "image" => $file
            ]);
            return success(["image" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    
        /**
     * excel coverage
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new DirectorExcel, 'directors.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
