<?php

use App\Http\Controllers\BetController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\Transaction;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/perfil/apostas', [ProfileController::class, 'userBets'])->name('profile.userBets');
    Route::put('/perfil/apostas/{id}', [ProfileController::class, 'updateBet'])->name('profile.updateBet');
    Route::delete('/perfil/apostas/{id}', [ProfileController::class, 'cancelBet'])->name('profile.cancelBet');
    Route::get('/perfil/alterar-senha', [ProfileController::class, 'edit'])->name('profile.edit'); 
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');
});

Route::middleware('auth')->group(function() {
    Route::get('/transacao/{id}', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('/transacao/{id}', [TransactionController::class, 'transaction'])->name('transaction');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/depositar', [DepositController::class, 'index'])->name('deposit.index');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/sacar', [WithdrawController::class, 'index'])->name('withdraw.index');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/apostas/campeao', [BetController::class, 'campeao'])->name('bet.campeao');
    Route::post('/apostas/campeao', [BetController::class, 'storeCAMPEAO'])->name('bet.storeCAMPEAO');
    Route::get('/apostas', [BetController::class, 'index'])->name('bet.index');
    Route::get('/apostas/{id}', [BetController::class, 'inspect'])->name('bet.inspect');
    Route::post('/apostas', [BetController::class, 'store'])->name('bet.store');
});

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::get('/events', [EventController::class, 'index'])->name('dashboard');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::get('/events/resolve/{event}', [EventController::class, 'resolveGet'])->name('events.resolve');
    Route::put('/events/resolve/{event}', [EventController::class, 'resolve'])->name('events.resolve');
    Route::put('/events/{id}/cancel', [EventController::class, 'cancelEvent'])->name('events.cancel');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/events/users/{user}/edit', [ManagerController::class, 'edit'])->name('manager.edit');
    Route::put('/events/users/{user}', [ManagerController::class, 'update'])->name('manager.update');
    Route::delete('/events/users/{user}', [ManagerController::class, 'destroy'])->name('manager.destroy');
});

require __DIR__.'/auth.php';