<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Events\JadwalUpdated;
use App\Events\NotifikasiPesananBaru;
use App\Notifications\PesananDiajukan;

class JadwalController extends Controller {
    
    // For guests
    public function index() {
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        return view('guest.jadwal', compact('jadwals'));
    }

    // For authenticated users to create a schedule
    public function userIndex() {
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        return view('user.jadwal', compact('jadwals'));
    }

    public function create() {
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        $ruangans = Ruangan::all(); // Fetch all rooms for the create schedule form
        return view('user.buat', compact( 'jadwals', 'ruangans'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|string',
            'durasi' => 'required|integer',
            'waktu_kegiatan' => 'required',
            'jumlah_peserta' => 'required|integer',
            'ruangan_id' => 'required|exists:ruangans,id',
            'surat_ijin' => 'nullable|file|mimes:pdf|max:2048',
        ]);
        
        $tanggal = Carbon::createFromFormat('d/m/Y', $request->input('tanggal'))->format('Y-m-d');

        $jadwals = new Jadwal($request->all());
        $jadwals->tanggal = $tanggal;
        $jadwals->user_id = auth()->id(); // Set the authenticated user's ID

        if ($request->hasFile('surat_ijin')) {
            $jadwals->surat_ijin = $request->file('surat_ijin')->store('surat_ijins', 'public');
        }

        $jadwals->status = 'Menunggu';

        $jadwals->save();

        // Kirim notifikasi ke admin
        $notificationData = [
            'type' => 'user-submission',
            'message' => 'Ada jadwal baru yang diajukan.',
            'count' => Jadwal::where('status', 'Menunggu')->count(),
        ];
        event(new JadwalUpdated($notificationData));

        // $admins = User::role('Admin')->get();
        // foreach ($admins as $admin) {
        //     $admin->notify(new PesananDiajukan($jadwals));
        // }

        return redirect()->route('user.jadwals')->with('success', 'Jadwal berhasil dibuat.');
    }

    // For admin to view all schedules
    public function adminIndex() {
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        return view('admin.jadwal', compact('jadwals'));
    }

}