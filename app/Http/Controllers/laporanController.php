<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function exportPdf()
    {
        $transaksi = Laporan::orderBy('date', 'desc')->get();
        $saldo = Laporan::where('type', 'income')->sum('amount') - Laporan::where('type', 'expense')->sum('amount');
        $totalPengeluaran = Laporan::where('type', 'expense')->sum('amount');
    
        $pdf = Pdf::loadView('laporan.pdf', compact('transaksi', 'saldo', 'totalPengeluaran'));
        
        return $pdf->download('laporan_keuangan.pdf');
    }
  }
