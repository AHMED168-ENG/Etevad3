<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Validator;
use App\Exports\HeroExcel;
use Maatwebsite\Excel\Facades\Excel;
class HeroController extends Controller

{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => "excelFile"]);
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
            $hero = Hero::where("name" , "like" , "%" . $search . "%")->orWhere("description" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["hero" => $hero]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastHeros(Request $request)
    {
        try {

            $hero = Hero::Active()->limit(4)->get();
            return success(["hero" => $hero]);
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
            $validation = Validator::make($request , [
                "name" => "required|unique:heroes",
                "description" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
                "image" => "required|mimes:jpg,jpeg,png,bmp,svg,tiff|max:4096",
            ] , [
                "name.required" => "ادخل اسم البطل ",
                "name.unique" => "هذا البطل تم تسجيله من قبل",
                "description.required" => "ادخل وصف البطل ",
                "image.required" =>  "ادخل صوره البطل",
                "active.required" =>  "ادخل حاله البطل",
                "image.required" => "ادخل صوره البطل",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,svg,tiff",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $image = uploud_file($request["image"] , "images/heros");
            $request["image"] = $image;
            $request["active"] = $request["active"] == "1" ? true : false;
            $statistic = Hero::create($request);
            return success(["statistic" => $statistic]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * show the specified hero
     *
     * @param  \App\Models\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $hero = Hero::find($id);
            if(!$hero) return notFoundElement();
            return success(["hero" => $hero]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $request->request->remove('image');
            $hero = Hero::find($id);
            $request = $request->all();
            $validation = Validator::make($request , [
                "name" => "required|unique:heroes,name," . $id,
                "description" => "required",
                "active" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
            ] , [
                "name.required" => "ادخل اسم البطل ",
                "name.unique" => "هذا البطل تم تسجيله من قبل",
                "description.required" => "ادخل وصف البطل ",
                "image.required" =>  "ادخل صوره البطل",
                "active.required" =>  "ادخل حاله البطل",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $statistic = $hero->update($request);
            return success(["statistic" => $statistic]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $hero = Hero::find($id);
            if(!$hero) return notFoundElement();
            if($hero -> image) {
                deleteFile($hero->image , "images/heros");
            }
            $hero = $hero->delete();
            return success(["hero" => $hero]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * activation the specified resource from storage.
     *
     * @param  \App\Models\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $hero = Hero::find($id);
            if(!$hero) return notFoundElement();

            $hero->update([
                "active" => !$hero->active,
            ]);
            return success(["active" => $hero->active]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * excel heros
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new HeroExcel, 'heros.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

        /**
     * change hero image hero
     *
     * @param  \App\Models\hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request ,$id)
    {
        try {
            $hero = Hero::find($id);
            if(!$hero) return notFoundElement();
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

            if($hero->image) {
                deleteFile($hero->image , "images/heros");
                $file = uploud_file($request -> image , "images/heros");

            } else {
                $file = uploud_file($request -> image , "images/heros");

            }
            $hero->update([
                "image" => $file
            ]);
            return success(["image" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
}
