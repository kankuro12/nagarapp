<?php

use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FireBaseController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::match(['get', 'post'], 'login',[AuthController::class,'simpleLogin'])->name('login');

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::match(['get', 'post'], 'login',[AuthController::class,'login'])->name('login');
    });
});

Route::middleware(['adminauth'])->group(function () {

    route::name('superadmin.')->middleware('level:0')->group(function(){
        Route::name('user.')->prefix('superadmin')->group(function(){
            Route::get('user', [AdminController::class,'index'])->name('index');
            Route::match(['GET','POST'],'add', [AdminController::class,'add'])->name('add');
            Route::match(['GET','POST'],'edit/{user}', [AdminController::class,'edit'])->name('edit');
            Route::match(['GET','POST'],'del/{user}', [AdminController::class,'del'])->name('del');
            Route::match(['GET','POST'],'changepass/{user}', [AdminController::class,'changepass'])->name('changepass');
        });
        Route::name('setting.')->prefix('setting')->group(function(){
            Route::get('', [SettingController::class,'index'])->name('index');
                Route::name('membertype.')->prefix('membertype')->group(function(){
                    Route::match(['GET','POST'],'add', [SettingController::class,'mt_add'])->name('add');
                    Route::match(['GET','POST'],'edit/{mt}', [SettingController::class,'mt_edit'])->name('edit');
                    Route::match(['GET','POST'],'del/{mt}', [SettingController::class,'mt_del'])->name('del');
                });
                Route::name('memberlevel.')->prefix('memberlevel')->group(function(){
                    Route::match(['GET','POST'],'add', [SettingController::class,'ml_add'])->name('add');
                    Route::match(['GET','POST'],'edit/{ml}', [SettingController::class,'ml_edit'])->name('edit');
                    Route::match(['GET','POST'],'del/{ml}', [SettingController::class,'ml_del'])->name('del');
                });
        });
    });

    route::name('admin.')->prefix('admin')->middleware('level:1')->group(function(){
        Route::name('member.')->prefix('member')->group(function(){
            Route::get('', [MemberController::class,'index'])->name('index');
            Route::match(['GET','POST'],'load', [MemberController::class,'load'])->name('load');
            Route::match(['GET','POST'],'loadPhone', [MemberController::class,'loadPhone'])->name('load-phone');
            Route::match(['GET','POST'],'add', [MemberController::class,'add'])->name('add');
            Route::match(['GET','POST'],'edit/{member}', [MemberController::class,'edit'])->name('edit');
            Route::match(['GET','POST'],'channels/{member}', [MemberController::class,'channels'])->name('channels');
            Route::match(['GET','POST'],'del', [MemberController::class,'del'])->name('del');
            Route::match(['GET','POST'],'changepass/{member}', [MemberController::class,'changepass'])->name('changepass');
        });
        Route::name('alert.')->prefix('alert')->group(function(){
            Route::get('', [AlertController::class,'index'])->name('index');
            Route::get('add', [AlertController::class,'add'])->name('add');
            Route::post('save', [AlertController::class,'save'])->name('save');
        });
    });
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');
});

Route::name('firebase.')->prefix('firebase')->group(function(){
    Route::get('subscribe', [FireBaseController::class,'subscribe'])->name('subscribe');
    Route::get('test/{id}', [FireBaseController::class,'test']);
    Route::get('/test1', function () {
        return view('welcome');
    })->name('data');
});

