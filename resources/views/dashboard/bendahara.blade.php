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
        .notification-dropdown {
            display: none;
        }
        .notification-dropdown.active {
            display: block;
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
                <div class="relative">
                    <button id="notiBtn" class="relative p-2.5 bg-white/10 rounded-full hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($notifications->count() > 0)
                            <span class="absolute -top-1 -right-1 h-5 w-5 bg-rose-500 border-2 border-blue-600 rounded-full flex items-center justify-center text-[8px] font-black">
                                {{ $notifications->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown Notifikasi -->
                    <div id="notiDropdown" class="notification-dropdown absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-[100]">
                        <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Notifikasi Baru</h3>
                            <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-bold">{{ $notifications->count() }}</span>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse($notifications as $notif)
                                <div class="p-5 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0 relative">
                                    <p class="text-xs font-bold text-gray-800 mb-1 leading-relaxed">{{ $notif->data['message'] }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <div class="p-10 text-center space-y-3">
                                    <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest leading-loose">Tidak ada<br>notifikasi baru ✨</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

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
                    <p class="text-2xl font-black text-gray-900">
                        @if($totalSaldo >= 1000000000)
                            {{ number_format($totalSaldo/1000000000, 1) }}M
                        @elseif($totalSaldo >= 1000000)
                            {{ number_format($totalSaldo/1000000, 1) }}Jt
                        @else
                            Rp {{ number_format($totalSaldo, 0, ',', '.') }}
                        @endif
                    </p>
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
                    <p class="text-2xl font-black text-emerald-600">
                        @if($totalMasuk >= 1000000000)
                            {{ number_format($totalMasuk/1000000000, 1) }}M
                        @elseif($totalMasuk >= 1000000)
                            {{ number_format($totalMasuk/1000000, 1) }}Jt
                        @else
                            Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                        @endif
                    </p>
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
                    <p class="text-2xl font-black text-rose-600">
                        @if($totalKeluar >= 1000000000)
                            {{ number_format($totalKeluar/1000000000, 1) }}M
                        @elseif($totalKeluar >= 1000000)
                            {{ number_format($totalKeluar/1000000, 1) }}Jt
                        @else
                            Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                        @endif
                    </p>
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
                            <span class="font-black text-lg">{{ $pengajuans->count() }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Pengajuan Cair</h3>
                            <p class="text-xs text-gray-400 font-medium tracking-wide leading-relaxed">{{ $pengajuans->count() }} pengajuan siap dicairkan hari ini.</p>
                        </div>
                    </div>
                    <a href="/pencairan" class="bg-blue-600 text-white p-3 rounded-2xl hover:bg-blue-700 transition shadow-lg shadow-blue-100 active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Action Case 2 (Dynamic) -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm card-premium flex items-center justify-between group">
                    @php
                        $rkas_draft = \App\Models\RKAS::where('status', 'menunggu')->count();
                    @endphp
                    <div class="flex items-center gap-6">
                        <div class="w-14 h-14 rounded-full {{ $rkas_draft > 0 ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center shadow-inner group-hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Status RKAS</h3>
                            <p class="text-xs text-gray-400 font-medium tracking-wide leading-relaxed">
                                @if($rkas_draft > 0)
                                    Ada {{ $rkas_draft }} RKAS menunggu persetujuan Kepsek.
                                @else
                                    Seluruh RKAS sudah terverifikasi dengan baik.
                                @endif
                            </p>
                        </div>
                    </div>
                    <a href="/rkas/status" class="bg-orange-500 text-white p-3 rounded-2xl hover:bg-orange-600 transition shadow-lg shadow-orange-100 active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- NOTIFIKASI & AKTIVITAS TERBARU -->
        <section class="pb-32">
            <div class="flex justify-between items-center mb-8 px-2">
                <div>
                    <h2 class="text-gray-900 font-black text-xl tracking-tight leading-none mb-1">Notifikasi & Aktivitas</h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Update terbaru sistem hari ini</p>
                </div>
                <button class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-700 transition">Lihat Semua</button>
            </div>

            <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                @forelse($notifications as $notif)
                    <div class="p-8 flex items-start gap-6 border-b border-gray-50 hover:bg-gray-50/50 transition-all group {{ $loop->last ? 'border-b-0' : '' }}">
                        <div class="w-12 h-12 rounded-2xl flex-shrink-0 flex items-center justify-center shadow-lg transition group-hover:scale-110
                            {{ $notif->data['type'] == 'RKAS' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                            @if($notif->data['type'] == 'RKAS')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 space-y-1">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-900 text-sm tracking-tight">{{ $notif->data['title'] }}</h4>
                                <span class="text-[10px] text-gray-400 font-bold tracking-tighter">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">{{ $notif->data['message'] }}</p>
                        </div>
                        <div class="w-2 h-2 rounded-full bg-blue-500 shadow-lg shadow-blue-200 mt-2"></div>
                    </div>
                @empty
                    <div class="p-20 text-center space-y-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Tidak ada notifikasi baru</p>
                    </div>
                @endforelse
            </div>
        </section>

    <script>
        // Notification Toggle
        const notiBtn = document.getElementById('notiBtn');
        const notiDropdown = document.getElementById('notiDropdown');

        if (notiBtn && notiDropdown) {
            notiBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notiDropdown.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!notiDropdown.contains(e.target) && e.target !== notiBtn) {
                    notiDropdown.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>
