<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JadwalExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Jadwal::with(['user', 'ruangan'])
            ->where('status', 'Disetujui') // hanya status disetujui
            ->whereBetween('tanggal', [$this->from, $this->to])
            ->get()
            ->map(function ($jadwal) {
                return [
                    'Tanggal Pemesanan' => $jadwal->created_at->format('d-m-Y H:i'),
                    'Nama Pemesan' => $jadwal->user ? $jadwal->user->name : '-',
                    'Kegiatan' => $jadwal->nama_kegiatan,
                    'Ruangan' => $jadwal->ruangan ? $jadwal->ruangan->nama . ' Lantai ' . $jadwal->ruangan->lantai : '-',
                    'Jumlah Peserta' => $jadwal->jumlah_peserta,
                    'Tanggal Kegiatan' => $jadwal->tanggal,
                    'Waktu Kegiatan' => $jadwal->waktu_kegiatan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal Pemesanan',
            'Nama Pemesan',
            'Kegiatan',
            'Ruangan',
            'Jumlah Peserta',
            'Tanggal Kegiatan',
            'Waktu Kegiatan',
        ];
    }
}
