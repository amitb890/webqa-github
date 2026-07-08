<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
|
| These routes are registered with the "web_admin" middleware group (see
| App\Http\Kernel), which gives the admin panel its own isolated session
| cookie. This keeps admin authentication completely separate from the
| public/user (web guard) session, so a person can be logged into both the
| user dashboard and the admin panel at the same time, and user-session
| events never log the admin out.
|
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->middleware('guest:admin')->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->middleware('guest:admin')->name('admin.store');
    Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('admin.logout');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::get('/admin/tests', [App\Http\Controllers\Admin\MonitoringController::class, 'tests'])->name('admin.tests');
    Route::get('/admin/tests/{source}/{id}/error', [App\Http\Controllers\Admin\MonitoringController::class, 'error'])->name('admin.tests.error');
    Route::get('/admin/activity', [App\Http\Controllers\Admin\MonitoringController::class, 'activity'])->name('admin.activity');

    Route::prefix('admin/users')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Users\UsersController::class, 'view'])->name('admin.users.view');
        Route::post('/search', [App\Http\Controllers\Admin\Users\UsersController::class, 'search'])->name('admin.users.search');
        Route::post('/reset-password-email/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'sendResetEmail'])->name('admin.user.reset-email');
        Route::post('/reset-password/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'resetPassword'])->name('admin.user.reset-password');
        Route::post('/launch/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'launch'])->name('admin.user.launch');
        Route::delete('/delete/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'delete'])->name('admin.user.destroy');
        Route::put('/activate/{id}', [App\Http\Controllers\Admin\Users\UsersController::class, 'activate'])->name('admin.user.activate');
    });
});
