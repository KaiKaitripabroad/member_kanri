<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('auth.login');
});

// ログイン後の共通ルート
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. ダッシュボード画面（MemberControllerのdashboardメソッドを呼ぶ）
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');

    // 2. メンバー一覧画面（MemberControllerのindexメソッドを呼ぶ）
    Route::resource('members', MemberController::class);

    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('events', EventController::class);

require __DIR__.'/auth.php';
