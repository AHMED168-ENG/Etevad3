<?php

namespace App\Http\Controllers;

use App\Models\Seting;
use Illuminate\Http\Request;
use Validator;

class SetingController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin");
        $this->middleware('can:اعدادات الموقع', ['only' => ['show']]);
        $this->middleware('can:تغير حاله الموقع', ['only' => ['activation']]);
        $this->middleware('can:تعديل اعدادات الموقع', ['only' => ['update']]);
        $this->middleware('can:ارفاق اللوجو العلوي للاعدادات', ['only' => ['upload_site_upper_logo']]);
        $this->middleware('can:ارفاق اللوجو السفلي للاعدادات', ['only' => ['upload_site_lower_logo']]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seting  $seting
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $seting = Seting::first();
            return success(["seting" => $seting]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }

    /**
     * Display the specified resource. activation
     *
     * @param  \App\Models\Seting  $seting
     * @return \Illuminate\Http\Response
     */
    public function activation()
    {
        try {
            $seting = Seting::first();
            if(!$seting) return notFoundElement();

            $seting->update([
                "site_active" => !$seting->site_active,
            ]);
            return success(["site_active" => $seting->site_active]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seting  $seting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $request->request->remove('site_lower_logo');
            $request->request->remove('site_upper_logo');
            $seting = Seting::first();
            $request = $request->all();
            $validation = Validator::make($request,[
                "site_address" => "required",
                "site_phone" => "required",
                "site_email" => "required",
                "site_name" => "required",
                "site_summary" => "required",
                "site_slogan" => "required",
                "site_facebook" => "url",
                "site_instegram" => "url",
                "site_tiktok" => "url",
                "site_youtube" => "url",
                "site_snapchate" => "url",
                // "site_upper_logo" => "required",
                // "site_lower_logo" => "required",
                "site_keywords" => "required",
                "site_description" => "required",
                "site_active" => "required",
            ] , [
                "site_address.required" => "ادخل العنوان الخاص بالموقع ",
                "site_phone.required" => "اخل التليفون الخاص بالموقع",
                "site_email.required" => "ادخل الايميل الخاص بالموقع",
                "site_name.required" => "ادخل الاسم الخاص بالموقع",
                "site_summary.required" => "ادخل الملخص الخاص بالموقع",
                "site_slogan.required" => "ادخل الشعار الخاص بالموقع",
                "site_facebook.url" => "هذا الحقل يستقبل لينك",
                "site_instegram.url" => "هذا الحقل يستقبل لينك",
                "site_tiktok.url" => "هذا الحقل يستقبل لينك",
                "site_youtube.url" => "هذا الحقل يستقبل لينك",
                "site_snapchate.url" => "هذا الحقل يستقبل لينك",
                // "site_upper_logo.required" => "يجب ادخال اللوجو العلوي الخاص بالموقع",
                // "site_lower_logo.required" => "يجب ادخال اللوجو السفلي الخاص بالموقع",
                "site_keywords.required" => "ادخل الكلمات المعبره عن الموقع مفصوله ب ,",
                "site_description.required" => "ادخل الوصف الخاص بالموقع ",
                "site_active.required" => "ادخل حاله الموقع سواء مغلق او متاح",

            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["site_active"] = $request["site_active"] == "1" ? true : false;
            $seting = $seting->update($request);
            return success(["seting" => $request]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change site lower logo
     *
     * @param  \App\Models\seting  $seting
     * @return \Illuminate\Http\Response
     */
    public function upload_site_lower_logo(Request $request)
    {
        try {
            $seting = seting::first();
            $validation = Validator::make($request->all() ,
            [
                "site_lower_logo" => "required|mimes:jpg,jpeg,png,bmp,tiff|max:4096",

            ] , [
                "site_lower_logo.required" => "يجب ارفاق الصوره",
                "site_lower_logo.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff",
                "site_lower_logo.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);
            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($seting->site_lower_logo) {
                deleteFile($seting->site_lower_logo , "images/seting");
                $site_lower_logo = uploud_file($request -> site_lower_logo , "images/seting");
            } else {
                $site_lower_logo = uploud_file($request -> site_lower_logo , "images/seting");
            }

            $seting->update([
                "site_lower_logo" => $site_lower_logo
            ]);
            return success(["site_lower_logo" => $site_lower_logo]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change site_upper_logo
     *
     * @param  \App\Models\seting  $seting
     * @return \Illuminate\Http\Response
     */
    public function upload_site_upper_logo(Request $request)
    {
        try {
            $seting = seting::first();
            $validation = Validator::make($request->all() ,
            [
                "site_upper_logo" => "required|mimes:jpg,jpeg,png,bmp,tiff|max:4096",

            ] , [
                "site_upper_logo.required" => "يجب ارفاق الصوره",
                "site_upper_logo.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff",
                "site_upper_logo.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($seting->site_upper_logo) {
                deleteFile($seting->site_upper_logo , "images/seting");
                $site_upper_logo = uploud_file($request -> site_upper_logo , "images/seting");
            } else {
                $site_upper_logo = uploud_file($request -> site_upper_logo , "images/seting");
            }

            $seting->update([
                "site_upper_logo" => $site_upper_logo
            ]);
            return success(["site_upper_logo" => $site_upper_logo]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

}
