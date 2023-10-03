<?php

namespace App\Http\Controllers;

use App\Models\About_us;
use Illuminate\Http\Request;
use Validator;

class AboutUsController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => "show"]);
        // $this->middleware('can:صفحه عنا', ['only' => ['show']]);
        $this->middleware('can:تعديل صفحه عنا', ['only' => ['update']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       try {
            $about_us = About_us::first();
            return success(["about_us" => $about_us]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About_us  $about_us
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $about_us = About_us::first();
            $request = $request->all();
            $validation = Validator::make($request,[
                "description" => "required",
                "vision" => "required",
                "message" => "required",
                "strategic_one_title" => "required",
                "strategic_one_content" => "required",
                "strategic_tow_title" => "required",
                "strategic_tow_content" => "required",
                "strategic_three_title" => "required",
                "strategic_three_content" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
            ] , [
                "description.required" => "ادخل العنوان الخاص بالموقع ",
                "vision.required" => "اخل التليفون الخاص بالموقع",
                "message.required" => "ادخل الايميل الخاص بالموقع",
                "strategic_one_title.required" => "ادخل الاسم الخاص بالموقع",
                "strategic_one_content.required" => "ادخل الملخص الخاص بالموقع",
                "strategic_tow_title.required" => "ادخل الشعار الخاص بالموقع",
                "strategic_tow_content.required" => "هذا الحقل يستقبل لينك",
                "strategic_three_title.required" => "هذا الحقل يستقبل لينك",
                "strategic_three_content.required" => "هذا الحقل يستقبل لينك",
                "page_keywords.required" => "ادخل الكلمات المعبره عن الصفحه مفصوله ب ,",
                "page_description.required" => "ادخل الوصف الخاص بالصفحه ",

            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

             $about_us->update($request);
            return success(["about_us" => $request]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

}
