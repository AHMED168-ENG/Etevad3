<?php

namespace App\Http\Controllers;

use App\Models\Contact_us;
use Illuminate\Http\Request;
use Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MessageExcel;

class ContactUsController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "store"]]);
        $this->middleware('can:كل الرسائل', ['only' => ['index']]);
        $this->middleware('can:تفاصيل الرساله', ['only' => ['show']]);
        $this->middleware('can:تغير رؤيه الرساله', ['only' => ['changeSeening']]);
        $this->middleware('can:حذف الرساله', ['only' => ['destroy']]);
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
            $contact_us = Contact_us::where("title" , "like" , "%" . $search . "%")->orWhere("message" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["messages" => $contact_us]);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastMessage(Request $request)
    {
        try {
            $contact_us = Contact_us::NotSeen()->orderBy("created_at" , "desc")->limit(6)->get();
            return success(["messages" => $contact_us]);
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
                "email" => "required|email",
                "age" => "required",
                "phone" => "required",
                "title" => "required",
                "message" => "required",
            ] , [
                "name.required" => "ادخل اسمك",
                "email.required" => "ادخل الايميل الخاص بك",
                "email.email" => "ادخل ايميل صحيح",
                "age.required" => "ادخل عمرك",
                "phone.required" => "ادخل رقمك",
                "title.date" => "ادخل عنوان الرساله",
                "message.required" => "ادخل محتوي الرسال",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $contact_us = Contact_us::create($request);
            return success(["contact_us" => $contact_us]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }


    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Contact_us  $contact_us
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $contact_us = Contact_us::find($id);
    //         $request = $request->all();
    //         $validation = Validator::make($request,[
    //             "name" => "required",
    //             "email" => "required|email",
    //             "age" => "required",
    //             "phone" => "required",
    //             "title" => "required",
    //             "message" => "required",
    //         ] , [
    //             "name.required" => "ادخل اسمك",
    //             "email.required" => "ادخل الايميل الخاص بك",
    //             "age.required" => "ادخل عمرك",
    //             "phone.required" => "ادخل رقمك",
    //             "title.date" => "ادخل عنوان الرساله",
    //             "message.required" => "ادخل محتوي الرسال",
    //         ]);

    //         if($validation->fails()) {
    //             $errors = $validation->errors();
    //             return validationError($errors);
    //         }

    //         $contact_us->update($request);
    //         return success(["contact_us" => $request]);

    //     } catch (\Throwable $th) {
    //        return errorMessage($th);
    //     }
    // }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact_us  $Contact_us
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        try {
            $message = Contact_us::find($id);
            if(!$message) return notFoundElement();
            return success(["message" => $message]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $contact_us = Contact_us::find($id);
            if(!$contact_us) return notFoundElement();
            $contact_us = $contact_us->delete();
            return success(["contact_us" => $contact_us]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change message seen
     *
     * @param  \App\Models\Contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function changeSeening($id)
    {
        try {
            $contact_us = Contact_us::find($id);
            if(!$contact_us) return notFoundElement();
            $contact_us->update([
                "is_seen" => !$contact_us -> is_seen
            ]);
            return success(["is_seen" => $contact_us -> is_seen]);
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
            return Excel::download(new MessageExcel, 'Messages.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

}
