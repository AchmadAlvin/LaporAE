<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Laporan;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Laporan::create([
            'user_id' => 2,
            'title' => 'Trotoar Rusak dan Berlubang',
            'location' => 'Depan Stasiun Madiun, Jl Pahlawan',
            'category' => 'Fasilitas Rusak',
            'description' => 'Trotoar di depan stasiun rusak parah, sulit dilewati pejalan kaki dan berbahaya bagi pengguna kursi roda.',
            'status' => 'Baru',
        ]);
        Laporan::create([
            'user_id' => 3,
            'title' => 'Halte Bus Tidak Ada Ramp',
            'location' => 'Halte Pasar Besar, Jl Sudirman',
            'category' => 'Aksesibilitas',
            'description' => 'Halte Bus di Pasar Besar tidak ada jalan landai (ramp) untuk naik turun kursi roda, Sangat menyulitkan.',
            'status' => 'Diproses',
        ]);
        Laporan::create([
            'user_id' => 2,
            'title' => 'Lampu Jalan Mati',
            'location' => 'Sekitar Terminal Purboyo',
            'category' => 'Keamanan',
            'description' => 'Lampu jalan di sekitar Terminal Purboyo banyak yang mati, membuat suasana menjadi gelap dan rawan di malam hari',
            'status' => 'Selesai'
        ]);
    }
}
