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
    return view('index');
});

Route::get('/rental', function () {
    return view('rental');
});

Route::get('/hondahr-v2023', function () {
    return view('hondahr-v2023');
});

Route::get('/mazdacx-52022', function () {
    return view('mazdacx-52022');
});

Route::post('/process_rental', function () {
    return view('process_rental');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/list', function () {
    return view('list');
});

Route::get('/invoice', function () {
    return view('invoice');
});

Route::get('/admin/add_car', function () {
    return view('admin.add_car');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/edit_car', function () {
    return view('admin.edit_car');
});

Route::get('/admin/delete_car', function () {
    return view('admin.delete_car');
});

Route::get('/admin/delete_rental', function () {
    return view('admin.delete_rental');
});

Route::get('/register', function () {
    return view('auth.header');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/logout', function () {
    return view('auth.logout');
});

Route::get('/register', function () {
    return view('auth.register');
});

