<?php

namespace App\Http\Controllers;

use App\Models\Achivement;
use Illuminate\Http\Request;
use Validator;
use \Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AchivementExcel;
class AchivementController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" =>[ "excelFile" , "activeAchivement" , "lastThree" , "achivementTypes"]]);
        $this->middleware('can:كل الانجازات', ['only' => ['index']]);
        $this->middleware('can:تفاصيل الانجاز', ['only' => ['show']]);
        $this->middleware('can:حاله الانجاز', ['only' => ['activation']]);
        $this->middleware('can:اضافه انجاز', ['only' => ['store']]);
        $this->middleware('can:تعديل انجاز', ['only' => ['update']]);
        $this->middleware('can:حذف انجاز', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره الانجاز', ['only' => ['upload_achivement_image']]);
        $this->middleware('can:ارفاق الايكون الانجاز', ['only' => ['upload_achivement_icon']]);
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
            $achivement = Achivement::where("title" , "like" , "%" . $search . "%")->orWhere("content" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["achivement" => $achivement]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeAchivement(Request $request)
    {
        try {
            $achivement = Achivement::Active()->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["achivement" => $achivement]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastThree(Request $request)
    {
        try {
            $lastThreeAchivement = Achivement::Active()->orderBy("created_at" , "desc")->limit(3)->get();
            return success(["lastThreeAchivement" => $lastThreeAchivement]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function achivementTypes(Request $request)
    {
        try {
            $achivementRobots = Achivement::Active()->where("achivement_category" , 1)->orderBy("created_at" , "desc")->limit(4)->get();
            $achivementWireless = Achivement::Active()->where("achivement_category" , 2)->orderBy("created_at" , "desc")->limit(4)->get();
            return success(["achivement" => ["achivementRobots" => $achivementRobots , "achivementWireless" => $achivementWireless]]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
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
            $validation = Validator::make($request, [
                "title" => "required|unique:achivements",
                "achivement_date" => "required|date",
                "content" => "required",
                "achivement_kind" => "required",
                "achivement_category" => "required",
                "achivement_image" => "required|mimes:jpeg,png,svg,bmp,tiff,jpg|max:20096",
                "achivement_icon" => "required|mimes:jpeg,png,svg,bmp,tiff,jpg|max:20096",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الانجاز",
                "title.unique" => "هذا الانجاز تم تسجيله من قبل",
                "achivement_date.required" => "ادخل تاريخ الانجاز",
                "achivement_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "content.required" => "ادخل محتواي الانجاز",
                "achivement_kind.required" => "ادخل نوع الانجاز",
                "achivement_image.required" => "ادخل صوره الانجاز",
                "achivement_image.mimes" => "يجب ان يكون صوره الانجاز اما jpg,jpeg,png,svg,bmp,tiff",
                "achivement_image.max" => "الملف لا يجب ان يتعدي 4 mb",
                "achivement_icon.required" => "ادخل الايقونه",
                "achivement_icon.mimes" => "يجب ان يكون نوع الايكون اما jpg,jpeg,png,svg,bmp,tiff",
                "achivement_icon.max" => "الملف لا يجب ان يتعدي 4 mb",
                "achivement_category.required" => "ادخل القسم التابع له الانجاز",
                "active.required" =>  "ادخل حاله الانجاز",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $achivement_image = uploud_file($request["achivement_image"] , "images/achivement/images");
            $achivement_icon = uploud_file($request["achivement_icon"] , "images/achivement/icons");
            $request["achivement_image"] = $achivement_image;
            $request["achivement_icon"] = $achivement_icon;
            $request["achivement_date"] = new Carbon($request["achivement_date"]);
            $request["slug"] = my_slug($request["title"] );
            $request["active"] = $request["active"] == "1" ? true : false;
            $achivement = Achivement::create($request);
            return success(["achivement" => $achivement]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\achivement  $achivement
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();
            return success(["achivement" => $achivement]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Achivement  $achivement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->request->remove('achivement_icon');
            $request->request->remove('achivement_image');
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request, [
                "title" => "required|unique:achivements,title," . $achivement ->id,
                "achivement_date" => "required|date",
                "content" => "required",
                "achivement_kind" => "required",
                "achivement_category" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الانجاز",
                "title.unique" => "هذا الانجاز تم تسجيله من قبل",
                "achivement_date.required" => "ادخل تاريخ الانجاز",
                "achivement_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "content.required" => "ادخل محتواي الانجاز",
                "achivement_kind.required" => "ادخل نوع الانجاز",
                "achivement_category.required" => "ادخل القسم التابع له الانجاز",
                "active.required" =>  "ادخل حاله الانجاز",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["achivement_date"] = new Carbon($request["achivement_date"]);
            $request["active"] = $request["active"] == "1" ? true : false;
            $request["slug"] = my_slug($request["title"] );
            $achivement = $achivement->update($request);
            return success(["achivement" => $request]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achivement  $achivement
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try{
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();

            if($achivement -> achivement_image) {
                deleteFile($achivement->achivement_image , "images/achivement/images");
                deleteFile($achivement->achivement_icon , "images/achivement/icons");
            }

            $achivement = $achivement->delete();
            return success(["achivement" => $achivement]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change activation Achivement
     *
     * @param  \App\Models\Achivement  $Achivement
     * @return \Illuminate\Http\Response
     */
    public function activation( string $id)
    {
        try {
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();

            $achivement->update([
                "active" => !$achivement->active,
            ]);
            return success(["active" => $achivement->active]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change image Achivement image
     *
     * @param  \App\Models\Achivement  $Achivement
     * @return \Illuminate\Http\Response
     */
    public function upload_achivement_image(Request $request , string $id)
    {
        try {
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "achivement_image" => "required|mimes:jpg,jpeg,png,svg,bmp,tiff|max:20096",

            ] , [
                "achivement_image.required" => "يجب ارفاق الصوره",
                "achivement_image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,svg,bmp,tiff",
                "achivement_image.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);
            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($achivement->achivement_image) {
                deleteFile($achivement->achivement_image , "images/achivement/images");
                $achivement_image = uploud_file($request -> achivement_image , "images/achivement/images");
            } else {
                $achivement_image = uploud_file($request -> achivement_image , "images/achivement/images");
            }

            $achivement->update([
                "achivement_image" => $achivement_image
            ]);
            return success(["achivement_image" => $achivement_image]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change image Achivement icon
     *
     * @param  \App\Models\Achivement  $Achivement
     * @return \Illuminate\Http\Response
     */
    public function upload_achivement_icon(Request $request , string $id)
    {
        try {
            $achivement = Achivement::find($id);
            if(!$achivement) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "achivement_icon" => "required|mimes:jpg,jpeg,png,svg,bmp,tiff|max:20096",

            ] , [
                "achivement_icon.required" => "يجب ارفاق الصوره",
                "achivement_icon.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,svg,bmp,tiff",
                "achivement_icon.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($achivement->achivement_icon) {
                deleteFile($achivement->achivement_icon , "images/achivement/icons");
                $achivement_icon = uploud_file($request -> achivement_icon , "images/achivement/icons");
            } else {
                $achivement_icon = uploud_file($request -> achivement_icon , "images/achivement/icons");
            }

            $achivement->update([
                "achivement_icon" => $achivement_icon
            ]);

            return success(["achivement_icon" => $achivement_icon]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

        /**
     * excel Achivement
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new AchivementExcel, 'Achivements.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
