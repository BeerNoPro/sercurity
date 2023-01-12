<?php

use App\Http\Controllers\Auth\CustomAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewBlade\CabinetController;
use App\Http\Controllers\ViewBlade\CompanyController;
use App\Http\Controllers\ViewBlade\DeviceController;
use App\Http\Controllers\ViewBlade\MemberController;
use App\Http\Controllers\ViewBlade\MemberProjectController;
use App\Http\Controllers\ViewBlade\ProjectController;
use App\Http\Controllers\ViewBlade\TrainingController;
use App\Http\Controllers\ViewBlade\TrainingRoomController;
use App\Http\Controllers\ViewBlade\WorkRoomController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/security', function () {
    return view('index');
});

Route::middleware('user_role')->group(function() {
    Route::get('/register', [CustomAuthController::class, 'index'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'store'])->name('custom_register');
    Route::get('/login', [CustomAuthController::class, 'login'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'custom_login'])->name('custom_login');
    Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');
});

Route::controller(CompanyController::class)->group(function() {
    Route::get('/company', 'index')->name('company.home');
    Route::get('/company/add', 'create')->name('company.form.add');
    Route::post('/company', 'store')->name('company.add');
    Route::get('/company/{id}', 'show')->name('company-show');
    Route::put('/company/update/{id}', 'update')->name('company-update');
    Route::delete('/company/delete/{id}', 'destroy')->name('company-delete');
    Route::post('/company', 'search')->name('company.search');

});

Route::controller(WorkRoomController::class)->group(function() {
    Route::get('/work-room', 'index')->name('work-room.home');
});

Route::controller(MemberController::class)->group(function() {
    Route::get('/member', 'index')->name('member.home');
});

Route::controller(ProjectController::class)->group(function() {
    Route::get('/project', 'index')->name('project.home');
});

Route::controller(MemberProjectController::class)->group(function() {
    Route::get('/member-project', 'index')->name('member-project.home');
});

Route::controller(TrainingController::class)->group(function() {
    Route::get('/training', 'index')->name('training.home');
});

Route::controller(TrainingRoomController::class)->group(function() {
    Route::get('/training-room', 'index')->name('training-room.home');
});

Route::controller(DeviceController::class)->group(function() {
    Route::get('/device', 'index')->name('device.home');
});

Route::controller(CabinetController::class)->group(function() {
    Route::get('/cabinet', 'index')->name('cabinet.home');
});



// Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::get('/security', [LoginController::class, 'store'])->name('custom_login');


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
