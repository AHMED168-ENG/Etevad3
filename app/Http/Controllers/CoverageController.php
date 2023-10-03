<?php

namespace App\Http\Controllers;

use App\Models\Coverage;
use Illuminate\Http\Request;
use Validator;
use \Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CoverageExcel;
class CoverageController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "lastCoverage" , "activeCoverages"]]);
        $this->middleware('can:كل التغطيات', ['only' => ['index']]);
        $this->middleware('can:تفاصيل التغطيه', ['only' => ['show']]);
        $this->middleware('can:حاله التغطيه', ['only' => ['activation']]);
        $this->middleware('can:اضافه تغطيه', ['only' => ['store']]);
        $this->middleware('can:تعديل تغطيه', ['only' => ['update']]);
        $this->middleware('can:حذف تغطيه', ['only' => ['destroy']]);


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
            $coverage = Coverage::where("title" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["coverage" => $coverage]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeCoverages(Request $request)
    {
        try {
            $coverage = Coverage::Active()->paginate(5);
            return success(["coverage" => $coverage]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastCoverage(Request $request)
    {
        try {
            $lastCoverage = Coverage::Active()->orderBy("created_at" , "desc")->limit(4)->get();
            return success(["lastCoverage" => $lastCoverage]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coverage  $Coverage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $coverage = Coverage::find($id);
            if(!$coverage) return notFoundElement();
            return success(["coverage" => $coverage]);
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
            $validation = Validator::make($request,[
                "title" => "required|unique:coverages",
                "coverage_date" => "required|date",
                "video_id" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل اسم التغطيه",
                "title.unique" => "هذا العنوان تم تسجيله من قبل",
                "coverage_date.required" => "ادخل تاريخ التغطيه",
                "coverage_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "video_id.required" => "ادخل id الخاص بفيديو اليوتيوب",
                "active.required" =>  "ادخل حاله التغطيه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["coverage_date"] = new Carbon($request["coverage_date"]);
            $request["active"] = $request["active"] == "1" ? true : false;
            $coverage = Coverage::create($request);
            return success(["coverage" => $coverage]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $coverage = Coverage::find($id);
            if(!$coverage) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request,[
                "title" => "required|unique:coverages,title," . $coverage -> id,
                "coverage_date" => "required|date",
                "video_id" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل اسم التغطيه",
                "title.unique" => "هذا العنوان تم تسجيله من قبل",
                "coverage_date.required" => "ادخل تاريخ التغطيه",
                "coverage_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "video_id.required" => "ادخل id الخاص بفيديو اليوتيوب",
                "active.required" =>  "ادخل حاله التغطيه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["coverage_date"] = new Carbon($request["coverage_date"]);
            $request["active"] = $request["active"] == "1" ? true : false;
            $coverage = $coverage->update($request);
            return success(["coverage" => $request]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try {
            $coverage = Coverage::find($id);
            if(!$coverage) return notFoundElement();
            $coverage = $coverage->delete();
            return success(["coverage" => $coverage]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change activation coverage
     *
     * @param  \App\Models\coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $coverage = Coverage::find($id);
            if(!$coverage) return notFoundElement();

             $coverage->update([
                "active" => !$coverage->active,
            ]);
            return success(["active" => $coverage->active]);

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
            return Excel::download(new CoverageExcel, 'coverage.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
