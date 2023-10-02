<?php

use App\models\main_catigory\catigors_models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;




/* ------------------------- start update photo ---------------------------*/
function uploud_file($file , $path) {
    if(is_array($file)) {
        $filesName = [];
    foreach ($file as $key => $value) {
        $file_extension = $value -> getClientOriginalExtension();
        $fileName = time() . "_" . $value -> getClientOriginalName() . "." . $file_extension;
        $path = $path;
        $value -> move($path , $fileName);
        $filesName[] = $fileName;
    }
    return $filesName;
    }
    /*---------------------------- الخطوه الاولي اجيب نوع الصوره سواء كانت jpeg , jpg .. ---------------*/
    $file_extension = $file -> getClientOriginalExtension();
    /*---------------------------- الخطوه الاولي اجيب نوع الصوره سواء كانت jpeg , jpg .. ---------------*/

    /*---------------------------- الخطوه الثانيه اجيب اسم الصوره  ---------------*/
    $fileName = time() . "_" . $file -> getClientOriginalName() . "." . $file_extension;
    /*---------------------------- الخطوه الثانيه اجيب اسم الصوره  ---------------*/

    /*----------------------------  الخطوه الثالثه ارفع الصوره ---------------*/
    $path = $path;
    $file -> move($path , $fileName);
    return $fileName;
    /*----------------------------  الخطوه الثالثه ارفع الصوره ---------------*/
}
/* ------------------------- end update photo ---------------------------*/
function sendMessage($type , $message) {
    $message = $message == null ? "Error 500" : $message;
    return redirect() -> back() -> with(["message" => $message , "type" => $type ]);
}
function errorMessage($error) {
    return response()->json(["status" => null , "error" => $error->getMessage()]);
}

function validationError($errors) {
    return response()->json(["status" => false , "errors" => $errors]);
}

function success($data) {
    $result = array_merge(["status" => true] , $data);
    return response()->json($result);
}

function notFoundElement() {
    return response()->json(["status" => null , "error" => "هذا العنصر غير مسجل"]);
}

/* -------------------------------------------- delete photo after edit ---------------------------------*/
function deleteFiles($files, $path) {
    foreach($files as $key => $file)
    {
        Storage::disk("public")->delete($path . "/" . $file->file);
    }

}
/* -------------------------------------------- delete photo after edit ---------------------------------*/

/* -------------------------------------------- delete photo after edit ---------------------------------*/
function deleteFile($file, $path) {
    Storage::disk("public")->delete($path . "/" . $file);
}
/* -------------------------------------------- delete photo after edit ---------------------------------*/

/* -------------------------------------------- make slug ---------------------------------*/
 function my_slug($string, $separator = '-')
{
    $string = trim($string);
    $string = mb_strtolower($string, 'UTF-8');

    // Remove multiple dashes or whitespaces or underscores
    // $string = preg_replace("/[\s-_]+/", ' ', $string) ;
    // Convert whitespaces and underscore to the given separator
    $string = preg_replace("/[\s_]/", $separator, $string);

   return rawurldecode($string);
}
/* -------------------------------------------- make slug ---------------------------------*/
