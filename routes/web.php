<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatasetController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\OrganitasionsController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\DatasetController as UserDatasetController;
use App\Http\Controllers\User\ResourceController as UserResourceController;
use App\Http\Controllers\User\TestController;
use App\Models\Datasets;
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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/', [LoginController::class, 'authenticate'])->name('login');

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    //datasets
    Route::resource('datasets', UserDatasetController::class);
    //resources
    Route::get('datasets/resources/{id}', [UserResourceController::class, 'index'])->name('resources.index');
    Route::get('datasets/resources/create/{id}', [UserResourceController::class, 'create'])->name('resources.create');
    Route::get('datasets/new-resource/create/{id}', [UserResourceController::class, 'newResource'])->name('resource.new-resource');
    Route::post('datasets/resources/new-store/{id}', [UserResourceController::class, 'storeNew'])->name('resources.new-store');
    Route::post('datasets/resources/store/{id}', [UserResourceController::class, 'store'])->name('resources.store');
    //
    Route::get('datasets/resources/syncron/{id}', [UserResourceController::class, 'syncron'])->name('resources.syncron');
    //
    Route::get('datasets/resources/preview/{id}', [UserResourceController::class, 'preview'])->name('resources.preview');
    Route::get('datasets/resources/edit/{id}', [UserResourceController::class, 'edit'])->name('resources.edit');
    Route::put('datasets/resources/update/{id}', [UserResourceController::class, 'update'])->name('resources.update');
    Route::delete('datasets/resources/destroy/{id}', [UserResourceController::class, 'destroy'])->name('resources.destroy');
    //test
    Route::get('test/{id}', [TestController::class, 'index'])->name('test.index');
    Route::post('test/store/{id}', [TestController::class, 'store'])->name('test.store');
    //logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group(['prefix' => 'internal', 'as' => 'admin.'], function () {
    //Login
    Route::get('', [LoginAdminController::class, 'index'])->name('login')->middleware('guest');
    Route::post('', [LoginAdminController::class, 'authenticate'])->name('login');
    //middleware auth admin
    Route::middleware('auth:admin')->group(function () {
        //dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //organisations
        Route::resource('organisations', OrganitasionsController::class);
        //users
        Route::resource('users', UserController::class);
        //groups
        Route::resource('groups', GroupController::class);
        //datasets
        Route::resource('datasets', DatasetController::class);
        //resources
        Route::get('datasets/resources/{id}', [ResourceController::class, 'index'])->name('resources.index');
        Route::get('datasets/resources/create/{id}', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('datasets/resources/store/{id}', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('datasets/resources/preview/{id}', [ResourceController::class, 'preview'])->name('resources.preview');
        Route::get('datasets/resources/edit/{id}', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::put('datasets/resources/update/{id}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('datasets/resources/destroy/{id}', [ResourceController::class, 'destroy'])->name('resources.destroy');
        //logout
        Route::get('logout', [LoginAdminController::class, 'logout'])->name('logout');
    });
});
