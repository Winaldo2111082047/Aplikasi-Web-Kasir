<x-app-layout>
    {{-- Bungkus semua konten dengan div ini untuk membuatnya berada di tengah --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- HEADER HALAMAN -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}! Berikut ringkasan aktivitas hari ini.</p>
        </header>

        <!-- KARTU STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Kartu 1: Pendapatan Hari Ini -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Pendapatan Hari Ini</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-sky-100 text-sky-600">
                        <i class="fas fa-dollar-sign text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Transaksi Hari Ini -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Transaksi Hari Ini</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $todayTransactions }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-100 text-emerald-600">
                        <i class="fas fa-receipt text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Produk Terjual -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Produk Terjual (Hari Ini)</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $todayProductsSold }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                        <i class="fas fa-box-open text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Jumlah Pengguna -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-slate-100 hover:shadow-lg transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pengguna</p>
                        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- AREA GRAFIK -->
        <div class="mt-8 bg-white p-6 rounded-xl shadow-md border border-slate-100">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Grafik Pendapatan (7 Hari Terakhir)</h2>
            <div class="h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- SCRIPT UNTUK MENGGAMBAR GRAFIK --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesData = @json($salesData);
            const dateLabels = @json($dateLabels);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: salesData,
                        borderColor: '#0ea5e9', // Warna primer-500
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#0ea5e9',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#0ea5e9'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Pendapatan: Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
