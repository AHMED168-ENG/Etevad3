<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthAdminController;
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
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
    ********** this part about auth user ********
*/


Route::prefix('admin')->group(function () {
/*
    ********** this part about dashboard statistic ********
*/
Route::prefix('')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/statistic', 'statistic');
    });
});
/*
/*
    ********** this part dashboard statistic ********
*/
Route::prefix('role')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/all', 'all');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::get('/show/{id}', 'show');
        Route::delete('/delete/{id}', 'delete');
    });
});
/*
    ********** this part about user role ********
*/
/*
    ********** this part about permissions for role ********
*/
Route::prefix('permission')->group(function () {
    Route::controller(PermissionController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/all', 'all');
        Route::get('/index', 'index');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'delete');
    });
});
/*
    ********** this part about permission for role ********
*/

/*
    ********** this part about auth user ********
*/
Route::prefix('auth')->group(function () {
    Route::controller(AuthAdminController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('me', 'me');
    });
});
/*
    ********** this part about auth user ********
*/

/*
    ********** this part about user operations ********
*/
Route::prefix('user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/file/{id}', 'uploadFile');
        Route::put('/updatePersonalData', 'updatePersonalData');
    });
});
/*
    ********** this part about user operations ********
*/


/*
    ********** this part about event operations ********
*/
Route::prefix('event')->group(function () {
    Route::controller(EventController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/file/{id}', 'uploadFile');
    });
});
/*
    ********** this part about event operations ********
*/


/*
    ********** this part about news operations ********
*/
Route::prefix('news')->group(function () {
    Route::controller(NewsController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/file/{id}', 'uploadFile');
    });
});
/*
    ********** this part about news operations ********
*/

/*
    ********** this part about coverage operations ********
*/
Route::prefix('coverage')->group(function () {
    Route::controller(CoverageController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::get('/show/{id}', 'show');

    });
});
/*
    ********** this part about coverage operations ********
*/

/*
    ********** this part about achivement operations ********
*/
Route::prefix('achivement')->group(function () {
    Route::controller(AchivementController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/image/{id}', 'upload_achivement_image');
        Route::post('/upload/icon/{id}', 'upload_achivement_icon');

    });
});
/*
    ********** this part about achivement operations ********
*/

/*
    ********** this part about statistic operations ********
*/
Route::prefix('statistic')->group(function () {
    Route::controller(StatisticController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');


    });
});
/*
    ********** this part about statistic operations ********
*/

/*
    ********** this part about hero operations ********
*/
Route::prefix('hero')->group(function () {
    Route::controller(HeroController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::get('/index', 'index');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/file/{id}', 'uploadFile');

    });
});
/*
    ********** this part about hero operations ********
*/

/*
    ********** this part about sponser operations ********
*/
Route::prefix('sponser')->group(function () {
    Route::controller(SponserController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::get('/index', 'index');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/activation/{id}', 'activation');
        Route::post('/upload/file/{id}', 'uploadFile');
    });
});
/*
    ********** this part about sponser operations ********
*/


/*
    ********** this part about contact us operations ********
*/
Route::prefix('contact')->group(function () {
    Route::controller(ContactUsController::class)->group(function () {
        Route::post('/store', 'store');
        Route::get('/index', 'index');
        Route::get('/lastMessage', 'lastMessage');
        Route::delete('/delete/{id}', 'destroy');
        Route::put('/seening/{id}', 'changeSeening');
        Route::get('/show/{id}', 'show');
    });
});
/*
    ********** this part about contact us operations ********
*/


/*
    ********** this part about contact us operations ********
*/
Route::prefix('seting')->group(function () {
    Route::controller(SetingController::class)->group(function () {
        Route::get('/index', 'show');
        Route::post('/update', 'update');
        Route::put('/activation', 'activation');
        Route::post('/upload/lower_logo', 'upload_site_lower_logo');
        Route::post('/upload/upper_logo', 'upload_site_upper_logo');


    });
});
/*
    ********** this part about contact us operations ********
*/


/*
    ********** this part about report operations ********
*/
Route::prefix('report')->group(function () {
    Route::controller(ReportController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::put('/activation/{id}', 'activation');
        Route::delete('/delete/{id}', 'destroy');
        Route::post('/upload/pdf/{id}', 'uploadFile');



    });
});
/*
    ********** this part about report operations ********
*/


/*
    ********** this part about director operations ********
*/
Route::prefix('director')->group(function () {
    Route::controller(DirectorController::class)->group(function () {
        Route::get('/index', 'index');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::put('/activation/{id}', 'activation');
        Route::delete('/delete/{id}', 'destroy');
        Route::post('/upload/file/{id}', 'uploadFile');



    });
});
/*
    ********** this part about director operations ********
*/


/*
    ********** this part about director operations ********
*/
Route::prefix('event-recordings')->group(function () {
    Route::controller(EventRecordingsController::class)->group(function () {
        Route::get('/index', 'index');
        Route::get('/lastRecordings', 'lastRecordings');
        Route::get('/show/{id}', 'show');
        Route::post('/store', 'store');
        Route::get('/show/{id}', 'show');
        Route::put('/update/{id}', 'update');
        Route::put('/change-seening/{id}', 'changeSeening');
        Route::delete('/delete/{id}', 'destroy');



    });
});
/*
    ********** this part about director operations ********
*/


/*
    ********** this part about about us page operations ********
*/
Route::prefix('about-us')->group(function () {
    Route::controller(AboutUsController::class)->group(function () {
        Route::get('/show', 'show');
        Route::put('/update', 'update');
    });
});
/*
    ********** this part about about us page operations ********
*/

});
/*
    ********** this part about page not found ********
*/
    Route::any('{any}', function(){
        return response()->json([
            'status'    => null,
            'error'   => 'Page Not Found.',
        ], 404);
    })->where('any', '.*');
/*
    ********** this part about page not found ********
*/
