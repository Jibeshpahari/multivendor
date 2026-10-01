<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

// No prefix or name set
Route::controller(AuthController::class)->group(function () {
    // =======================  ADMIN ============================
    Route::get('admin/login', 'adminLoginView')->name('admin.login.view');
    Route::post('admin/login', 'adminLoginPost')->name('admin.login.post');
    Route::get('admin/forgot-password', 'adminForgotPasswordView')->name('admin.forgot-password.view');
    Route::post('admin/forgot-password', 'adminForgotPasswordPost')->name('admin.forgot-password.post');
    Route::get('admin/verify-otp', 'adminVerifyOtpView')->name('admin.verify-otp.view');
    Route::post('admin/verify-otp', 'adminVerifyOtpPost')->name('admin.verify-otp.post');
    Route::get('admin/reset-password', 'adminResetPasswordView')->name('admin.reset-password.view');
    Route::Post('admin/reset-password', 'adminResetPasswordPost')->name('admin.reset-password.post');
});