<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Kas / Data Transaksi - BOS System</title>
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
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center shadow-lg sticky top-0 z-50">
        <a href="/dashboard/bendahara" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-extrabold tracking-tight">Data Transaksi (Buku Kas)</h1>
    </header>

    <main class="max-w-4xl mx-auto px-6 mt-10 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        <!-- INFO CARD -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-emerald-100 w-fit rounded-md text-[10px] py-1 mb-2">Ringkasan Arus Kas</h2>
                <p class="text-gray-400 text-sm font-medium">Laporan rincian uang masuk dan uang keluar sekolah.</p>
            </div>
            <div class="flex gap-4">
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Transaksi</p>
                    <p class="text-xl font-black text-gray-900">{{ $semuaTransaksi->count() }}</p>
                </div>
            </div>
        </div>

        <!-- TRANSACTION LIST -->
        <div class="space-y-4">
            @forelse($semuaTransaksi as $transaksi)
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-50 card-premium flex items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <!-- Icon Tipe -->
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $transaksi['tipe'] === 'masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            @if($transaksi['tipe'] === 'masuk')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-lg {{ $transaksi['tipe'] === 'masuk' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $transaksi['tipe'] === 'masuk' ? 'Penerimaan' : 'Pengeluaran' }}
                                </span>
                                <p class="text-[10px] text-gray-400 font-bold">{{ \Carbon\Carbon::parse($transaksi['tanggal'])->translatedFormat('d M Y') }}</p>
                            </div>
                            <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $transaksi['keterangan'] }}</h3>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Jumlah</p>
                        <p class="text-xl font-black {{ $transaksi['tipe'] === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $transaksi['tipe'] === 'masuk' ? '+' : '-' }} Rp {{ number_format($transaksi['jumlah'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <p class="text-gray-400 text-sm font-black uppercase tracking-widest">Belum ada transaksi tercatat ✨</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
