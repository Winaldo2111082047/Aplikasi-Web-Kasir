<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- HEADER HALAMAN -->
        <header class="mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800 leading-tight">
                Laporan Penjualan
            </h1>
            <p class="mt-2 text-lg text-gray-500">
                Lihat dan filter riwayat semua transaksi yang telah terjadi.
            </p>
        </header>

        <!-- FORM FILTER TANGGAL -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- TABEL LAPORAN -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Detail Item</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <ul class="list-disc list-inside">
                                @foreach($transaction->details as $detail)
                                    <li>{{ $detail->product->name }} ({{ $detail->quantity }}x)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('transaksi.show', $transaction->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700">
                                Cetak Nota
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <p class="mt-4">Tidak ada riwayat transaksi yang cocok dengan filter Anda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         <!-- PAGINATION -->
         <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
