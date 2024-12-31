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

        return redirect()->route('user.jadwals')->with('success', 'Jadwal berhasil dibuat.');
    }
    // public function checkRoomAvailability(Request $request) {
    //     $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
    //     $waktu = $request->waktu;
        
    //     $ruangans = Ruangan::all()->map(function($ruangan) use ($tanggal, $waktu) {
    //         $isAvailable = !$ruangan->jadwal()
    //                                 ->where('tanggal', $tanggal)
    //                             ->where('waktu_kegiatan', $waktu)
    //                                 ->where('status', 'Disetujui')
    //                                 ->exists();
    //         // Jika jadwal tidak ditemukan, isAvailable = true
    //         if (!$ruangan->jadwal()->where('tanggal', $tanggal)->where('waktu_kegiatan', $waktu)->where('status', 'Disetujui')->exists()) {
    //             $isAvailable = true;
    //         }
        
    //         return [
    //             'id' => $ruangan->id,
    //             'isAvailable' => $isAvailable,
    //         ];
    //     });
        
        
    //     // return response()->json($ruangans, 200);
    //     return response()->json($ruangans);
    // }
    public function checkRoomAvailability(Request $request)
{
    // Parsing tanggal
    $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
    
    // Mendapatkan waktu kegiatan dalam format '13.00-15.00'
    $waktu = $request->waktu;

    // Memecah waktu kegiatan menjadi waktu mulai dan waktu selesai
    list($waktuMulaiInput, $waktuSelesaiInput) = explode('-', $waktu);
    
    // Mengonversi waktu mulai dan selesai ke objek Carbon
    $waktuMulaiInput = Carbon::createFromTimeString($waktuMulaiInput);
    // dd($waktuMulaiInput, $waktuSelesaiInput);
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
        $jadwals = Jadwal::with('ruangan')->where('status', 'Disetujui')->get();
        return view('admin.jadwal', compact('jadwals'));
    }

}