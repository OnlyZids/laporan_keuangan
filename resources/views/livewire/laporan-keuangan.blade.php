<div>

    <div class="p-4 border rounded">
        <h3 class="font-semibold">Tambah Transaksi</h3>
        <input type="date" wire:model="tanggal" class="border p-1 rounded">
        <input type="text" wire:model="keterangan" placeholder="Keterangan" class="border p-1 rounded">
        <select wire:model="tipe" class="border p-1 rounded">
            <option value="">Pilih Jenis</option>
            <option value="income">Pemasukan</option>
            <option value="expense">Pengeluaran</option>
            
        </select>
        <input type="number" wire:model="jumlah" placeholder="Jumlah (Rp)" class="border p-1 rounded">
        <button wire:click="{{ $editId ? 'updateTransaksi' : 'tambahTransaksi' }}" class="bg-green-500 text-white px-4 py-2 rounded">{{ $editId ? 'Simpan Perubahan' : 'Tambah' }}
            </button>
        <button wire:click="hapusSemua" class="bg-red-500 text-white px-2 py-1 rounded">Hapus Semua</button>
        <a href="{{ route('laporan.pdf') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan PDF</a>
    </div>

    <h3 class="mt-4 font-semibold">Saldo: Rp {{ number_format((float) $saldo, 0, ',', '.') }}</h3>
    <h3 class="mt-2 font-semibold">Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>

    <table class="w-full mt-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->date }}</td>
                    <td>{{ $t->description }}</td>
                    <td class="text-green-500">
                        {{ $t->type == 'income' ? 'Rp ' . number_format($t->amount, 0, ',', '.') : '-' }}
                    </td>
                    <td class="text-red-500">
                        {{ $t->type == 'expense' ? 'Rp ' . number_format($t->amount, 0, ',', '.') : '-' }}
                    </td>
                    <td>
                        <button wire:click="editTransaksi({{ $t->id }})" class="text-red-600">✏️</button>

                        <button wire:click="hapusTransaksi({{ $t->id }})" class="text-red-600">🗑</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


