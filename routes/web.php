<?php

use App\Http\Controllers\Dashboard\CategoryController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\SubjectController;
use App\Http\Controllers\Dashboard\TermController;
use App\Http\Controllers\Dashboard\StudentController;

Auth::routes();

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return 'cach clear success';
});


Route::get('/', function () {
    return view('auth.login');
});



Route::group(
    [
        'prefix'     => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {

        Route::get('/dashboard/home','HomeController@index')->name('dashboard.home')->middleware('admin');

        Route::prefix('dashboard')->namespace('Dashboard')->middleware(['auth','admin'])->name('dashboard.')->group(function () {

            Route::resource('categories', 'CategoryController');

            Route::resource('users', 'UserController');

            Route::resource('roles', 'RoleController');
            Route::resource('countries','CountryController');
            Route::resource('classrooms','ClassroomController');
            Route::resource('subjects','SubjectController');
            Route::resource('terms','TermController');
            Route::resource('teachers','TeacherController');
            Route::resource('students','StudentController');

        });

       
    });

