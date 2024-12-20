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
                'nama' => 'Meeting Room A',
                'lantai' => 1,
                'kapasitas' => 20,
                'warna' => '#FF5733',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Conference Hall',
                'lantai' => 2,
                'kapasitas' => 50,
                'warna' => '#33FF57',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Training Room B',
                'lantai' => 1,
                'kapasitas' => 30,
                'warna' => '#5733FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Event Room C',
                'lantai' => 3,
                'kapasitas' => 100,
                'warna' => '#FF33A1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
 
        foreach ($ruanganData as $key => $val) {
            Ruangan::create($val);
        }
    }
}
