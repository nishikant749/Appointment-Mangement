<?php

use Illuminate\Support\Facades\Route;

#Define Controllers path
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;

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

#Home and Login Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'index'])->name('login');
Route::post('/fetchUserOnEmail', [HomeController::class, 'fetchUserOnEmail'])->name('fetchUserOnEmail');
Route::post('/login', [HomeController::class, 'attemptLogin'])->name('login');

#Register Routes
Route::resource('register', RegisterController::class);
Route::post('userCheckOnEmail', [RegisterController::class, 'userCheckOnEmail'])->name('userCheckOnEmail');

#appointment for guest user
Route::resource('guestAppointment', AppointmentController::class);
Route::post('fetchGuestSlots', [AppointmentController::class, 'fetchSlots'])->name('fetchGuestSlots');

#After authentivcation routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');

    #Appointments Routes
    Route::resource('appointment', AppointmentController::class);
    Route::post('fetchSlots', [AppointmentController::class, 'fetchSlots'])->name('fetchSlots');
    Route::post('updateStatus', [AppointmentController::class, 'updateStatus'])->name('updateStatus');

    #Patient Routes
    Route::resource('patient', PatientController::class);

    #Doctor Routes
    Route::resource('doctor', DoctorController::class);
});
