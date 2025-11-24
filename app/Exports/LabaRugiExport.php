<?php

namespace App\Exports;

use App\Models\Penjualan; 
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents; 
use Maatwebsite\Excel\Events\AfterSheet; 

class LabaRugiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $tanggalMulai;
    protected $tanggalAkhir;
    protected $totalPendapatan = 0;
    protected $totalHpp = 0;
    protected $totalLaba = 0;

    public function __construct($tanggalMulai, $tanggalAkhir)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        $startDate = Carbon::parse($this->tanggalMulai)->startOfDay();
        $endDate = Carbon::parse($this->tanggalAkhir)->endOfDay();

        $penjualans = Penjualan::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->get();
        
        foreach ($penjualans as $penjualan) {
            $pendapatan = (float) $penjualan->total_harga;
            $hpp = (float) $penjualan->harga_beli_satuan * (int) $penjualan->jumlah;
            $laba = $pendapatan - $hpp;

            $this->totalPendapatan += $pendapatan;
            $this->totalHpp += $hpp;
            $this->totalLaba += $laba;
        }

        return $penjualans;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Pelanggan',
            'Nama Barang',
            'Jumlah',
            'Pendapatan',
            'HPP (Modal)',
            'Laba'
        ];
    }

    public function map($penjualan): array
    {
        $pendapatan = (float) $penjualan->total_harga;
        $hpp = (float) $penjualan->harga_beli_satuan * (int) $penjualan->jumlah;
        $laba = $pendapatan - $hpp;

        return [
            Carbon::parse($penjualan->tanggal)->format('Y-m-d H:i:s'),
            $penjualan->nama_pelanggan,
            $penjualan->nama_barang,
            $penjualan->jumlah,
            $pendapatan,
            $hpp,
            $laba,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("E2:G{$lastRow}")->getNumberFormat()->setFormatCode('#,##0');
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                $totalRow = $lastRow + 1; 

                $event->sheet->getDelegate()->setCellValue("D{$totalRow}", 'TOTAL KESELURUHAN');
                $event->sheet->getDelegate()->setCellValue("E{$totalRow}", $this->totalPendapatan);
                $event->sheet->getDelegate()->setCellValue("F{$totalRow}", $this->totalHpp);
                $event->sheet->getDelegate()->setCellValue("G{$totalRow}", $this->totalLaba);

                $event->sheet->getDelegate()->getStyle("D{$totalRow}:G{$totalRow}")->getFont()->setBold(true);
                
                $event->sheet->getDelegate()->getStyle("E{$totalRow}:G{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');
            },
        ];
    }
}