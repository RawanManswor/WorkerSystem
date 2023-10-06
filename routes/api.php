<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController,WorkerController,ClientController,PostController};

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
Route::middleware('DbBackup')->prefix('auth')->group(function (){

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
});
