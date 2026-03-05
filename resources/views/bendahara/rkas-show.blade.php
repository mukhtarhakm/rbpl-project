<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail RKAS - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-premium { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-32">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center shadow-lg sticky top-0 z-50">
        <a href="/rkas/status" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-extrabold tracking-tight">RKAS {{ $rkas->tahun_ajaran }}</h1>
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- HEADER INFO CARD -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="flex justify-between items-start">
                <div class="space-y-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest leading-relaxed">
                        RKAS Tahun Ajaran<br>
                        <span class="text-gray-900 text-lg">{{ $rkas->tahun_ajaran }}</span>
                    </p>
                    <div class="space-y-1">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Anggaran:</p>
                        <p class="text-lg font-black text-gray-900">Rp {{ number_format($rkas->jumlah_dana, 0, ',', '.') }}</p>
                    </div>
                </div>
                <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-4 py-2 rounded-full border border-emerald-100 uppercase tracking-widest shadow-sm">
                    {{ $rkas->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="space-y-1">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Realisasi:</p>
                    <p class="text-lg font-black text-emerald-600">
                        @php $total_realisasi = collect($rkas->kegiatan_list)->sum('realisasi'); @endphp
                        Rp {{ number_format($total_realisasi, 0, ',', '.') }}
                    </p>
                </div>
                <div class="space-y-1 text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Persentase:</p>
                    @php $percentage = $rkas->jumlah_dana > 0 ? round(($total_realisasi / $rkas->jumlah_dana) * 100) : 0; @endphp
                    <p class="text-2xl font-black text-blue-600">{{ $percentage }}%</p>
                </div>
            </div>
        </div>

        <!-- PROGRESS BAR SECTION -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Progress Realisasi</h3>
            <div class="h-4 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full shadow-lg shadow-blue-200" style="width: {{ $percentage }}%"></div>
            </div>
            <p class="text-center text-xs font-bold text-gray-400">{{ $percentage }}% Terealisasi</p>
        </div>

        <!-- TIMELINE SECTION -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-6">
            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Timeline</h3>
            <div class="space-y-6 relative">
                <div class="absolute left-3 top-3 bottom-3 w-px bg-gray-100"></div>
                
                <div class="flex items-start gap-6 relative">
                    <div class="bg-blue-600 w-6 h-6 rounded-lg flex items-center justify-center text-white z-10 shrink-0 shadow-lg shadow-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm">Dibuat</p>
                        <p class="text-xs text-gray-400 font-medium">{{ $rkas->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-6 relative">
                    <div class="bg-emerald-500 w-6 h-6 rounded-lg flex items-center justify-center text-white z-10 shrink-0 shadow-lg shadow-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm">Disetujui</p>
                        <p class="text-xs text-gray-400 font-medium">{{ $rkas->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RINCIAN KEGIATAN LIST -->
        <div class="space-y-4 pb-10">
            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest px-2">Rincian Kegiatan</h3>
            
            @if($rkas->kegiatan_list)
                @foreach($rkas->kegiatan_list as $kegiatan)
                    @php 
                        $k_amount = $kegiatan['amount'] ?? 0;
                        $k_realisasi = $kegiatan['realisasi'] ?? 0;
                        $k_percent = $k_amount > 0 ? round(($k_realisasi / $k_amount) * 100, 1) : 0;
                    @endphp
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 card-premium space-y-4">
                        <h4 class="font-bold text-gray-900 text-sm">{{ $kegiatan['name'] ?? 'Kegiatan' }}</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[11px] font-medium text-gray-400">
                                <span>Anggaran:</span>
                                <span class="text-gray-900 font-bold">Rp {{ number_format($k_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-[11px] font-medium text-gray-400">
                                <span>Realisasi:</span>
                                <span class="text-emerald-600 font-bold">Rp {{ number_format($k_realisasi, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="h-1.5 w-full bg-gray-50 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $k_percent }}%"></div>
                            </div>
                            <p class="text-right text-[10px] font-black text-gray-300 tracking-tighter">{{ $k_percent }}%</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </main>

</body>
</html>
