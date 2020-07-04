<?php

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

Route::get('lang/{lang}', 'LanguageController@setLang');
Route::get('getLangs', 'LanguageController@getLangs');
Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::group(['middleware' => 'lang'], function() {
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes();
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/companies', 'CompanyController@index')->name('companies.index');
    Route::get('/employees', 'EmployeeController@index')->name('employees.index');
    Route::group(['middleware' => 'auth'], function() {
        Route::resource('companies', 'CompanyController', ['except' => ['index']]);
        Route::resource('employees', 'EmployeeController', ['except' => ['index']]);
        Route::resource('roles','RoleController');
        Route::resource('users','UserController');
    });
});