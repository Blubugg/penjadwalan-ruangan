<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

use App\Events\JadwalUpdated;
use App\Events\NotifikasiPesananBaru;
use App\Events\NotifikasiStatusDiperbarui;

class PesananController extends Controller
{
    public function userIndex() {
        $jadwals = Jadwal::with('ruangan')
                        ->orderBy('created_at', 'desc')
                        ->where('user_id', auth()->id()
                        )->get(); // Fetch user-specific schedules
        return view('user.pesanan', compact('jadwals'));
    }
     
    public function adminIndex() {
        $jadwals = Jadwal::with('ruangan')
                        ->orderBy('created_at', 'desc')
                        ->get(); // Fetch all schedules for admin
        return view('admin.pesanan', compact('jadwals'));
    }

    public function approve(Jadwal $jadwals) {
        $jadwals->status = 'Disetujui';
        $jadwals->save();

        // Kirim notifikasi ke user
        $notificationData = [
            'type' => 'admin-response',
            'message' => 'Jadwal Anda telah disetujui.',
            'count' => Jadwal::where('user_id', $jadwals->user_id)->whereIn('status', ['Disetujui', 'Ditolak'])->count(),
        ];
        event(new JadwalUpdated($notificationData));

        return redirect()->route('admin.pesanans')->with('success', 'Jadwal berhasil disetujui.');
    }

    public function reject(Jadwal $jadwals) {
        $jadwals->status = 'Ditolak';
        $jadwals->save();

        // Kirim notifikasi ke user
        $notificationData = [
            'type' => 'admin-response',
            'message' => 'Jadwal Anda telah ditolak.',
            'count' => Jadwal::where('user_id', $jadwals->user_id)->whereIn('status', ['Disetujui', 'Ditolak'])->count(),
        ];
        event(new JadwalUpdated($notificationData));

        return redirect()->route('admin.pesanans')->with('success', 'Jadwal berhasil ditolak.');
    }
}
