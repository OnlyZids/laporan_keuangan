<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Keuangan</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
            <tr>
                <td>{{ $item->date }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->type == 'income' ? 'Rp '.number_format($item->amount, 0, ',', '.') : '-' }}</td>
                <td>{{ $item->type == 'expense' ? 'Rp '.number_format($item->amount, 0, ',', '.') : '-' }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <h2>Saldo: Rp {{ number_format($saldo, 0, ',', '.') }}</h2>
    <h2>Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h2>
</body>
</html>
