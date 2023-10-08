<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController,WorkerController,ClientController,PostController};
use App\Http\Controllers\AdminDashboard\{AdminNotificationController,StatusPostController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API roustes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(function (){

    Route::controller(AdminController::class )->prefix('admin')->group( function () {
        Route::post('/login', 'login');
        Route::post('/register',  'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh','refresh');
        Route::get('/user-profile', 'userProfile');
    });
    Route::controller(WorkerController::class)->prefix('worker')->group( function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile','userProfile');
        Route::get('/verify/{token}','verify');
    });
    Route::controller(ClientController::class)->prefix('client')->group(function ($router) {
        Route::post('/login', 'login');
        Route::post('/register',  'register');
        Route::post('/logout','logout');
        Route::post('/refresh',  'refresh');
        Route::get('/user-profile','userProfile');
    });

});
    Route::post('/unauthorized',function (){
        return response()->json(['message'=>'Unauthorized'],401)->name('login');
    });
Route::controller(PostController::class)->prefix('worker/post')->group(function (){
    Route::post('/add','store')->middleware('auth:worker');
    Route::get('/show','index')->middleware('auth:admin');
    Route::get('/showById/{id}','showPost')->middleware('auth:admin');
    Route::get('/approved','approved');
    Route::get('/showPostApproved/{id}','showPostApproved');

});

Route::prefix('admin')->middleware('auth:admin')->group(function (){
    Route::controller(AdminNotificationController::class)->prefix('/notifications')->group(function (){
    Route::get('/all','index');
    Route::get('/unread','unread');
    Route::get('/markRead','markRead');
    Route::get('/deleteAll','delete');
    Route::get('/deleteById/{id}','deleteById');
});
    Route::controller(StatusPostController::class)->prefix('/posts')->group(function (){
        Route::post('/changeStatus','changeStatus');
    });
});
