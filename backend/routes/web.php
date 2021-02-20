<?php


use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();
