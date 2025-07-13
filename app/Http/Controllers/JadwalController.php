<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Events\JadwalUpdated;
use App\Events\NotifikasiPesananBaru;
use App\Notifications\PesananDiajukan;
use App\Notifications\UserActionNotification;

class JadwalController extends Controller {
    
    // For guests
    public function index() {
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        return view('guest.jadwal', compact('jadwals'));
    }

    // For authenticated users to create a schedule
    public function userIndex() {
        $jadwals = Jadwal::with('ruangan', 'user')->where('status', 'Disetujui')->get();
        return view('user.jadwal', compact('jadwals'));
    }

    public function create() {
        $jadwals = Jadwal::with('ruangan', 'user')->where('status', 'Disetujui')->get();
        $ruangans = Ruangan::all(); // Fetch all rooms for the create schedule form
        return view('user.buat', compact( 'jadwals', 'ruangans'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'jumlah_peserta' => 'required|integer',
            'ruangan_id' => 'required|exists:ruangans,id',
            'surat_ijin' => 'required|file|mimes:pdf|max:2048',
        ]);
        // dd($request->all());
        // $request->validate([
        //     'nama_kegiatan' => 'required|string|max:255',
        //     'tanggal' => 'required|string',
        //     'durasi' => 'required|integer',
        //     'waktu_kegiatan' => 'required',
        //     'jumlah_peserta' => 'required|integer',
        //     'ruangan_id' => 'required|exists:ruangans,id',
        //     'surat_ijin' => 'required|file|mimes:pdf|max:2048',
        // ]);


        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        // Gabungkan waktu menjadi format 'start_time - end_time'
        $waktu_kegiatan = "{$startTime} - {$endTime}";

        $tanggal = Carbon::createFromFormat('d/m/Y', $request->input('tanggal'))->format('Y-m-d');
        
        $jadwals = new Jadwal($request->all());
        $jadwals->tanggal = $tanggal;
        $jadwals->user_id = auth()->id(); // Set the authenticated user's ID
        $jadwals->waktu_kegiatan = $waktu_kegiatan;

        if ($request->hasFile('surat_ijin')) {
            $jadwals->surat_ijin = $request->file('surat_ijin')->store('surat_ijins', 'public');
        }

        $jadwals->status = 'Menunggu';

        $jadwals->save();
        $admin = User::where('role', 'admin')->first();
        $admin->notify(new UserActionNotification($request->user(), 'Mengajukan Pemesanan Ruangan'));
        // dd($request->user(), $admin);


        return redirect()->route('user.jadwals')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function checkRoomAvailability(Request $request)
    {
        // Parsing tanggal
        $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        $waktuMulaiInput = $request->start;
        $waktuSelesaiInput = $request->end;

        // Mengonversi waktu mulai dan selesai ke objek Carbon
        $waktuMulaiInput = Carbon::createFromTimeString($waktuMulaiInput);
        $waktuSelesaiInput = Carbon::createFromTimeString( $waktuSelesaiInput);

        $ruangans = Ruangan::all()->map(function ($ruangan) use ($tanggal, $waktuMulaiInput, $waktuSelesaiInput) {
            $isAvailable = !$ruangan->jadwal()
                ->where('tanggal', $tanggal)
                ->where('status', 'Disetujui')
                ->get()
                ->contains(function ($jadwal) use ($waktuMulaiInput, $waktuSelesaiInput) {
                    // Memecah waktu kegiatan yang ada di jadwal
                    list($jadwalMulaiInput, $jadwalSelesaiInput) = explode('-', $jadwal->waktu_kegiatan);

                    // Mengonversi waktu mulai dan selesai jadwal ke objek Carbon
                    $jadwalMulai = Carbon::createFromTimeString( $jadwalMulaiInput);
                    $jadwalSelesai = Carbon::createFromTimeString($jadwalSelesaiInput);

                    // Cek apakah rentang waktu tumpang tindih
                    return $waktuMulaiInput->lt($jadwalSelesai) && $waktuSelesaiInput->gt($jadwalMulai);
                });

            return [
                'id' => $ruangan->id,
                'isAvailable' => $isAvailable,
            ];
        });

        return response()->json($ruangans);
    }

    // For admin to view all schedules
    public function adminIndex() {
        $jadwals = Jadwal::with('ruangan', 'user')->where('status', 'Disetujui')->get();
        return view('admin.jadwal', compact('jadwals'));
    }

}