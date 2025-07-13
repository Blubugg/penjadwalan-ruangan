<?php

use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//   return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
  return view('welcome');
})->name('welcome');

Route::get('/jadwal', [JadwalController::class, 'index'])->name('guest.jadwals');
Route::get('/ruangan', [RuanganController::class, 'index'])->name('guest.ruangans');

Route::prefix('user')->middleware('auth', 'User')->group(function () {
  Route::get('/jadwal', [JadwalController::class, 'userIndex'])->name('user.jadwals');
  Route::get('/jadwal/buat', [JadwalController::class, 'create'])->name('user.jadwals.create');
  Route::post('/jadwal', [JadwalController::class, 'store'])->name('user.jadwals.store');
  Route::get('/ruangan', [RuanganController::class, 'userIndex'])->name('user.ruangans');
  Route::get('/pesanan', [PesananController::class, 'userIndex'])->name('user.pesanans');
});

Route::prefix('admin')->middleware('auth', 'Admin')->group(function () {
  Route::get('/jadwal', [JadwalController::class, 'adminIndex'])->name('admin.jadwals');
  Route::get('/ruangan', [RuanganController::class, 'adminIndex'])->name('admin.ruangans');
  Route::post('/ruangan', [RuanganController::class, 'store'])->name('admin.ruangans.store');
  Route::put('/ruangan/{ruangan}', [RuanganController::class, 'update'])->name('admin.ruangans.update');
  Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('admin.ruangans.destroy');
  Route::get('/pesanan', [PesananController::class, 'adminIndex'])->name('admin.pesanans');
  Route::post('/pesanan/approve/{jadwals}', [PesananController::class, 'approve'])->name('admin.pesanans.approve');
  Route::post('/pesanan/reject/{jadwals}', [PesananController::class, 'reject'])->name('admin.pesanans.reject');
  Route::get('/pesanan/export', [PesananController::class, 'export'])->name('admin.pesanans.export');
  Route::get('/akun', [UserController::class, 'adminIndex'])->name('admin.users');
  Route::post('/akun/approve/{users}', [UserController::class, 'approve'])->name('admin.users.approve');
  Route::post('/akun/reject/{users}', [UserController::class, 'reject'])->name('admin.users.reject');
});

Route::get('/check-room-availability', [JadwalController::class, 'checkRoomAvailability']);



require __DIR__.'/auth.php';
