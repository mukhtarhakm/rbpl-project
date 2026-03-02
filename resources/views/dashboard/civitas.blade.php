<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Civitas - BOS Management System</title>
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
            <h1 class="font-bold text-lg tracking-tight">Dashboard Civitas</h1>
            
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
        <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white p-6 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-100 text-sm font-medium mb-1">Selamat Datang,</p>
                <h2 class="text-2xl font-bold mb-2">
                    {{ auth()->user()->name ?? 'Ahmad Fauzi' }}
                </h2>
                <p class="text-blue-100/80 text-sm max-w-[200px] leading-relaxed">
                    Kelola pengajuan dana dengan mudah
                </p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </section>

        <!-- STATISTIK -->
        @php
            $aktif = $pengajuans->where('status','menunggu')->count();
            $disetujui = $pengajuans->where('status','disetujui')->count();
            $totalDana = $pengajuans->where('status','disetujui')->sum('jumlah_dana');
        @endphp

        <section class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-orange-50 p-2 rounded-xl mb-3">
                    <img src="{{ asset('icons/status-disetujui.svg') }}" class="w-6 h-6 grayscale opacity-70">
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $aktif }}</p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Pengajuan Aktif</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-green-50 p-2 rounded-xl mb-3">
                    <img src="{{ asset('icons/aktivitas.svg') }}" class="w-6 h-6 grayscale opacity-70">
                </div>
                <p class="text-xl font-bold text-gray-800">{{ $disetujui }}</p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Disetujui</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center text-center">
                <div class="bg-blue-50 p-2 rounded-xl mb-3">
                    <img src="{{ asset('icons/statistik.svg') }}" class="w-6 h-6 grayscale opacity-70">
                </div>
                <p class="text-xl font-bold text-gray-800">
                    {{ number_format($totalDana / 1000000, 1) }} Jt
                </p>
                <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mt-1">Total Dana</p>
            </div>
        </section>

        <!-- MENU UTAMA -->
        <section>
            <h2 class="text-gray-800 font-bold text-sm mb-4">Menu Utama</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- AJUKAN DANA -->
                <a href="{{ url('/pengajuan/create') }}" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('icons/ajukan-dana.svg') }}" class="w-6 h-6 invert">
                    </div>
                    <p class="text-xs font-semibold text-gray-600">Ajukan Dana</p>
                </a>

                <!-- UPLOAD BUKTI -->
                <a href="#" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-green-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('icons/upload-bukti.svg') }}" class="w-6 h-6 invert">
                    </div>
                    <p class="text-xs font-semibold text-gray-600">Upload Bukti</p>
                </a>

                <!-- RIWAYAT -->
                <a href="/civitas/riwayat" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('icons/riwayat-pengajuan.svg') }}" class="w-6 h-6 invert">
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Riwayat Pengajuan</p>
                </a>

                <!-- NOTIFIKASI -->
                <a href="#" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-orange-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <img src="{{ asset('icons/notifikasi.svg') }}" class="w-6 h-6 invert">
                    </div>
                    <p class="text-xs font-semibold text-gray-600">Notifikasi</p>
                </a>
            </div>
        </section>

        <!-- AKTIVITAS TERBARU -->
        <section>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-gray-800 font-bold text-sm">Aktivitas Terbaru</h2>
                <a href="/civitas/riwayat" class="text-blue-600 text-xs font-semibold">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($pengajuans->sortByDesc('created_at')->take(3) as $item)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm">{{ $item->judul }}</h3>
                                <p class="text-xs text-gray-500">Rp {{ number_format($item->jumlah_dana) }} • {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider
                            @if($item->status == 'menunggu') bg-yellow-50 text-yellow-600
                            @elseif($item->status == 'disetujui') bg-green-50 text-green-600
                            @elseif($item->status == 'ditolak') bg-red-50 text-red-600
                            @else bg-gray-50 text-gray-600
                            @endif">
                            {{ $item->status }}
                        </span>
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center">
                        <p class="text-gray-400 text-sm italic">Belum ada aktivitas pengajuan.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

</body>
</html>
