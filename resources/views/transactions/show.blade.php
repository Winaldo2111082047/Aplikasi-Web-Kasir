<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #333;
            margin: 0;
            padding: 20px;
            width: 300px; /* Lebar umum kertas thermal printer */
        }
        .container {
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .info {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .items table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .items th, .items td {
            padding: 5px 0;
            border-bottom: 1px dashed #999;
        }
        .items th {
            text-align: left;
        }
        .items .price, .items .qty, .items .subtotal {
            text-align: right;
        }
        .total {
            margin-top: 20px;
            font-size: 14px;
            text-align: right;
        }
        .total table {
            width: 100%;
        }
        .total .label {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <h1>Kasir Ageng</h1>
            <p>Jl. Adinegoro kecamatan Koto Tangah, Batang Kabung Ganting, Padang</p>
            <p>Telp: (0751) 123456</p>
        </div>
        <hr>
        <div class="info">
            <table>
                <tr>
                    <td>No. Transaksi</td>
                    <td>: #{{ $transaction->id }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <td>Kasir</td>
                    <td>: {{ Auth::user()->name }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="qty">Jml</th>
                        <th class="price">Harga</th>
                        <th class="subtotal">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td class="qty">{{ $detail->quantity }}</td>
                        <td class="price">{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                        <td class="subtotal">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <div class="total">
            <table>
                <tr>
                    <td class="label">GRAND TOTAL</td>
                    <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>-- Terima Kasih --</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
        </div>
    </div>
</body>
</html>
