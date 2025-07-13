<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    
    protected $fillable = [
    'user_id', 
    'ruangan_id', 
    'nama_kegiatan', 
    'tanggal', 
    'waktu_kegiatan', 
    'jumlah_peserta',
    'surat_ijin', 
    'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
