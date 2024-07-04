<?php

use App\Http\Controllers\BetController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/aaa', function () {
    return view('teste.profile');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/perfil/alterar-senha', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/depositar', [DepositController::class, 'index'])->name('deposit.index');
});


Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/sacar', [WithdrawController::class, 'index'])->name('withdraw.index');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/apostas', [BetController::class, 'index'])->name('bet.index');
    Route::get('/apostas/{id}', [BetController::class, 'inspect'])->name('bet.inspect');
    Route::post('/apostas', [BetController::class, 'store'])->name('bet.store');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';