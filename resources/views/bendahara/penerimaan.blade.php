<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Penerimaan Dana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

<!-- HEADER -->
<div class="bg-[#2563EB] text-white px-6 py-5 flex items-center shadow-sm sticky top-0 z-10">
    <a href="/dashboard/bendahara" class="mr-4 hover:bg-blue-600 p-1 rounded-full transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <h1 class="text-xl font-bold tracking-tight">Penerimaan Dana</h1>
</div>

<div class="max-w-md mx-auto p-5 space-y-6">

    <!-- TOTAL PENERIMAAN -->
    <div class="bg-[#10B981] text-white p-6 rounded-[24px] shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-sm font-medium opacity-90 mb-1">Total Penerimaan</p>
            <h2 class="text-3xl font-bold mb-1">
                Rp {{ number_format($totalPenerimaan ?? 0, 0, ',', '.') }}
            </h2>
            <p class="text-xs font-medium opacity-80">
                Bulan {{ now()->translatedFormat('F Y') }}
            </p>
        </div>
        <!-- Decorative subtle pattern -->
        <div class="absolute right-[-20px] top-[-20px] bg-white/10 w-32 h-32 rounded-full blur-2xl"></div>
    </div>

    <!-- BUTTON INPUT -->
    <a href="/penerimaan/create"
       class="block bg-[#2563EB] text-white text-center py-4 rounded-2xl font-bold shadow-md hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
        </svg>
        Input Dana Masuk
    </a>

    <!-- RIWAYAT -->
    <div class="space-y-4">
        <h2 class="font-bold text-gray-800 text-lg">
            Riwayat Penerimaan
        </h2>

        <div class="space-y-3">
            @forelse($penerimaans as $item)
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center hover:shadow-md transition-shadow">

                    <div class="flex items-center gap-4">
                        <div class="bg-[#DCFCE7] w-12 h-12 rounded-2xl flex items-center justify-center text-[#10B981]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div>
                            <p class="font-bold text-gray-800 line-clamp-1">
                                {{ $item->sumber_dana }}
                            </p>
                            <p class="text-sm text-gray-500 font-medium">
                                {{ \Carbon\Carbon::parse($item->tanggal_penerimaan)->translatedFormat('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-[#10B981] font-bold text-right shrink-0">
                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </div>

                </div>
            @empty
                <div class="bg-white p-10 rounded-3xl border-2 border-dashed border-gray-200 text-center">
                    <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium whitespace-nowrap">Belum ada data penerimaan</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

</body>
</html>