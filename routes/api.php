<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\FCMPushController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@login');


// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::get('/room-list', 'RoomController@roomList');
// });




Route::post('/password/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/password/verify-otp', [ResetPasswordController::class, 'verifyOTP']);
Route::post('/password/reset', [ResetPasswordController::class, 'passwordReset']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    //Route::get('/employee-list', 'EmployeeController@employeeList');

});

// Unauthenticated routes
Route::group(['middleware' => ['auth.api']], function () {
    // Define unauthenticated routes here
    Route::post('/user/change-password', [ChangePasswordController::class, 'changePassword']);
    Route::post('/meeting/create', [MeetingController::class, 'createMeeting'])->name('meetings.createMeeting');

    Route::get('/meeting/all', [MeetingController::class, 'getAllMeetins'])->name('meetings.allmeetings');

    Route::get('/meeting/by-date', [MeetingController::class, 'getMeetingsByDate']);

    Route::post('/meeting/update-status/{id}', [MeetingController::class, 'updateMeetingStatus'])->name('meeting.update.app');


    Route::post('/meeting/reschedule/{id}', [MeetingController::class, 'reschedule'])->name('meeting.reschedule');


    Route::get('/user-info', [UserController::class, 'userInfo'])->name('user-info');

    Route::post('/user-logout', [AuthController::class, 'logout'])->name('user-logout');

    Route::get('/room-list', 'RoomController@roomList');
    Route::get('/employee-list', 'EmployeeController@getEmployee');


    Route::get('/dashboard', 'MeetingController@getSummary');


    Route::post('/save-token', [FCMPushController::class, 'saveToken'])->name('save-token');
    Route::post('/send-notification', [FCMPushController::class, 'sendNotification'])->name('send.notification');

});
