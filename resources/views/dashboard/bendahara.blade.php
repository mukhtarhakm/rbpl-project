<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - BOS Management System</title>
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
            <h1 class="font-bold text-lg tracking-tight">Dashboard Bendahara</h1>
            
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
        <section class="bg-gradient-to-br from-green-600 to-green-800 text-white p-6 rounded-[2rem] shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-green-100 text-sm font-medium mb-1">Selamat Datang,</p>
                <h2 class="text-2xl font-bold mb-2">
                    {{ auth()->user()->name ?? 'Siti Nurhaliza' }}
                </h2>
                <p class="text-green-100/80 text-sm max-w-[200px] leading-relaxed">
                    Kelola keuangan sekolah dengan efisien
                </p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </section>

        <!-- RINGKASAN KEUANGAN -->
        <section class="space-y-4">
            <h2 class="text-gray-800 font-bold text-sm ml-1">Ringkasan Keuangan</h2>
            
            <div class="space-y-3">
                <!-- Total Saldo -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Total Saldo</p>
                            <p class="text-lg font-bold text-gray-800">Rp {{ number_format($totalSaldo ?? 90000000) }}</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 group-hover:text-blue-500 transition" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>

                <!-- Dana Masuk -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition border-l-4 border-l-green-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Dana Masuk</p>
                            <p class="text-lg font-bold text-gray-800 text-green-600">Rp {{ number_format($totalMasuk ?? 50000) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Dana Keluar -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition border-l-4 border-l-red-500">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Dana Keluar</p>
                            <p class="text-lg font-bold text-gray-800 text-red-600">Rp {{ number_format($totalKeluar ?? 32500) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MENU UTAMA -->
        <section>
            <h2 class="text-gray-800 font-bold text-sm mb-4">Menu Utama</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- PENERIMAAN DANA -->
                <a href="/penerimaan" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-green-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Penerimaan Dana</p>
                </a>

                <!-- PENCAIRAN DANA -->
                <a href="/pencairan" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Pencairan Dana</p>
                </a>

                <!-- MEMBUAT RKAS -->
                <a href="/rkas" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-purple-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Membuat RKAS</p>
                </a>

                <!-- DATA TRANSAKSI -->
                <a href="/transaksi" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex flex-col items-center group hover:shadow-md transition">
                    <div class="w-14 h-14 rounded-2xl bg-orange-500 flex items-center justify-center mb-3 group-hover:scale-110 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 text-center">Data Transaksi</p>
                </a>
            </div>
            
            <!-- Notifikasi Row -->
            <div class="mt-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center group hover:shadow-md transition">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800">Notifikasi</span>
                </div>
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">5</span>
            </div>
        </section>

        <!-- TINDAKAN DIPERLUKAN -->
        <section>
            <h2 class="text-gray-800 font-bold text-sm mb-4">Tindakan Diperlukan</h2>

            <div class="space-y-3">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <span class="font-bold text-xs">7</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">7 Pengajuan Siap Dicairkan</h3>
                            <p class="text-xs text-gray-500">Total: Rp 12.500.000</p>
                        </div>
                    </div>
                    <button class="text-blue-600 text-[10px] font-bold uppercase tracking-wider">Cek</button>
                </div>

                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm">Dana BOS Triwulan 1</h3>
                            <p class="text-xs text-gray-500">Segera input penerimaan</p>
                        </div>
                    </div>
                    <button class="text-green-600 text-[10px] font-bold uppercase tracking-wider">Input</button>
                </div>
            </div>
        </section>

    </main>

</body>
</html>
