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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/listings', function () {
        return view('listings');
    })->name('listings');

    Route::get('/admin/invited-emails', function () {
        return view('admin/invited-emails/page');
    })->name('admin.invited-emails');

    Route::get('/admin/roles', function () {
        return view('admin/roles/page');
    })->name('admin.roles');

    Route::get('/admin/permissions', function () {
        return view('admin/permissions/page');
    })->name('admin.permissions');

    Route::get('/admin/user-roles', function () {
        return view('admin/user-roles/page');
    })->name('admin.user-roles');

    // Route::get('phpmyinfo', function () {
    //     phpinfo();
    // })->name('phpmyinfo');
});
