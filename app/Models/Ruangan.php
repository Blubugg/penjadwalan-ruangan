<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama', 'lantai', 'kapasitas', 'fasilitas', 'warna'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
