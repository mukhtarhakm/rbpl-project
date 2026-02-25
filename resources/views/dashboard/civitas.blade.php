<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Civitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="font-semibold text-lg">Dashboard Civitas</h1>

        <form action="/logout" method="POST">
            @csrf
            <button class="bg-white text-blue-600 px-3 py-1 rounded-lg text-sm hover:bg-gray-200">
                Logout
            </button>
        </form>
    </div>

    <div class="p-6 space-y-6">

        <!-- WELCOME CARD -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 
                    text-white p-6 rounded-2xl shadow-lg">
            <p class="text-sm opacity-80">Selamat Datang,</p>
            <h2 class="text-xl font-semibold">
                {{ auth()->user()->name ?? 'Civitas' }}
            </h2>
            <p class="text-sm opacity-80">
                Kelola pengajuan dana dengan mudah
            </p>
        </div>

        <!-- STATISTIK -->
        @php
            $aktif = $pengajuans->where('status','menunggu')->count();
            $disetujui = $pengajuans->where('status','disetujui')->count();
            $totalDana = $pengajuans->where('status','disetujui')
                                    ->sum('jumlah_dana');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
        <img src="{{ asset('icons/status-disetujui.svg') }}"
             class="w-8 h-8 mx-auto mb-3">
        <p class="text-2xl font-bold text-orange-500">{{ $aktif }}</p>
        <p class="text-sm text-gray-500 mt-1">Pengajuan Aktif</p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
        <img src="{{ asset('icons/aktivitas.svg') }}"
             class="w-8 h-8 mx-auto mb-3">
        <p class="text-2xl font-bold text-green-500">{{ $disetujui }}</p>
        <p class="text-sm text-gray-500 mt-1">Disetujui</p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 text-center hover:shadow-lg transition">
        <img src="{{ asset('icons/statistik.svg') }}"
             class="w-8 h-8 mx-auto mb-3">
        <p class="text-2xl font-bold text-blue-500">
            Rp {{ number_format($totalDana) }}
        </p>
        <p class="text-sm text-gray-500 mt-1">Total Dana</p>
    </div>

</div>

        <!-- MENU UTAMA -->
        <div>
            <h2 class="text-gray-700 font-semibold mb-4">Menu Utama</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- AJUKAN DANA -->
    <a href="{{ url('/pengajuan/create') }}"
       class="bg-white rounded-2xl shadow-md p-8 text-center 
              hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-500 
                    flex items-center justify-center">
            <img src="{{ asset('icons/ajukan-dana.svg') }}"
                 class="w-7 h-7">
        </div>
        <p class="mt-4 font-semibold text-gray-700">Ajukan Dana</p>
    </a>

    <!-- UPLOAD -->
    <a href="#"
       class="bg-white rounded-2xl shadow-md p-8 text-center 
              hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-green-500 
                    flex items-center justify-center">
            <img src="{{ asset('icons/upload-bukti.svg') }}"
                 class="w-7 h-7">
        </div>
        <p class="mt-4 font-semibold text-gray-700">Upload Bukti</p>
    </a>

    <!-- RIWAYAT -->
    <a href="#"
       class="bg-white rounded-2xl shadow-md p-8 text-center 
              hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-500 
                    flex items-center justify-center">
            <img src="{{ asset('icons/riwayat-pengajuan.svg') }}"
                 class="w-7 h-7">
        </div>
        <p class="mt-4 font-semibold text-gray-700">Riwayat Pengajuan</p>
    </a>

    <!-- NOTIF -->
    <a href="#"
       class="bg-white rounded-2xl shadow-md p-8 text-center 
              hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-orange-500 
                    flex items-center justify-center">
            <img src="{{ asset('icons/notifikasi.svg') }}"
                 class="w-7 h-7">
        </div>
        <p class="mt-4 font-semibold text-gray-700">Notifikasi</p>
    </a>

</div>
        </div>

    </div>

    <!-- AKTIVITAS TERBARU -->
<div class="mt-8">
    <h2 class="text-gray-700 font-semibold mb-4">
        Aktivitas Terbaru
    </h2>

    <div class="space-y-4">

        @forelse($pengajuans->sortByDesc('created_at')->take(2) as $item)
            <div class="bg-white p-5 rounded-2xl shadow-md">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-700">
                            {{ $item->judul }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Rp {{ number_format($item->jumlah_dana) }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $item->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <span class="text-xs px-3 py-1 rounded-full
                        @if($item->status == 'menunggu') bg-yellow-100 text-yellow-600
                        @elseif($item->status == 'disetujui') bg-green-100 text-green-600
                        @elseif($item->status == 'ditolak') bg-red-100 text-red-600
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

            </div>
        @empty
            <div class="text-gray-500 text-sm">
                Belum ada aktivitas pengajuan.
            </div>
        @endforelse

    </div>
</div>
</body>
</html>