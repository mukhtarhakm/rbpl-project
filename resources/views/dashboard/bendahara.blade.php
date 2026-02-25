<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Bendahara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
<div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
    <h1 class="text-lg font-semibold">Dashboard Bendahara</h1>
</div>

<div class="p-6 space-y-6">

    <!-- WELCOME CARD -->
    <div class="bg-green-600 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm opacity-80">Selamat Datang,</p>
        <h2 class="text-xl font-semibold">
            {{ auth()->user()->name ?? 'Bendahara' }}
        </h2>
        <p class="text-sm opacity-80">
            Kelola keuangan sekolah dengan efisien
        </p>
    </div>

    <!-- RINGKASAN KEUANGAN -->
    <div class="bg-white p-6 rounded-2xl shadow space-y-4">

        <h2 class="font-semibold text-gray-700">
            Ringkasan Keuangan
        </h2>

        <div class="space-y-3">

            <div class="bg-blue-100 p-4 rounded-xl flex justify-between">
                <span>Total Saldo</span>
                <span class="font-semibold text-blue-700">
                    Rp {{ number_format($totalSaldo ?? 0) }}
                </span>
            </div>

            <div class="bg-green-100 p-4 rounded-xl flex justify-between">
                <span>Dana Masuk</span>
                <span class="font-semibold text-green-700">
                    Rp {{ number_format($totalMasuk ?? 0) }}
                </span>
            </div>

            <div class="bg-red-100 p-4 rounded-xl flex justify-between">
                <span>Dana Keluar</span>
                <span class="font-semibold text-red-700">
                    Rp {{ number_format($totalKeluar ?? 0) }}
                </span>
            </div>

        </div>
    </div>

    <!-- MENU UTAMA -->
    <div>
        <h2 class="font-semibold text-gray-700 mb-4">
            Menu Utama
        </h2>

        <div class="grid grid-cols-2 gap-4">

            <!-- PENERIMAAN DANA -->
            <a href="/penerimaan"
               class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-xl transition">
                <div class="w-16 h-16 mx-auto bg-green-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/penerimaan.svg') }}"
                         class="w-7 h-7">
                </div>
                <p class="mt-4 font-medium text-gray-700">
                    Penerimaan Dana
                </p>
            </a>

            <!-- PENCAIRAN DANA -->
            <a href="/pencairan"
               class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-xl transition">
                <div class="w-16 h-16 mx-auto bg-blue-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/pencairan.svg') }}"
                         class="w-7 h-7">
                </div>
                <p class="mt-4 font-medium text-gray-700">
                    Pencairan Dana
                </p>
            </a>

            <!-- MEMBUAT RKAS -->
            <a href="/rkas"
               class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-xl transition">
                <div class="w-16 h-16 mx-auto bg-purple-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/rkas.svg') }}"
                         class="w-7 h-7">
                </div>
                <p class="mt-4 font-medium text-gray-700">
                    Membuat RKAS
                </p>
            </a>

            <!-- DATA TRANSAKSI -->
            <a href="/transaksi"
               class="bg-white p-6 rounded-2xl shadow-md text-center hover:shadow-xl transition">
                <div class="w-16 h-16 mx-auto bg-orange-500 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('icons/transaksi.svg') }}"
                         class="w-7 h-7">
                </div>
                <p class="mt-4 font-medium text-gray-700">
                    Data Transaksi
                </p>
            </a>

        </div>
    </div>

    <!-- NOTIFIKASI -->
    <div class="bg-white p-4 rounded-2xl shadow flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-red-500 w-10 h-10 rounded-xl flex items-center justify-center">
                <img src="{{ asset('icons/notifikasi.svg') }}"
                     class="w-5 h-5">
            </div>
            <span class="font-medium text-gray-700">
                Notifikasi
            </span>
        </div>

        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
            5
        </span>
    </div>

    <!-- TINDAKAN DIPERLUKAN -->
    <div class="bg-white p-6 rounded-2xl shadow space-y-3">
        <h2 class="font-semibold text-gray-700">
            Tindakan Diperlukan
        </h2>

        <div class="bg-blue-50 p-4 rounded-xl">
            <p class="font-medium text-blue-700">
                7 Pengajuan Siap Dicairkan
            </p>
            <p class="text-sm text-gray-600">
                Total: Rp 12.500.000
            </p>
        </div>

        <div class="bg-green-50 p-4 rounded-xl">
            <p class="font-medium text-green-700">
                Dana BOS Triwulan 4
            </p>
            <p class="text-sm text-gray-600">
                Segera input penerimaan
            </p>
        </div>

    </div>

</div>

</body>
</html>