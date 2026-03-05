<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Civitas - BOS Management System</title>
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
        <section class="bg-gradient-to-br from-[#4F46E5] to-[#7C3AED] text-white p-10 rounded-[3rem] shadow-2xl relative overflow-hidden">
            <div class="relative z-10 space-y-2">
                <p class="text-indigo-100 text-sm font-bold tracking-widest uppercase mb-2">Civitas Dashboard</p>
                <h2 class="text-4xl font-black mb-1">
                    Halo, {{ auth()->user()->name ?? 'Civitas' }}
                </h2>
                <p class="text-indigo-100/80 text-lg font-medium max-w-md leading-relaxed">
                    Ajukan dana kegiatan dan pantau statusnya secara real-time.
                </p>
            </div>
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute right-10 top-10 w-20 h-20 bg-indigo-400/20 rounded-full blur-xl"></div>
        </section>

        <!-- STATISTIK -->
        @php
            $aktif = $pengajuans->where('status','menunggu')->count();
            $disetujui = $pengajuans->where('status','disetujui')->count();
            $totalDana = $pengajuans->where('status','disetujui')->sum('jumlah_dana');
        @endphp

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5">
                <div class="bg-amber-100 p-4 rounded-2xl text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Pengajuan Aktif</p>
                    <p class="text-2xl font-black text-gray-900">{{ $aktif }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5">
                <div class="bg-emerald-100 p-4 rounded-2xl text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Disetujui</p>
                    <p class="text-2xl font-black text-gray-900">{{ $disetujui }}</p>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 card-premium flex items-center gap-5">
                <div class="bg-blue-100 p-4 rounded-2xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mb-0.5">Total Dana</p>
                    <p class="text-2xl font-black text-gray-900">{{ number_format($totalDana/1000000, 1) }}M</p>
                </div>
            </div>
        </section>

        <!-- MENU GRID -->
        <section class="space-y-6">
            <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-blue-100 w-fit rounded-md text-[10px] py-1">Menu Utama</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ url('/pengajuan/create') }}" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition duration-500 shadow-xl shadow-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Ajukan Dana</p>
                </a>

                <a href="#" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:-rotate-3 transition duration-500 shadow-xl shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Upload Bukti</p>
                </a>

                <a href="/civitas/riwayat" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500 flex items-center justify-center mb-4 group-hover:scale-110 transition duration-500 shadow-xl shadow-purple-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Riwayat Pengajuan</p>
                </a>

                <a href="#" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center mb-4 group-hover:scale-110 transition duration-500 shadow-xl shadow-orange-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-gray-900 text-center leading-tight">Notifikasi</p>
                </a>
            </div>
        </section>

        <!-- AKTIVITAS TERBARU -->
        <section class="pb-20">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-amber-100 w-fit rounded-md text-[10px] py-1">Aktivitas Terbaru</h2>
                <a href="/civitas/riwayat" class="text-blue-600 text-sm font-black hover:underline underline-offset-4 decoration-2 transition-all">Lihat Semua →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($pengajuans->sortByDesc('created_at')->take(4) as $item)
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm card-premium space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-900 text-base mb-1">{{ Str::limit($item->judul, 30) }}</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm
                                @if($item->status == 'menunggu') bg-amber-50 text-amber-600
                                @elseif($item->status == 'disetujui') bg-emerald-50 text-emerald-600
                                @elseif($item->status == 'ditolak') bg-rose-50 text-rose-600
                                @else bg-gray-50 text-gray-600
                                @endif">
                                {{ $item->status }}
                            </span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-xl font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                            <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 text-sm font-black uppercase tracking-widest">Belum ada aktivitas ✨</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

</body>
</html>
