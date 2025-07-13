<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ruanganData = [
            [
                'nama' => 'Pamiluto',
                'lantai' => 1,
                'kapasitas' => 15,
                'warna' => '#800000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kasatrian',
                'lantai' => 2,
                'kapasitas' => 20,
                'warna' => '#000080',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Parangkusumo',
                'lantai' => 2,
                'kapasitas' => 25,
                'warna' => '#228B22',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Wahyutumurun',
                'lantai' => 3,
                'kapasitas' => 20,
                'warna' => '#4B0082',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kawung',
                'lantai' => 3,
                'kapasitas' => 25,
                'warna' => '#36454F',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Aula Sidomukti',
                'lantai' => 4,
                'kapasitas' => 60,
                'warna' => '#FF4500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
 
        foreach ($ruanganData as $key => $val) {
            Ruangan::create($val);
        }
    }
}
