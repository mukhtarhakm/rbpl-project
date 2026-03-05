<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status RKAS - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .progress-bar-glow {
            box-shadow: 0 0 12px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-20">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center justify-between shadow-lg sticky top-0 z-50">
        <div class="flex items-center">
            <a href="/dashboard/{{ auth()->user()->role }}" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-extrabold tracking-tight">Status RKAS</h1>
        </div>
        
        @if(auth()->user()->role == 'bendahara')
        <a href="/rkas" class="bg-white text-[#2563EB] px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-800/20 hover:scale-105 active:scale-95 transition">
            Buat RKAS
        </a>
        @endif
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- SUBTITLE BOX -->
        <div class="bg-blue-50/50 border border-blue-100/50 p-6 rounded-[2rem] text-center">
            <p class="text-blue-600 font-bold text-sm">Pantau status dan realisasi RKAS sekolah</p>
        </div>

        <!-- SUMMARY STATS -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded-[2.5rem] card-premium flex flex-col gap-2">
                <div class="bg-blue-50 w-10 h-10 rounded-xl flex items-center justify-center text-blue-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <p class="text-xl font-black text-blue-600">68%</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Realisasi Aktif</p>
            </div>

            <div class="bg-white p-6 rounded-[2.5rem] card-premium flex flex-col gap-2">
                <div class="bg-emerald-50 w-10 h-10 rounded-xl flex items-center justify-center text-emerald-600 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-xl font-black text-emerald-600">Rp {{ number_format($total_anggaran/1000000, 0) }}Jt</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Anggaran Aktif</p>
            </div>
        </div>

        <!-- LIST RKAS -->
        <div class="space-y-6">
            <h2 class="text-gray-900 font-black text-sm tracking-tight uppercase px-4">Daftar RKAS</h2>

            <div class="space-y-4">
                @forelse($rkas_list as $item)
                    @php
                        // Mock progress for now
                        $progress = $item->status === 'disetujui' ? 68 : ($item->status === 'selesai' ? 97 : 0);
                    @endphp
                    <a href="/rkas/status/{{ $item->id }}" class="bg-white rounded-[2.5rem] p-6 card-premium block space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-4">
                                <div class="bg-purple-50 p-3 rounded-2xl text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h3 class="font-bold text-gray-900">RKAS {{ $item->tahun_ajaran }}</h3>
                                    <p class="text-[10px] text-gray-400 font-medium">Total: Rp {{ number_format($item->jumlah_dana/1000000, 0) }} Juta</p>
                                </div>
                            </div>
                            <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm
                                @if($item->status == 'disetujui') bg-emerald-50 text-emerald-600
                                @elseif($item->status == 'menunggu') bg-amber-50 text-amber-600
                                @elseif($item->status == 'selesai') bg-blue-50 text-blue-600
                                @else bg-gray-50 text-gray-600
                                @endif">
                                {{ $item->status }}
                            </span>
                        </div>

                        @if($item->status != 'menunggu' && $item->status != 'ditolak')
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-[10px] font-bold">
                                <span class="text-gray-400">Realisasi</span>
                                <span class="text-blue-600">{{ $progress }}%</span>
                            </div>
                            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-600 rounded-full progress-bar-glow transition-all duration-1000" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                        @else
                        <div class="h-2 w-full bg-gray-50 rounded-full"></div>
                        @endif

                        <div class="flex justify-between items-center pt-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Dibuat: {{ $item->created_at->format('d M Y') }}</p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 text-sm font-black uppercase tracking-widest">Belum ada RKAS ✨</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

</body>
</html>
