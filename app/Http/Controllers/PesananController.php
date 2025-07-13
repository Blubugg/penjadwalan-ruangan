<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

use App\Events\JadwalUpdated;
use App\Events\NotifikasiPesananBaru;
use App\Events\NotifikasiStatusDiperbarui;
use App\Notifications\AdminActionNotification;

use App\Exports\JadwalExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $jadwals = Jadwal::with(['user', 'ruangan'])
                        ->orderBy('created_at', 'desc')
                        ->get(); // Fetch all schedules for admin
        return view('admin.pesanan', compact('jadwals'));
    }

    public function approve(Jadwal $jadwals) {
        $jadwals->status = 'Disetujui';
        $jadwals->save();

        $user = $jadwals->user;
        $user->notify(new AdminActionNotification('Disetujui', $jadwals));

        return redirect()->route('admin.pesanans')->with('success', 'Jadwal berhasil disetujui.');
    }

    public function reject(Request $request, Jadwal $jadwals) {
        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);
        
        $jadwals->status = 'Ditolak';
        $jadwals->alasan_penolakan = $request->alasan;
        $jadwals->save();

        $user = $jadwals->user;
        $user->notify(new AdminActionNotification('Ditolak', $jadwals));

        return redirect()->route('admin.pesanans')->with('success', 'Jadwal berhasil ditolak.');
    }

    public function export(Request $request){
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from'
        ]);

        $from = $request->input('from');
        $to = $request->input('to');

        $filename = 'Laporan_Pesanan_Ruangan_' . date('dMy', strtotime($from)) . '_' . date('dMy', strtotime($to)) . '.xlsx';
        return Excel::download(new JadwalExport($from, $to), $filename);
    }
}
