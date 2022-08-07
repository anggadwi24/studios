<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\SubmodulController;
use App\Http\Controllers\DashboardController;

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

Route::get('/auth',[AuthController::class,'index'])->name('auth')->middleware('guest');
Route::post('/auth',[AuthController::class,'do'])->name('auth')->middleware('guest');
Route::post('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('/');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('/dashboard/dataMenu',[DashboardController::class,'dataMenu']);




    // Modul
    Route::get('/modul',[ModulController::class, 'index'])->name('modul');
    Route::post('/modul/data',[ModulController::class, 'data'])->name('modul.data');
    Route::get('/modul/add',[ModulController::class, 'add'])->name('modul.add');
    Route::post('/modul/insert',[ModulController::class, 'store'])->name('modul.store');
    Route::get('/modul/edit/{id}',[ModulController::class, 'edit'])->name('modul.edit');
    Route::post('/modul/update/{id}',[ModulController::class, 'update'])->name('modul.update');
    Route::get('/modul/delete/{id}',[ModulController::class, 'destroy'])->name('modul.delete');
    // Modul
    
    // Submodul
    Route::get('/submodul',[SubmodulController::class, 'index'])->name('submodul');
    Route::get('/submodul/add',[SubmodulController::class, 'add'])->name('submodul.add');
    Route::post('/submodul/data',[SubmodulController::class, 'data'])->name('submodul.data');
    Route::post('/submodul/store',[SubmodulController::class, 'store'])->name('submodul.store');
    Route::get('/submodul/edit/{id}',[SubmodulController::class, 'edit'])->name('submodul.edit');
    Route::post('/submodul/update/{id}',[SubmodulController::class, 'update'])->name('submodul.update');
    Route::get('/submodul/delete/{id}',[SubmodulController::class, 'destroy'])->name('submodul.delete');
    // Submodul
    
    
    // Users
    Route::get('/user',[UserController::class, 'index'])->name('user');
    Route::get('/user/add',[UserController::class, 'add'])->name('user.add');
    Route::post('/user/data',[UserController::class, 'data'])->name('user.data');
    Route::post('/user/store',[UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}',[UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}',[UserController::class, 'update'])->name('user.update');
    Route::get('/user/delete/{id}',[UserController::class, 'destroy'])->name('user.delete');
    Route::get('/user/modul/{id}',[UserController::class, 'modul'])->name('user.modul');
    Route::post('/user/modul/{id}',[UserController::class, 'storeModul'])->name('user.modul.store');
    Route::get('/user/deleteAkses/{id}',[UserController::class, 'deleteAkses'])->name('user.modul.delete');
    Route::get('/user/set/{id}/{status}',[UserController::class, 'setting'])->name('user.setting');
    Route::get('/user/find',[UserController::class, 'find'])->name('user.find');  
    // User
    

    // Category
    Route::get('/category',[CategoryController::class, 'index'])->name('category');
    Route::get('/category/add',[CategoryController::class, 'add'])->name('category.add');
    Route::get('/category/notif',[CategoryController::class, 'notif'])->name('category.notif');

    Route::post('/category/data',[CategoryController::class, 'data'])->name('category.data');
    Route::post('/category/store',[CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}',[CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}',[CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/delete/{id}',[CategoryController::class, 'destroy'])->name('category.delete');
    
    // Category

    Route::get('/product/{any}',[CategoryController::class, 'destroy']);
});


