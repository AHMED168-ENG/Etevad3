<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CoverageController;
use App\Http\Controllers\AchivementController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\SponserController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\SetingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\EventRecordingsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/excel', 'excelFile');
    });
});

Route::prefix('event')->group(function () {
    Route::controller(EventController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/activeEvent', 'activeEvent');

    });
});

Route::prefix('news')->group(function () {
    Route::controller(NewsController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastNews', 'lastNews');
        Route::get('/ActiveNews', 'ActiveNews');
    });
});
Route::prefix('coverage')->group(function () {
    Route::controller(CoverageController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastCoverage', 'lastCoverage');
        Route::get('/activeCoverages', 'activeCoverages');
    });
});
Route::prefix('achivement')->group(function () {
    Route::controller(AchivementController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastThree', 'lastThree');
        Route::get('/achivementTypes', 'achivementTypes');
        Route::get('/activeAchivement', 'activeAchivement');
    });
});
Route::prefix('statistic')->group(function () {
    Route::controller(StatisticController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastStatistic', 'lastStatistic');
    });
});
Route::prefix('role')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('/excel', 'excelFile');
    });
});
Route::prefix('permission')->group(function () {
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/excel', 'excelFile');
    });
});
Route::prefix('hero')->group(function () {
    Route::controller(HeroController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastHeros', 'lastHeros');
    });
});
Route::prefix('sponser')->group(function () {
    Route::controller(SponserController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/lastSponser', 'lastSponser');
    });
});
Route::prefix('contact')->group(function () {
    Route::controller(ContactUsController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::post('/store', 'store');
    });
});
Route::prefix('report')->group(function () {
    Route::controller(ReportController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/activeReports', 'activeReports');
        Route::get('/downloadPdf/{id}', 'downloadPdf');
    });
});
Route::prefix('director')->group(function () {
    Route::controller(DirectorController::class)->group(function () {
        Route::get('/excel', 'excelFile');
        Route::get('/activeDirectors', 'activeDirectors');
    });
});
Route::prefix('event-recordings')->group(function () {
    Route::controller(DirectorController::class)->group(function () {
        Route::get('/excel', 'excelFile');
    });
});
Route::prefix('about-us')->group(function () {
    Route::controller(AboutUsController::class)->group(function () {
        Route::get('/index', 'show');
    });
});
