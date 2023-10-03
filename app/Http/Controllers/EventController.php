<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventExcel;
use App\Models\Event;
use Illuminate\Http\Request;
use Validator;
use Str;
use \Carbon\Carbon;
class EventController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "activeEvent" , "show"]]);
        $this->middleware('can:كل التغطيات', ['only' => ['index']]);
        $this->middleware('can:حاله الحدث', ['only' => ['activation']]);
        $this->middleware('can:اضافه حدث', ['only' => ['store']]);
        $this->middleware('can:تعديل حدث', ['only' => ['update']]);
        $this->middleware('can:حذف حدث', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره الحدث', ['only' => ['uploadFile']]);
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
            $event = Event::where("name" , "like" , "%" . $search . "%")->orWhere("full_description" , "like" , "%" . $search . "%")->orWhere("overview" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["events" => $event]);
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
                "name" => "required|unique:events",
                "event_date" => "required|date",
                "overview" => "required",
                "full_description" => "required",
                "image" => "required|mimes:jpg,jpeg,png,bmp,tiff|max:4096",
                "page_description" => "required",
                "page_keywords" => "required",
                "active" => "required",
            ] , [
                "name.required" => "ادخل اسم الحدث",
                "name.unique" => "هذا الحدث تم تسجيله من قبل",
                "event_date.required" => "ادخل تاريخ الحدث",
                "event_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "overview.required" => "ادخل لمحه مختصره عن الحدث",
                "full_description.required" => "ادخل وصف كامل عن الحدث",
                "image.required" => "ادخل صوره الحدث",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
                "active.required" =>  "ادخل حاله الحدث",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $file = uploud_file($request["image"] , "images/event");
            $request["image"] = $file;
            $request["event_date"] = new Carbon($request["event_date"]);
            $request["slug"] = my_slug($request["name"] );
            $request["active"] = $request["active"] == "1" ? true : false;
            $event = Event::create($request);
            return success(["event" => $event]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $event = Event::find($id);
            if(!$event) return notFoundElement();
            return success(["event" => $event]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function activeEvent( )
    {
        try {
            $event = Event::Active()->paginate(5);
            return success(["event" => $event]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->request->remove('image');
            $request = $request->all();
            $event = Event::find($id);
            if(!$event) return notFoundElement();
            $validation = Validator::make($request , [
                "name" => "required|unique:events,name," . $event->id,
                "event_date" => "required",
                "overview" => "required",
                "full_description" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
            ] , [
                "name.required" => "ادخل اسم الحدث",
                "name.unique" => "هذا الحدث تم تسجيله من قبل",
                "event_date.required" => "ادخل تاريخ الحدث",
                "overview.required" => "ادخل لمحه مختصره عن الحدث",
                "full_description.required" => "ادخل وصف كامل عن الحدث",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
                "active.required" =>  "ادخل حاله الحدث",
            ]);
            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }
            $request["slug"] = my_slug($request["name"]);
            $request["active"] = $request["active"] == "1" ? true : false;
            $request["event_date"] = new Carbon($request["event_date"]);
            $event = $event->update($request);
            return success(["event" => $request]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::find($id);
            if(!$event) return notFoundElement();

            if($event -> image) {
                deleteFile($event->image , "images/event");
            }

            $event = $event->delete();
            return success(["event" => $event]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change activation event
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function activation( $id)
    {
        try {
            $event = Event::find($id);
            if(!$event) return notFoundElement();
            $event->update([
                "active" => !$event->active,
            ]);
            return success(["active" => $event->active]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change event image event
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request , $id)
    {
        try {
            $event = Event::find($id);
            if(!$event) return notFoundElement();
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

            if($event->image) {
                deleteFile($event->image , "images/event");
                $file = uploud_file($request -> image , "images/event");
            } else {
                $file = uploud_file($request -> image , "images/event");

            }

            $event->update([
                "image" => $file
            ]);
            return success(["image" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }


    /**
     * excel event
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new EventExcel, 'events.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

}
