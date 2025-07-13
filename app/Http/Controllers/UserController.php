<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function adminIndex() {
        $users = User::where('role', 'User')->orderBy('created_at', 'desc')->get(); // Fetch all user for admin
        return view('admin.akun', compact('users'));
    }

    public function approve(User $users) {
        $users->status = 'Disetujui';
        $users->save();

        return redirect()->route('admin.users')->with('success', 'Jadwal berhasil disetujui.');
    }

    public function reject(User $users) {
        $users->status = 'Ditolak';
        $users->save();

        return redirect()->route('admin.users')->with('success', 'Jadwal berhasil ditolak.');
    }
}
