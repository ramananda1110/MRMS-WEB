<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\ChangePasswordController;


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

// Route::view('employee', 'admin.create');


Route::group(['middleware'=> ['auth', 'has.permission']], function(){

    Route::get('/', function () {

        return view('welcome');
    });
    


    Route::get('/', [MeetingController::class, 'dashboardMeetingCount'])->name('meeting.count');
    

    Route::post('/change-password', [ChangePasswordController::class, 'changePasswordByWeb'])->name('password.change');


    Route::resource('departments', 'DepartmentController');
    Route::get('/department-list', 'DepartmentController@getDepartment');


    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');

    Route::post('/user/update-status/{id}', [UserController::class, 'updateUserStatus'])->name('user.updateStatus');
    Route::post('user/export-excel', [UserController::class, 'exportExcel'])->name('user.download-excel');


    Route::get('/user-list', 'UserController@listOfUser');

    Route::resource('permissions', 'PermissionController');

    Route::resource('notices', 'NoticeController');

    Route::resource('leaves', 'LeaveController');
    Route::post('accept-reject-leave\{id}', 'LeaveController@acceptReject')->name('accept.reject');

    Route::get('/mail', 'MailController@create');

    Route::post('/mail', 'MailController@store')->name('mails.store');

    Route::resource('rooms', 'RoomController');

    Route::get('/room-list', 'RoomController@getRooms');


    // Employee Data

    Route::resource('employee', 'EmployeeController');


    // Define resource routes for other CRUD operations
    //  Route::resource('employee', EmployeeController::class);

    Route::post('/import-employee', [EmployeeController::class, 'import'])->name('import.excel');

   
    Route::post('create-user\{id}', 'EmployeeController@createUser')->name('create.user');

    Route::get('/search-employee', [EmployeeController::class, 'searchEmployee'])->name('search.employee');

    Route::resource('meeting', 'MeetingController');

    Route::post('/meeting/create', [MeetingController::class, 'store'])->name('meetings.store');

    Route::post('/meeting/update-status/{id}', [MeetingController::class, 'updateMeetingByWeb'])->name('meeting.update.web');


    Route::get('/search-meeting', [MeetingController::class, 'searchMeeting'])->name('search.meeting');

    Route::get('/meetings/all', [MeetingController::class, 'index'])->name('meetings.all');
    Route::get('/meetings/upcoming', [MeetingController::class, 'upcoming'])->name('meetings.upcoming');
    Route::get('/meetings/pending', [MeetingController::class, 'pending'])->name('meetings.pending');
    Route::get('/meetings/cenceled', [MeetingController::class, 'cenceled'])->name('meetings.cenceled');

    Route::post('meetings/export-excel', [MeetingController::class, 'exportExcel'])->name('meetings.download-excel');

    Route::get('meetings/download-pdf', [MeetingController::class, 'exportMeetingPdf'])->name('meetings.exportPdf');

    Route::get('meetings/download-csv', [MeetingController::class, 'exportMeetingCsv'])->name('meetings.exportCsv');
    Route::get('meetings/print', [MeetingController::class, 'printView'])->name('meetings.printView');


    
    Route::get('employees/download-pdf', [EmployeeController::class, 'exportPdf'])->name('employee.exportPdf');

    // Route for CSV export
    Route::get('employees/download-csv', [EmployeeController::class, 'exportCsv'])->name('employee.exportCsv');
    Route::post('employees/export-excel', [EmployeeController::class, 'exportExcel'])->name('employee.download-excel');

    Route::get('employees/print', [EmployeeController::class, 'printView'])->name('employee.printView');

});



