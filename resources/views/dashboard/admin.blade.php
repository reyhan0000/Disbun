<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            @if(Auth::user()->role === 'admin')
                {{ __('Dasbor Admin') }}
            @else
                {{ __('Dasbor Utama') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner with Glassmorphism -->
            <div class="relative rounded-2xl shadow-lg mb-6 overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-700">
                <div class="px-6 py-6 text-white">
                    <h1 class="text-2xl font-extrabold mb-1">Selamat Datang, {{ Auth::user()->name }}</h1>
                    @if(Auth::user()->role === 'admin')
                        <p class="text-blue-100 text-base">Kelola semua data pengguna sistem SIBANSAR melalui dasbor kontrol ini.</p>
                    @else
                        <p class="text-blue-100 text-base max-w-2xl">Pantau seluruh pergerakan pengajuan bantuan sarana dan prasarana di wilayah Anda secara real-time.</p>
                    @endif
                </div>
                <div class="absolute right-6 bottom-4 opacity-20">
                    @if(Auth::user()->role === 'admin')
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                    @else
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                    @endif
                </div>
            </div>

            <!-- ADMIN DASHBOARD -->
            @if(Auth::user()->role === 'admin')
            <!-- Stats Grid for Admin -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total User</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $stats['total_users'] }}</p>
                    </div>
                </a>

                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Operator</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $stats['operator'] }}</p>
                    </div>
                </div>

                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Kepala Bidang</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors">{{ $stats['kabid'] }}</p>
                    </div>
                </div>

                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Kebun / Pekebun</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-green-600 transition-colors">{{ $stats['petani'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions for Admin -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-8">
                <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-xl p-5 border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">Manajemen Pengguna</p>
                            <p class="text-sm text-gray-500">Tambah, perbarui, atau hapus akses pengguna sistem</p>
                        </div>
                    </div>
                </a>
            </div>

            @else
            <!-- Stats Grid for Operator/Kabid -->

            <!-- Stats Grid with Glass Effect -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 - Total -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Pengajuan</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $stats['total'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 2 - Pending -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Antrean Verifikasi</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">{{ $stats['pending_operator'] + $stats['pending_kabid'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 3 - Approved -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Telah Disetujui</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">{{ $stats['disetujui'] }}</p>
                    </div>
                </div>

                <!-- Stat Card 4 - Rejected -->
                <div class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="p-4 rounded-xl bg-gradient-to-br from-red-500 to-rose-500 text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Ditolak / Batal</p>
                        <p class="text-3xl font-bold text-gray-800 group-hover:text-red-600 transition-colors">{{ $stats['ditolak'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Chart 1: Komoditas -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-6 bg-emerald-500 rounded-full mr-2"></span>
                        Top Komoditas Pemohon Bantuan
                    </h3>
                    <div class="relative h-64">
                        <canvas id="komoditasChart"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Jenis Barang -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <span class="w-2 h-6 bg-blue-500 rounded-full mr-2"></span>
                        Kategori Barang Paling Diminati
                    </h3>
                    <div class="relative h-64">
                        <canvas id="barangChart"></canvas>
                    </div>
                </div>

            </div>
            @endif
        </div>
    </div>

    <!-- Chart.js - Only for Operator/Kabid -->
    @if(Auth::user()->role !== 'admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Custom animations
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#6b7280';

        document.addEventListener('DOMContentLoaded', function() {
            // Data Komoditas
            const komoditasData = @json($komoditasStats);
            const komoditasLabels = komoditasData.map(item => item.komoditas_utama || 'Tidak Diketahui');
            const komoditasValues = komoditasData.map(item => item.total);

            const ctxKomoditas = document.getElementById('komoditasChart').getContext('2d');
            new Chart(ctxKomoditas, {
                type: 'bar',
                data: {
                    labels: komoditasLabels,
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: komoditasValues,
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return 'rgba(16, 185, 129, 0.7)';
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.8)');
                            return gradient;
                        },
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 0,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { stepSize: 1 },
                            grid: { borderDash: [4, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Data Barang
            const barangData = @json($barangStats);
            const barangLabels = barangData.map(item => item.jenis_barang || 'Lainnya');
            const barangValues = barangData.map(item => item.total);

            const ctxBarang = document.getElementById('barangChart').getContext('2d');
            new Chart(ctxBarang, {
                type: 'doughnut',
                data: {
                    labels: barangLabels,
                    datasets: [{
                        data: barangValues,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.9)',
                            'rgba(16, 185, 129, 0.9)',
                            'rgba(245, 158, 11, 0.9)',
                            'rgba(239, 68, 68, 0.9)',
                            'rgba(139, 92, 246, 0.9)'
                        ],
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: { 
                            position: 'right',
                            labels: { padding: 20 }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>