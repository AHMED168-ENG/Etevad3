<?php

namespace App\Http\Controllers;

use App\Models\Sponser;
use Illuminate\Http\Request;
use Validator;
use App\Exports\SponserExcel;
use Maatwebsite\Excel\Facades\Excel;
class SponserController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "lastSponser"]]);
        $this->middleware('can:كل الداعمين', ['only' => ['index']]);
        $this->middleware('can:تفاصيل الداعم', ['only' => ['show']]);
        $this->middleware('can:حاله الداعم', ['only' => ['activation']]);
        $this->middleware('can:اضافه داعم', ['only' => ['store']]);
        $this->middleware('can:تعديل داعم', ['only' => ['update']]);
        $this->middleware('can:حذف داعم', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره الداعم', ['only' => ['uploadFile']]);
    }  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $sponser = Sponser::paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["sponser" => $sponser]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastSponser()
    {
        try {
            $sponser = Sponser::Active()->limit(5)->get();
            return success(["sponser" => $sponser]);
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
                "title" => "required",
                "company_url" => "required|url",
                "logo" => "required|mimes:jpg,jpeg,png,bmp,tiff,svg|max:4096",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الشركه",
                "company_url.required" => "ادخل اللنك الخاص بموقع الشركه",
                "company_url.url" => "هذا الحقل يستقبل لينك",
                "logo.required" => "ادخل لوجو الشركه",
                "logo.mimes" => "يجب ان يكون نوع اللوجو اما jpg,jpeg,png,bmp,tiff,svg",
                "logo.max" => "الملف لا يجب ان يتعدي 4 mb",
                "active.required" =>  "ادخل حاله الشركه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $logo = uploud_file($request["logo"] , "images/sponsers");
            $request["logo"] = $logo;
            $request["active"] = $request["active"] == "1" ? true : false;
            $sponser = Sponser::create($request);
            return success(["sponser" => $sponser]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponser  $sponser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->request->remove('logo');
            $sponser = Sponser::find($id);
            $request = $request->all();
            $validation = Validator::make($request,[
                "title" => "required",
                "company_url" => "required|url",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الشركه",
                "company_url.required" => "ادخل اللنك الخاص بموقع الشركه",
                "company_url.url" => "هذا الحقل يستقبل لينك",
                "active.required" =>  "ادخل حاله الشركه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["active"] = $request["active"] == "1" ? true : false;
            $sponser = $sponser->update($request);
            return success(["sponser" => $sponser]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponser  $sponser
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $sponser = Sponser::find($id);
            if(!$sponser) return notFoundElement();
            return success(["sponser" => $sponser]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponser  $sponser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sponser = Sponser::find($id);
            if(!$sponser) return notFoundElement();
            if($sponser -> logo) {
                deleteFile($sponser->logo , "images/sponsers");
            }
            $sponser = $sponser->delete();
            return success(["Sponser" => $sponser]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * activate the sponsert
     *
     * @param  \App\Models\Sponser  $sponser
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $sponser = Sponser::find($id);
            if(!$sponser) return notFoundElement();
            $sponser->update([
                "active" => !$sponser->active,
            ]);
            return success(["active" => $sponser -> active]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change sponser image
     *
     * @param  \App\Models\Sponser  $sponser
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request , $id)
    {
        try {
            $sponser = Sponser::find($id);
            if(!$sponser) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "logo" => "required|mimes:jpg,jpeg,png,bmp,tiff,svg|max:4096",
            ] , [
                "logo.required" => "يجب ارفاق الصوره",
                "logo.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff,svg",
                "logo.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($sponser->logo) {
                deleteFile($sponser->logo , "images/sponsers");
                $file = uploud_file($request -> logo , "images/sponsers");

            } else {
                $file = uploud_file($request -> logo , "images/sponsers");

            }
            $sponser->update([
                "logo" => $file
            ]);
            return success(["logo" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

        
    /**
     * excel statistic
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new SponserExcel, 'statistic.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

}
