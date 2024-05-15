<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;

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



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('employee', 'admin.create');


Route::group(['middleware'=> ['auth', 'has.permission']], function(){

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::resource('departments', 'DepartmentController');
    Route::get('/department-list', 'DepartmentController@getDepartment');

    

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');
    Route::get('/user-list', 'UserController@listOfUser');

    Route::resource('permissions', 'PermissionController');

    Route::resource('notices', 'NoticeController');

    Route::resource('leaves', 'LeaveController');
    Route::post('accept-reject-leave\{id}', 'LeaveController@acceptReject')->name('accept.reject');

    Route::get('/mail', 'MailController@create');

    Route::post('/mail', 'MailController@store')->name('mails.store');

    Route::resource('rooms', 'RoomController');

    Route::get('/room-list', 'RoomController@getRooms');

    Route::get('/import-employee', 'EmployeeController@index')->name('import.excel');
    Route::post('/import-employee', 'EmployeeController@import');

    Route::resource('employee', 'EmployeeController');
   
    Route::post('create-user\{id}', 'EmployeeController@createUser')->name('create.user');


    Route::post('/import-department', 'DepartmentController@import');

    Route::get('search-employee','EmployeeController@searchEmployee')->name('search.employee');

    Route::resource('meeting', 'MeetingController');

    Route::post('/meeting/create', [MeetingController::class, 'store'])->name('meetings.store');


    Route::get('/meetings/all', [MeetingController::class, 'index'])->name('meetings.all');
    Route::get('/meetings/upcoming', [MeetingController::class, 'upcoming'])->name('meetings.upcoming');
    //Route::get('/meetings/pending', [MeetingController::class, 'pending'])->name('meetings.pending');
    Route::get('/meetings/pending', [MeetingController::class, 'showDashboard'])->name('meetings.pending');


    Route::get('/dashboard', [MeetingController::class, 'showDashboard'])->name('dashboard');


});



