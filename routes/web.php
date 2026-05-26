<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ContactController::class, 'index']);

Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/thanks', [ContactController::class, 'store']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/admin', [ContactController::class, 'admin']);
Route::get('/admin/search', [ContactController::class, 'admin']);
// 💡 CSVダウンロード用のURLを登録します
Route::get('/admin/download', [ContactController::class, 'download']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/admin/delete', [ContactController::class, 'destroy']);