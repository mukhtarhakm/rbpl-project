<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - BOS Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-blue-600 text-white sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 h-16 flex justify-between items-center">
            <h1 class="font-bold text-lg tracking-tight">Dashboard Kepala Sekolah</h1>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-white/90 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                </button>

                <!-- Logout -->
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2 text-white/90 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 mt-6 space-y-8">

        <!-- WELCOME CARD -->
        <section class="bg-gradient-to-br from-purple-600 to-indigo-800 text-white p-6 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-purple-100 text-sm font-medium mb-1">Selamat Datang,</p>
                <h2 class="text-2xl font-bold mb-2">
                    {{ auth()->user()->name ?? 'Dr. Budi Santoso' }}
                </h2>
                <p class="text-purple-100/80 text-sm max-w-[200px] leading-relaxed">
                    Pantau dan kelola keuangan sekolah
                </p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </section>

        <!-- STATISTIK -->
        @php
            $menunggu = $pengajuans->where('status', 'menunggu')->count();
            $disetujui = $pengajuans->where('status', 'disetujui_kepsek')->count();
            $totalAnggaran = $pengajuans->sum('jumlah_dana');
            $realisasi = $pengajuans->where('status', 'disetujui')->sum('jumlah_dana');
        @endphp

        <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-yellow-50 p-2 rounded-xl mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $menunggu }}</p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Persetujuan</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-green-50 p-2 rounded-xl mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $disetujui }}</p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Disetujui</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-blue-50 p-2 rounded-xl mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xl font-bold text-gray-800">
                    {{ number_format($totalAnggaran / 1000000, 1) }} Jt
                </p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1 text-center">Total Anggaran</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-purple-50 p-2 rounded-xl mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <p class="text-xl font-bold text-gray-800">
                    {{ $totalAnggaran > 0 ? round(($realisasi / $totalAnggaran) * 100) : 0 }}%
                </p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Realisasi</p>
            </div>
        </section>

        <!-- MENU UTAMA -->
        <section>
            <h2 class="text-gray-800 font-bold text-sm mb-4">Menu Utama</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- PERSETUJUAN -->
                <a href="/dashboard/kepsek/persetujuan" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Persetujuan Pengeluaran</p>
                </a>

                <!-- LAPORAN -->
                <a href="#" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-green-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4m-4-6l4 4-4 4" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Laporan Keuangan</p>
                </a>

                <!-- RKAS -->
                <a href="#" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Status RKAS</p>
                </a>

                <!-- NOTIFIKASI -->
                <a href="#" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-orange-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Notifikasi</p>
                </a>
            </div>
        </section>

        <!-- PERSETUJUAN TERTUNDA -->
        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-gray-800 font-bold text-sm">Persetujuan Tertunda</h2>
                <a href="/dashboard/kepsek/persetujuan" class="text-blue-600 text-xs font-semibold">Lihat Semua</a>
            </div>

            <div class="space-y-4">
                @forelse($pengajuans->where('status', 'menunggu') as $item)
                    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $item->judul }}</h3>
                                <p class="text-xs text-gray-400">Pengaju: <span class="text-gray-600 font-medium">{{ $item->user->name ?? '-' }}</span></p>
                                <p class="text-sm font-bold text-blue-600 mt-2">Rp {{ number_format($item->jumlah_dana) }}</p>
                            </div>
                            <span class="text-[10px] font-bold px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full uppercase tracking-wider">Pending</span>
                        </div>

                        <div class="flex space-x-3 pt-2">
                            <form action="/pengajuan/{{ $item->id }}/approve" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-xl text-xs font-bold transition">Setujui</button>
                            </form>
                            <form action="/pengajuan/{{ $item->id }}/reject" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="alasan_penolakan" value="Ditolak oleh Kepala Sekolah">
                                <button type="submit" class="w-full py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-bold transition">Tolak</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <!-- Placeholder RKAS if no pengajuan found or just static RKAS as in figma -->
                    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center border-l-4 border-blue-500">
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm mb-1">RKAS Tahun 2025</h3>
                            <p class="text-xs text-gray-400 mb-2">Bendahara: <span class="text-gray-600 font-medium">Siti Nurhaliza</span></p>
                            <p class="text-sm font-bold text-gray-800">Total: Rp 500.000.000</p>
                        </div>
                        <div class="flex flex-col items-end space-y-3">
                            <span class="text-[10px] font-bold px-3 py-1 bg-blue-50 text-blue-600 rounded-full uppercase tracking-wider">Review</span>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-bold shadow-lg shadow-blue-500/20">Tinjau Detail</button>
                        </div>
                    </div>
                @endforelse

                <!-- Always show RKAS example if needed for matches Figma -->
                @if($pengajuans->where('status', 'menunggu')->count() > 0)
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex justify-between items-center border-l-4 border-blue-500">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm mb-1">RKAS Tahun 2025</h3>
                        <p class="text-xs text-gray-400 mb-2">Bendahara: <span class="text-gray-600 font-medium">Siti Nurhaliza</span></p>
                        <p class="text-sm font-bold text-gray-800">Total: Rp 500.000.000</p>
                    </div>
                    <div class="flex flex-col items-end space-y-3">
                        <span class="text-[10px] font-bold px-3 py-1 bg-blue-50 text-blue-600 rounded-full uppercase tracking-wider">Review</span>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-bold shadow-lg shadow-blue-500/20">Tinjau Detail</button>
                    </div>
                </div>
                @endif
            </div>
        </section>

    </main>

</body>
</html>


</body>

</html>