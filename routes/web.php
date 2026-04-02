<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('comousar');
})->name('analise');

Route::get('/dashboard', function () {
    return session()->has('user_id')
        ? view('analise')
        : redirect()->route('login');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/analytics-data', [AnalyticsController::class, 'data'])->name('analytics.data');
Route::post('/finance-balance', [AnalyticsController::class, 'saveBalance'])->name('analytics.saveBalance');
Route::post('/finance-entry', [AnalyticsController::class, 'saveEntry'])->name('analytics.saveEntry');
Route::post('/finance-entry/{id}/update', [AnalyticsController::class, 'updateEntry'])->name('analytics.updateEntry');
Route::post('/finance-entry/{id}/remove', [AnalyticsController::class, 'deleteEntry'])->name('analytics.deleteEntry');
Route::view('/contato', 'contato')->name('contato');
Route::view('/comousar', 'comousar')->name('comousar');

Route::get('/select', [AlunoController::class, 'select'])->name('select');
Route::get('/insert', [AlunoController::class, 'insert'])->name('insert');
Route::get('/update', [AlunoController::class, 'update'])->name('update');
Route::get('/delete', [AlunoController::class, 'delete'])->name('delete');
Route::get('/sql', [AlunoController::class, 'sql'])->name('sqlS');