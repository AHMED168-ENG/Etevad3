<?php

namespace App\Http\Controllers;

use App\Models\Event_recordings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RecordingExcel;
use Validator;

class EventRecordingsController extends Controller
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
            $event_recordings = Event_recordings::with(["event" => function($query) {
                return $query->select(["name" , "id"]);
            }])->where("name" , "like" , "%" . $search . "%")->orWhere("email" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["event_recordings" => $event_recordings]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastRecordings(Request $request)
    {
        try {
             $search = $request->query("search");
            $event_recordings = Event_recordings::NotSeen()->with(["event" => function($query) {
                return $query->select(["name" , "id"]);
            }])->limit(6)->get();
            return success(["last_recordings" => $event_recordings]);
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
                "age" => "required|integer",
                "mobile" => "required",
                "email" => "required|email",
                "event_id" => "required",
            ] , [
                "name.required" => "يجب ادخال اسمك",
                "age.required" => "يجب ادخال عمرك",
                "age.integer" => "هذا الحقل يستقبل ارقام",
                "mobile.required" => "يجب ادخال الموبيل الخاص يك",
                "email.required" => "يجب ادخال الايميل الخاص بك",
                "email.email" =>  "هذا الحقل يستقبل ايميل",
                "event_id.required" =>  "يجب ادخال الحدث اللذي تريد التسجيل فيه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $event_recordings = Event_recordings::create($request);
            return success(["event_recordings" => $event_recordings]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event_recordings  $event_recordings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $event_recordings = Event_recordings::with(["event" => function($query) {
                return $query->select(["name" , "id"]);
            }])->find($id);
            if(!$event_recordings) return notFoundElement();
            return success(["event_recording" => $event_recordings]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event_recordings  $event_recordings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $event_recordings = Event_recordings::find($id);
            if(!$event_recordings) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request,[
                "name" => "required",
                "age" => "required",
                "mobile" => "required",
                "email" => "required|email",
                "event_id" => "required",
            ] , [
                "name.required" => "يجب ادخال اسمك",
                "age.required" => "يجب ادخال عمرك",
                "mobile.required" => "يجب ادخال الموبيل الخاص يك",
                "email.required" => "يجب ادخال الايميل الخاص بك",
                "email.email" =>  "هذا الحقل يستقبل ايميل",
                "event_id.required" =>  "يجب ادخال الحدث اللذي تريد التسجيل فيه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $event_recordings->update($request);
            return success(["event_recordings" => $event_recordings]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event_recordings  $event_recordings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $event_recordings = Event_recordings::find($id);
            if(!$event_recordings) return notFoundElement();

            $event_recordings = $event_recordings->delete();
            return success(["event_recordings" => $event_recordings]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change event recording seen
     *
     * @param  \App\Models\Contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function changeSeening($id)
    {
        try {
            $event_recordings = Event_recordings::find($id);
            if(!$event_recordings) return notFoundElement();
            $event_recordings->update([
                "is_seen" => !$event_recordings -> is_seen
            ]);
            return success(["is_seen" => $event_recordings -> is_seen]);
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
            return Excel::download(new RecordingExcel, 'recordings.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
