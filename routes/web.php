<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\AbsensiSholatController;
use App\Http\Controllers\iclockController;
use App\Http\Controllers\AttendanceReportController;


Route::get('devices', [DeviceController::class, 'Index'])->name('devices.index');
Route::get('devices-log', [DeviceController::class, 'DeviceLog'])->name('devices.DeviceLog');
Route::get('finger-log', [DeviceController::class, 'FingerLog'])->name('devices.FingerLog');
Route::get('attendance', [DeviceController::class, 'Attendance'])->name('devices.Attendance');
Route::get('/attendance/export', [DeviceController::class, 'exportAttendance'])->name('attendance.export');
Route::match(['get','post'], '/iclock/getrequest', [DeviceController::class, 'getRequest']);
Route::match(['get','post'], '/iclock/devicecmd', [iclockController::class, 'devicecmd']);
Route::get('/attendance-report', [AttendanceReportController::class, 'index'])->name('attendance.report');

// handshake
Route::get('/iclock/cdata', [iclockController::class, 'handshake']);
// request dari device
Route::post('/iclock/cdata', [iclockController::class, 'receiveRecords']);

Route::post('/iclock/fdata', [iclockController::class, 'receiveFileData']);

Route::get('/iclock/test', [iclockController::class, 'test']);
Route::get('/iclock/getrequest', [iclockController::class, 'getrequest']);

//users
Route::get('/device-users', [DeviceController::class, 'deviceUsers'])->name('device-users');

//get attendance report
Route::get('/attendance-report/export', [AttendanceReportController::class, 'export']);



Route::get('/', function () {
    return redirect('devices') ;
});
