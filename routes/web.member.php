<?php

use App\Http\Controllers\ViewBlade\MemberController;
use Illuminate\Support\Facades\Route;

Route::controller(MemberController::class)->group(function() {
    Route::get('/member', 'index');
});

