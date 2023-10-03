<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Validator;
use \Carbon\Carbon;
use App\Exports\NewsExcel;
use Maatwebsite\Excel\Facades\Excel;
class NewsController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin" , ["except" => ["excelFile" , "ActiveNews" , "lastNews"]]);
        $this->middleware('can:كل الاخبار', ['only' => ['index']]);
        $this->middleware('can:حاله الخبر', ['only' => ['activation']]);
        $this->middleware('can:اضافه خبر', ['only' => ['store']]);
        $this->middleware('can:تعديل خبر', ['only' => ['update']]);
        $this->middleware('can:حذف خبر', ['only' => ['destroy']]);
        $this->middleware('can:ارفاق صوره الخبر', ['only' => ['uploadFile']]);
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
            $news = News::where("title" , "like" , "%" . $search . "%")->orWhere("full_description" , "like" , "%" . $search . "%")->paginate(+env("ELEMENTS_PER_PAGE"));
            return success(["news" => $news]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ActiveNews(Request $request)
    {
        try {
            $news = News::Active()->paginate(4);
            return success(["news" => $news]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastNews(Request $request)
    {
        try {
            $news = News::Active()->limit(4)->get();
            return success(["news" => $news]);
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
                "title" => "required|unique:news",
                "news_date" => "required|date",
                "full_description" => "required",
                "image" => "required|mimes:jpg,jpeg,png,bmp,tiff,svg|max:20096",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الخبر",
                "title.unique" => "هذا الخبر تم تسجيله من قبل",
                "news_date.required" => "ادخل تاريخ الخبر",
                "news_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "full_description.required" => "ادخل وصف كامل عن الخبر",
                "image.required" => "ادخل صوره الخبر",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff,svg",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
                "active.required" =>  "ادخل حاله الخبر",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $file = uploud_file($request["image"] , "images/news");
            $request["image"] = $file;
            $request["news_date"] = new Carbon($request["news_date"]);
            $request["slug"] = my_slug($request["title"] );
            $request["active"] = $request["active"] == "1" ? true : false;
            $news = News::create($request);
            return success(["news" => $news]);

        } catch (\Throwable $th) {
           return errorMessage($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $news = News::find($id);
            if(!$news) return notFoundElement();
            return success(["news" => $news]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->request->remove('image');
            $news = News::find($id);
            if(!$news) return notFoundElement();
            $request = $request->all();
            $validation = Validator::make($request,[
                "title" => "required|unique:news,title," . $news -> id,
                "news_date" => "required|date",
                "full_description" => "required",
                "page_keywords" => "required",
                "page_description" => "required",
                "active" => "required",
            ] , [
                "title.required" => "ادخل عنوان الخبر",
                "title.unique" => "هذا الخبر تم تسجيله من قبل",
                "news_date.required" => "ادخل تاريخ الخبر",
                "news_date.date" => "هذا الحقل يستقبل تاريخ فقط",
                "full_description.required" => "ادخل وصف كامل عن الخبر",
                "active.required" =>  "ادخل حاله الخبر",
                "page_keywords.required" =>  "ادخل الكلمات المعبره عن الصفحه",
                "page_description.required" =>  "ادخل الوصف المعبر عن الصفحه",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $request["news_date"] = new Carbon($request["news_date"]);
            $request["slug"] = my_slug($request["title"] );
            $request["active"] = $request["active"] == "1" ? true : false;
            $news = $news->update($request);
            return success(["news" => $news]);

        } catch (\Throwable $th) {
            return  errorMessage($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $news = news::find($id);
            if(!$news) return notFoundElement();
            if($news -> image) {
                deleteFile($news->image , "images/news");
            }
            $news = $news->delete();
            return success(["news" => $news]);
        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change activation news
     *
     * @param  \App\Models\news  $news
     * @return \Illuminate\Http\Response
     */
    public function activation($id)
    {
        try {
            $news = News::find($id);
            if(!$news) return notFoundElement();

            $news->update([
                "active" => !$news->active,
            ]);
            return success(["active" => $news->active]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * change news image news
     *
     * @param  \App\Models\news  $news
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request ,$id)
    {
        try {
            $news = news::find($id);
            if(!$news) return notFoundElement();
            $validation = Validator::make($request->all() ,
            [
                "image" => "required|mimes:jpg,jpeg,png,bmp,tiff,svg|max:20096",
            ] , [
                "image.required" => "يجب ارفاق الصوره",
                "image.mimes" => "يجب ان يكون نوع الصوره اما jpg,jpeg,png,bmp,tiff,svg",
                "image.max" => "الملف لا يجب ان يتعدي 4 mb",
            ]);

            if($validation->fails()) {
                return validationError($validation->errors());
            }

            if($news->image) {
                deleteFile($news->image , "images/news");
                $file = uploud_file($request -> image , "images/news");

            } else {
                $file = uploud_file($request -> image , "images/news");

            }
            $news->update([
                "image" => $file
            ]);
            return success(["image" => $file]);

        } catch (\Throwable $th) {
           return  errorMessage($th);
        }
    }

    /**
     * excel news
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excelFile(Request $request )
    {
        try {
            return Excel::download(new NewsExcel, 'news.xlsx');
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }
}
