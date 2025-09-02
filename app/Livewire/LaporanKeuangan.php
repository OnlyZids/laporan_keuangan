<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Laporan;

class LaporanKeuangan extends Component
{
    public $tanggal, $keterangan, $tipe, $jumlah;
    public $saldo = 0;
    public $totalPengeluaran = 0;
    public $editId = null;


    public function mount()
    {
        $this->hitungSaldo();
        $this->hitungTotalPengeluaran();
    }
        // menghitung saldo
    public function hitungSaldo()
    {
        $pemasukan = Laporan::where('type', 'income')->sum('amount');
        $pengeluaran = Laporan::where('type', 'expense')->sum('amount');
        $this->saldo = $pemasukan - $pengeluaran;
    }
    
    // total pengeluaran
    public function hitungTotalPengeluaran()
    {
        $this->totalPengeluaran = Laporan::where('type', 'expense')->sum('amount');
    }

    // tambah laporan
    public function tambahTransaksi()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'tipe' => 'required|in:income,expense',
            'jumlah' => 'required|numeric|min:1',
        ]);

        Laporan::create([
            'date' => $this->tanggal,
            'description' => $this->keterangan,
            'type' => $this->tipe,
            'amount' => $this->jumlah,
        ]);

        // Perbarui saldo dan total pengeluaran
        $this->hitungSaldo();
        $this->hitungTotalPengeluaran();

        // Reset input
        $this->reset(['tanggal', 'keterangan', 'tipe', 'jumlah']);
    }
    

    // perintah hapus
    public function hapusTransaksi($id)
    {
        Laporan::find($id)->delete();
        $this->hitungSaldo();
        $this->hitungTotalPengeluaran();
    }

    public function hapusSemua()
    {
        Laporan::truncate();
        $this->hitungSaldo();
        $this->hitungTotalPengeluaran();
    }

    public function render()
    {
        return view('livewire.laporan-keuangan', [
            'transaksi' => Laporan::orderBy('date', 'desc')->get()
        ]);
    }

    // perintah uabh
    public function editTransaksi($id)
    {
        $transaksi = Laporan::find($id);

        if ($transaksi) {
            $this->editId = $id;
            $this->tanggal = $transaksi->date;
            $this->keterangan = $transaksi->description;
            $this->tipe = $transaksi->type;
            $this->jumlah = $transaksi->amount;
        }
    }

    public function updateTransaksi()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'tipe' => 'required|in:income,expense',
            'jumlah' => 'required|numeric|min:1',
        ]);

        if ($this->editId) {
            $transaksi = Laporan::find($this->editId);
            if ($transaksi) {
                $transaksi->update([
                    'date' => $this->tanggal,
                    'description' => $this->keterangan,
                    'type' => $this->tipe,
                    'amount' => $this->jumlah,
                ]);
            }
        }

        $this->reset(['editId', 'tanggal', 'keterangan', 'tipe', 'jumlah']);
        $this->hitungSaldo();
        $this->hitungTotalPengeluaran();
    }

}
