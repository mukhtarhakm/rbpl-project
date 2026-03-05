<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-premium { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <h1 class="font-extrabold text-xl tracking-tight">BOS <span class="text-blue-200">System</span></h1>
            
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <button class="relative p-2.5 bg-white/10 rounded-full hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-0 right-0 h-3 w-3 bg-rose-500 border-2 border-blue-600 rounded-full"></span>
                </button>

                <!-- Logout -->
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2.5 bg-white/10 rounded-full hover:bg-rose-500 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 mt-10 space-y-10">

        <!-- WELCOME CARD -->
        <section class="bg-gradient-to-br from-[#059669] to-[#10B981] text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <p class="text-emerald-100 text-sm font-bold tracking-widest uppercase mb-2">Treasurer Dashboard</p>
                <h2 class="text-4xl font-black mb-1">
                    Halo, {{ auth()->user()->name ?? 'Bendahara' }}
                </h2>
                <p class="text-emerald-100/80 text-lg font-medium max-w-md leading-relaxed">
                    Kelola arus kas sekolah dan pastikan setiap transaksi tercatat dengan benar.
                </p>
            </div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute right-10 top-10 w-20 h-20 bg-emerald-400/20 rounded-full blur-xl"></div>
        </section>

        <!-- RINGKASAN KEUANGAN -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5">
                <div class="bg-blue-100 p-4 rounded-2xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Total Saldo</p>
                    <p class="text-2xl font-black text-gray-900">Rp {{ number_format($totalSaldo ?? 90000000) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5 border-l-4 border-l-emerald-500">
                <div class="bg-emerald-100 p-4 rounded-2xl text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Dana Masuk</p>
                    <p class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalMasuk ?? 50000) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5 border-l-4 border-l-rose-500">
                <div class="bg-rose-100 p-4 rounded-2xl text-rose-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Dana Keluar</p>
                    <p class="text-2xl font-black text-rose-600">Rp {{ number_format($totalKeluar ?? 32500) }}</p>
                </div>
            </div>
        </section>

        <!-- MENU GRID -->
        <section class="space-y-6">
            <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-emerald-100 w-fit rounded-md text-[10px] py-1">Menu Utama</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="/penerimaan" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition duration-500 shadow-xl shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Penerimaan Dana</p>
                </a>

                <a href="/pencairan" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:-rotate-3 transition duration-500 shadow-xl shadow-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Pencairan Dana</p>
                </a>

                <a href="/rkas/status" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500 flex items-center justify-center mb-4 group-hover:scale-110 transition duration-500 shadow-xl shadow-purple-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Membuat RKAS</p>
                </a>

                <a href="/transaksi" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center mb-4 group-hover:scale-110 transition duration-500 shadow-xl shadow-orange-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Data Transaksi</p>
                </a>
            </div>
        </section>

        <!-- TINDAKAN DIPERLUKAN -->
        <section class="pb-20">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-rose-100 w-fit rounded-md text-[10px] py-1">Tindakan Diperlukan</h2>
                <span class="text-rose-600 text-xs font-black">Penting & Mendesak</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Action Case 1 -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm card-premium flex items-center justify-between group">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner group-hover:scale-110 transition">
                            <span class="font-black text-lg">7</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Pengajuan Cair</h3>
                            <p class="text-xs text-gray-400 font-medium tracking-wide leading-relaxed">7 pengajuan siap dicairkan hari ini.</p>
                        </div>
                    </div>
                    <a href="/pencairan" class="bg-blue-600 text-white p-3 rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Action Case 2 -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm card-premium flex items-center justify-between group">
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Dana BOS Triwulan 1</h3>
                            <p class="text-xs text-gray-400 font-medium tracking-wide leading-relaxed">Input penerimaan anggaran segera.</p>
                        </div>
                    </div>
                    <a href="/penerimaan" class="bg-emerald-600 text-white p-3 rounded-2xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Notifikasi Quick Access -->
            <div class="mt-10 bg-white p-6 rounded-[2.5rem] shadow-sm card-premium flex items-center justify-between group cursor-pointer">
                <div class="flex items-center gap-6">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500 flex items-center justify-center text-white shadow-lg shadow-rose-200 group-hover:rotate-12 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Lihat Semua Notifikasi Pasif</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-rose-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-md">5 Pesan</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 group-hover:text-gray-900 transition translate-x-0 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </section>

    </main>

</body>
</html>
