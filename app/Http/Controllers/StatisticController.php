<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use Validator;
use App\Exports\StatisticExcel;
use Maatwebsite\Excel\Facades\Excel;
class StatisticController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => "excelFile"]);
        $this->middleware('can:كل الإحصائيات', ['only' => ['index']]);
        $this->middleware('can:تفاصيل الاحصائيه', ['only' => ['show']]);
        $this->middleware('can:حاله الاحصائيه', ['only' => ['activation']]);
        $this->middleware('can:اضافه احصائيه', ['only' => ['store']]);
        $this->middleware('can:تعديل احصائيه', ['only' => ['update']]);
        $this->middleware('can:حذف احصائيه', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره الاحصائيه', ['only' => ['uploadFile']]);
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
            $statistic = Statistic::where("statistic_name" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["statistic" => $statistic]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastStatistic(Request $request)
    {
        try {
            $statistic = Statistic::Active()->limit(4)->get();
            return success(["statistic" => $statistic]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $statistic = Statistic::find($id);
            if(!$statistic) return notFoundElement();
            return success(["statistic" => $statistic]);
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
            $validation = Validator::make($request , [
                "statistic_name" => "required|unique:statistics",
                "statistic_count" => "required|integer",
                "active" => "required",
            ] , [
                "statistic_name.required" => "ادخل اسم الاحصاء ",
                "statistic_name.unique" => "هذا الاحصاء تم تسجيله من قبل",
                "statistic_count.required" => "ادخل رقم الاحصاء ",
                "statistic_count.integer" => "هذا الحقل يستقبل ارقام فقط",
                "active.required" =>  "ادخل حاله الخبر",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["active"] = $request["active"] == "1" ? true : false;
            $statistic = Statistic::create($request);
            return success(["statistic" => $statistic]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {     
            $request->request->remove('logo');           
            $statistic = Statistic::find($id);
            if(!$statistic) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request , [
                "statistic_name" => "required|unique:statistics,statistic_name," . $id,
                "statistic_count" => "required|integer",
                "active" => "required",
            ] , [
                "statistic_name.required" => "ادخل اسم الاحصاء ",
                "statistic_name.unique" => "هذا الاحصاء تم تسجيله من قبل",
                "statistic_count.required" => "ادخل رقم الاحصاء ",
                "statistic_count.integer" => "هذا الحقل يستقبل ارقام فقط",
                "active.required" =>  "ادخل حاله الخبر",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["active"] = $request["active"] == "1" ? true : false;
            $statistic->update($request);
            return success(["statistic" => $request]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try {
            $statistic = Statistic::find($id);
            if(!$statistic) return notFoundElement();
            $statistic = $statistic->delete();
            return success(["statistic" => $statistic]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change activation statistic
     *
     * @param  \App\Models\statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function activation( $id)
    {
        try {
            $statistic = Statistic::find($id);
            if(!$statistic) return notFoundElement();

            $statistic->update([
                "active" => !$statistic->active,
            ]);
            return success(["active" => $statistic->active]);

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
            return Excel::download(new StatisticExcel, 'statistic.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

}
