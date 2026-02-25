<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard Kepala Sekolah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
        <h1 class="font-semibold text-lg">Dashboard Kepala Sekolah</h1>

        <form action="/logout" method="POST">
            @csrf
            <button class="bg-white text-blue-700 px-3 py-1 rounded-lg text-sm hover:bg-gray-200">
                Logout
            </button>
        </form>
    </div>

    <div class="p-6 space-y-6">

        <!-- WELCOME CARD -->
        <div class="bg-gradient-to-r from-purple-600 to-pink-500 
                text-white p-6 rounded-2xl shadow-lg">
            <p class="text-sm opacity-80">Selamat Datang,</p>
            <h2 class="text-xl font-semibold">
                {{ auth()->user()->name ?? 'Kepala Sekolah' }}
            </h2>
            <p class="text-sm opacity-80">
                Pantau dan kelola keuangan sekolah
            </p>
        </div>

        @php
            $menunggu = $pengajuans->where('status', 'menunggu')->count();
            $disetujui = $pengajuans->where('status', 'disetujui_kepsek')->count();
            $totalAnggaran = $pengajuans->sum('jumlah_dana');
            $realisasi = $pengajuans->where('status', 'disetujui')->sum('jumlah_dana');
        @endphp

        <!-- STATISTIK -->
        <div class="grid grid-cols-2 gap-4">

            <div class="bg-yellow-100 p-4 rounded-2xl shadow flex items-center gap-3">
                <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/clock.svg') }}" class="w-5 h-5">
                </div>
                <div>
                    <p class="text-sm text-gray-600">Menunggu</p>
                    <p class="text-lg font-bold text-yellow-700">{{ $menunggu }}</p>
                </div>
            </div>

            <div class="bg-green-100 p-4 rounded-2xl shadow flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/check.svg') }}" class="w-5 h-5">
                </div>
                <div>
                    <p class="text-sm text-gray-600">Disetujui</p>
                    <p class="text-lg font-bold text-green-700">{{ $disetujui }}</p>
                </div>
            </div>

            <div class="bg-blue-100 p-4 rounded-2xl shadow flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/money.svg') }}" class="w-5 h-5">
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Anggaran</p>
                    <p class="text-lg font-bold text-blue-700">
                        Rp {{ number_format($totalAnggaran) }}
                    </p>
                </div>
            </div>

            <div class="bg-purple-100 p-4 rounded-2xl shadow flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/chart.svg') }}" class="w-5 h-5">
                </div>
                <div>
                    <p class="text-sm text-gray-600">Realisasi</p>
                    <p class="text-lg font-bold text-purple-700">
                        Rp {{ number_format($realisasi) }}
                    </p>
                </div>
            </div>

        </div>

        <!-- MENU UTAMA -->
        <div class="grid grid-cols-2 gap-4">

            <a href="/dashboard/kepsek/persetujuan"
                class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">

                <div class="w-14 h-14 mx-auto rounded-xl bg-blue-500 
                    flex items-center justify-center">
                    <img src="{{ asset('icons/approval.svg') }}" class="w-6 h-6">
                </div>

                <p class="mt-3 text-sm font-medium">Persetujuan</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">

                <div class="w-14 h-14 mx-auto rounded-xl bg-green-500 
                    flex items-center justify-center">
                    <img src="{{ asset('icons/report.svg') }}" class="w-6 h-6">
                </div>

                <p class="mt-3 text-sm font-medium">Laporan</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">

                <div class="w-14 h-14 mx-auto rounded-xl bg-purple-500 
                    flex items-center justify-center">
                    <img src="{{ asset('icons/rkas.svg') }}" class="w-6 h-6">
                </div>

                <p class="mt-3 text-sm font-medium">Status RKAS</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">

                <div class="w-14 h-14 mx-auto rounded-xl bg-orange-500 
                    flex items-center justify-center">
                    <img src="{{ asset('icons/notification.svg') }}" class="w-6 h-6">
                </div>

                <p class="mt-3 text-sm font-medium">Notifikasi</p>
            </a>

        </div>

        <!-- PERSETUJUAN TERTUNDA -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-gray-700 font-semibold">Persetujuan Tertunda</h2>
                <a href="#" class="text-blue-600 text-sm">Lihat Semua</a>
            </div>

            <div class="space-y-4">

                @foreach($pengajuans->where('status', 'menunggu') as $pengajuan)

                    <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-yellow-400">

                        <!-- HEADER -->
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $pengajuan->judul }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $pengajuan->user->name ?? '-' }}
                                </p>
                                <p class="text-sm font-medium text-gray-700 mt-1">
                                    Rp {{ number_format($pengajuan->jumlah_dana) }}
                                </p>
                            </div>

                            <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">
                                Pending
                            </span>
                        </div>

                        <!-- BUTTON -->
                        <div class="flex gap-3 mt-4">

                            <form action="/pengajuan/{{ $pengajuan->id }}/approve" method="POST">
                                @csrf
                                <button
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm shadow">
                                    Setujui
                                </button>
                            </form>

                            <form action="/pengajuan/{{ $pengajuan->id }}/reject" method="POST">
                                @csrf
                                <input type="hidden" name="alasan_penolakan" value="Ditolak oleh Kepala Sekolah">
                                <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm shadow">
                                    Tolak
                                </button>
                            </form>

                        </div>

                    </div>

                @endforeach

            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-blue-500">

    <div class="flex justify-between items-start">
        <div>
            <p class="font-semibold text-gray-800">
                RKAS Tahun 2025
            </p>
            <p class="text-sm text-gray-500">
                Siti Nurhaliza
            </p>
            <p class="text-sm font-medium text-gray-700 mt-1">
                Total: Rp 500.000.000
            </p>
        </div>

        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
            Review
        </span>
    </div>

    <button class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm shadow">
        Tinjau Detail
    </button>

</div>

</body>

</html>