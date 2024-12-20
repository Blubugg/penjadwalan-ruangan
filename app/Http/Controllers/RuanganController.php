<?php namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller {
    
    // For guests
    public function index() {
        $ruangans = Ruangan::all();
        return view('guest.ruangan', compact('ruangans'));
    }

    public function userIndex() {
        $ruangans = Ruangan::all();
        return view('user.ruangan', compact('ruangans'));
    }
    
    public function adminIndex() {
        $ruangans = Ruangan::all();
        return view('admin.ruangan', compact('ruangans'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
            'warna' => 'required|string|max:7',
        ]);

        $ruangans = new Ruangan($request->all());

        $ruangans->save();
        return redirect()->route('admin.ruangans')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id, Ruangan $ruangans)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'lantai' => 'required|integer',
            'kapasitas' => 'required|integer',
            'warna' => 'required|string',
        ]);

        $ruangans = Ruangan::findOrFail($id);
        $ruangans->update($request->all());
        return redirect()->route('admin.ruangans')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy($id, Ruangan $ruangans)
    {
        $ruangans = Ruangan::findOrFail($id);
        $ruangans->delete();
        return redirect()->route('admin.ruangans')->with('success', 'Ruangan berhasil ditambahkan.');
    }
}