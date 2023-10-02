<?php

namespace App\Http\Controllers;

use App\Models\About_us;
use App\Models\User;
use App\Models\Achivement;
use App\Models\News;
use App\Models\Coverage;
use App\Models\Event;
use App\Models\Statistic;
use App\Models\Director;
use App\Models\Hero;
use App\Models\Sponser;
use App\Models\Contact_us;
use App\Models\Event_recordings;
use App\Models\Report;
use Illuminate\Http\Request;
use Validator;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware("AuthAdmin");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistic()
    {
       try {
           $users = User::count();
           $achivement = Achivement::count();
           $news = News::count();
           $coverage = Coverage::count();
           $event = Event::count();
           $statistic = Statistic::count();
           $director = Director::count();
           $hero = Hero::count();
           $sponser = Sponser::count();
           $messages = Contact_us::count();
           $event_recordings = Event_recordings::count();
           $report = Report::count();
           $statistic = [
                "users" => $users,
                "achivement" => $achivement,
                "news" => $news,
                "coverage" => $coverage,
                "statistic" => $statistic,
                "director" => $director,
                "hero" => $hero,
                "sponser" => $sponser,
                "messages" => $messages,
                "event" => $event,
                "event_recordings" => $event_recordings,
                "report" => $report,
            ];
            return success(["statistic" => $statistic]);
        } catch (\Throwable $th) {
               return errorMessage($th);
        }
    }



}
