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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('employee', 'admin.create');

Route::resource('departments', 'DepartmentController');
Route::get('/departments', 'DepartmentController@getDepartment');


Route::resource('roles', 'RoleController');

Route::resource('users', 'UserController');
Route::get('/users', 'UserController@listOfUser');



Route::resource('leaves', 'LeaveController');

