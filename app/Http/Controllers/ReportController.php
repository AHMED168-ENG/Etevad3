<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Validator;
use \Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExcel;
use Illuminate\Support\Facades\Storage;
class ReportController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "downloadPdf"]]);
        $this->middleware('can:كل التقارير', ['only' => ['index']]);
        $this->middleware('can:تفاصيل التقرير', ['only' => ['show']]);
        $this->middleware('can:حاله التقرير', ['only' => ['activation']]);
        $this->middleware('can:اضافه تقرير', ['only' => ['store']]);
        $this->middleware('can:تعديل تقرير', ['only' => ['update']]);
        $this->middleware('can:حذف تقرير', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق ملف التقرير', ['only' => ['uploadFile']]);
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
            $reports = Report::where("title" , "like" , "%" . $search . "%")->orWhere("overview" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["reports" => $reports]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activeReports(Request $request)
    {
        try {
            $reports = Report::Active()->paginate(5);
            return success(["reports" => $reports]);
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
                "overview" => "required",
                "pdf" => "required|mimes:pdf|max:4096",
                "report_date" => "required|date",
                // "page_keywords" => "required",
                // "page_description" => "required",
                "active" => "required",

            ] , [
                "report_date.required" => "ادخل تاريخ التقرير",
                "report_date.date" => "يجب ان يكون نوع التقرير تاريخ",
                "title.required" => "ادخل عنوان التقرير",
                "overview.required" => "ادخل وصف متصر عن التقرير",
                "pdf.required" => "ادخل الملف الخاص بالتقرير ",
                "pdf.mimes" => "يجب ان يكون نوع الملف اما pdf",
                "pdf.max" => "الملف لا يجب ان يتعدي 4 mb",
                "active.required" =>  "ادخل حاله التقرير",
                // "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                // "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $pdf = uploud_file($request["pdf"] , "pdf/reports");
            $request["pdf"] = $pdf;
            $request["active"] = $request["active"] == "1" ? true : false;
            $request["report_date"] = new Carbon($request["report_date"]);
            $report = Report::create($request);
            return success(["report" => $report]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $report = Report::find($id);
            if(!$report) return notFoundElement();
            return success(["report" => $report]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->request->remove('pdf');
            $report = Report::find($id);
            if(!$report) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request,[
                "title" => "required",
                "overview" => "required",
                "report_date" => "required|date",
                // "page_keywords" => "required",
                // "page_description" => "required",
                "active" => "required",
            ] , [
                "report_date.required" => "ادخل تاريخ التقرير",
                "report_date.date" => "يجب ان يكون نوع التقرير تاريخ",
                "title.required" => "ادخل عنوان التقرير",
                "overview.required" => "ادخل وصف متصر عن التقرير",
                "pdf.required" => "ادخل الملف الخاص بالتقرير ",
                "pdf.mimes" => "يجب ان يكون نوع الملف اما pdf",
                "pdf.max" => "الملف لا يجب ان يتعدي 4 mb",
                "active.required" =>  "ادخل حاله التقرير",
                // "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                // "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["active"] = $request["active"] == "1" ? true : false;
            $request["report_date"] = new Carbon($request["report_date"]);
            $report->update($request);
            return success(["report" => $request]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $report = Report::find($id);
            if(!$report) return notFoundElement();
            if($report -> pdf) {
                deleteFile($report->pdf , "pdf/reports");
            }
            $report = $report->delete();
            return success(["report" => $report]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * change activation report
     *
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $report = report::find($id);
            if(!$report) return notFoundElement();

            $report->update([
                "active" => !$report->active,
            ]);
            return success(["active" => $report->active]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change report pdf
     *
     * @param  \App\Models\report  $report
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request , $id)
    {
        try {
            $report = report::find($id);
            if(!$report) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "pdf" => "required|mimes:pdf|max:4096",
            ] , [
                "pdf.required" => "يجب ارفاق الملف",
                "pdf.mimes" => "يجب ان يكون نوع الملف  pdf",
                "pdf.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($report->pdf) {
                deleteFile($report->pdf , "pdf/reports");
                $file = uploud_file($request -> pdf , "pdf/reports");
            } else {
                $file = uploud_file($request -> pdf , "pdf/reports");

            }
            $report->update([
                "pdf" => $file
            ]);
            return success(["pdf" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    
    /**
     * excel permissions
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new ReportExcel, 'reports.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
    /**
     * excel permissions
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf($id )
    {
        try {
            $file = report::find($id);
            return Storage::disk("public")->download("/pdf/reports/" . $file -> pdf , $file -> pdf . ".pdf" , ['Content-Type' => 'application/pdf',]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
