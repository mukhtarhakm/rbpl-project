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
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center justify-between shadow-lg sticky top-0 z-50">
        <div class="flex items-center">
            <a href="/rkas/status" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-extrabold tracking-tight">RKAS {{ $rkas->tahun_ajaran }}</h1>
        </div>
        
        @if(auth()->user()->role == 'bendahara' && $rkas->status == 'disetujui')
        <button onclick="openRealizationModal()" 
            class="bg-white text-[#2563EB] px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-800/20 hover:scale-105 active:scale-95 transition">
            Catat Pengeluaran
        </button>
        @endif
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-[2rem] flex items-center gap-3 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

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
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Realisasi:</p>
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
            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Progress Keseluruhan</h3>
            <div class="h-4 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-blue-600 rounded-full shadow-lg shadow-blue-200" style="width: {{ $percentage }}%"></div>
            </div>
        </div>

        <!-- RINCIAN KEGIATAN LIST -->
        <div class="space-y-4 pb-10">
            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest px-2">Rincian Kegiatan & Pengeluaran</h3>
            
            @if($rkas->kegiatan_list)
                @foreach($rkas->kegiatan_list as $index => $kegiatan)
                    @php 
                        $k_amount = $kegiatan['amount'] ?? 0;
                        $k_realisasi = $kegiatan['realisasi'] ?? 0;
                        $k_percent = $k_amount > 0 ? round(($k_realisasi / $k_amount) * 100, 1) : 0;
                        $k_details = $kegiatan['details'] ?? [];
                    @endphp
                    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 card-premium space-y-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-900 text-sm">{{ $kegiatan['name'] ?? 'Kegiatan' }}</h4>
                            <span class="text-[10px] font-black {{ $k_percent > 100 ? 'text-rose-500' : 'text-emerald-600' }} uppercase">
                                {{ $k_percent }}% 
                            </span>
                        </div>
                        
                        <!-- Mini Bar -->
                        <div class="h-1.5 w-full bg-gray-50 rounded-full overflow-hidden mb-4">
                            <div class="h-full {{ $k_percent > 100 ? 'bg-rose-500' : 'bg-emerald-500' }} rounded-full" style="width: {{ min($k_percent, 100) }}%"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-[10px] uppercase tracking-widest font-black mb-4">
                            <div class="text-gray-400">Pagu: <span class="text-gray-900">Rp {{ number_format($k_amount, 0, ',', '.') }}</span></div>
                            <div class="text-right text-gray-400">Terpakai: <span class="text-gray-900">Rp {{ number_format($k_realisasi, 0, ',', '.') }}</span></div>
                        </div>

                        <!-- RINCIAN ITEM -->
                        <div class="pt-4 border-t border-gray-50 space-y-3">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Detail Riwayat:</p>
                            @forelse($k_details as $detail)
                                <div class="flex justify-between items-center bg-gray-50/50 p-3 rounded-2xl border border-gray-100">
                                    <div class="space-y-0.5">
                                        <p class="text-[11px] font-bold text-gray-900 leading-tight">{{ $detail['judul'] }}</p>
                                        <p class="text-[9px] text-gray-400 font-medium">
                                            {{ \Carbon\Carbon::parse($detail['tanggal_pencairan'] ?? $detail['updated_at'])->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <p class="text-[11px] font-black text-gray-900">Rp {{ number_format($detail['jumlah_dana'], 0, ',', '.') }}</p>
                                </div>
                            @empty
                                <div class="py-4 text-center">
                                    <p class="text-[10px] text-gray-300 font-bold uppercase tracking-widest italic">Belum ada rincian dana cair ✨</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </main>

    <!-- MODAL REALISASI (BENDAHARA ONLY) -->
    <div id="realizationModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center px-6">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeRealizationModal()"></div>
        <div class="bg-white w-full max-w-sm rounded-[3rem] p-8 shadow-2xl relative z-10 animate-in zoom-in-95 duration-300">
            <h3 class="text-xl font-black text-gray-900 mb-2 text-center">Catat Realisasi</h3>
            <p class="text-xs text-gray-400 font-medium mb-8 text-center uppercase tracking-widest leading-relaxed">Pilih kategori kegiatan dan masukkan nominal dana yang dicairkan.</p>

            <form action="/realisasi-langsung" method="POST" class="space-y-6" id="realizationForm">
                @csrf
                <input type="hidden" name="rkas_id" value="{{ $rkas->id }}">
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest pl-2">Pilih Kegiatan</label>
                    <select name="kegiatan_idx" required
                        class="w-full bg-gray-50 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-emerald-500 font-bold text-sm text-gray-900 appearance-none border border-gray-100 shadow-inner">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($rkas->kegiatan_list as $idx => $keg)
                            <option value="{{ $idx }}">{{ $keg['name'] }} (Sisa: Rp{{ number_format($rkas->getRemainingBudget($idx), 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest pl-2">Jumlah Dana Cair</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-emerald-600">Rp</span>
                        <input type="number" name="jumlah" required min="1"
                            class="w-full bg-gray-50 rounded-2xl p-5 pl-14 outline-none focus:ring-2 focus:ring-emerald-500 font-black text-xl text-gray-900 border border-gray-100 shadow-inner">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest pl-2">Keterangan / Keperluan</label>
                    <textarea name="keterangan" required rows="3"
                        class="w-full bg-gray-50 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-emerald-500 font-bold text-sm text-gray-900 resize-none border border-gray-100 shadow-inner"
                        placeholder="Contoh: Pembayaran internet bulan ini..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeRealizationModal()" 
                        class="flex-1 bg-gray-50 text-gray-400 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-gray-100 hover:text-gray-900 transition active:scale-95">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 bg-[#2563EB] text-white py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] hover:bg-blue-700 shadow-lg shadow-blue-100 transition active:scale-95">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRealizationModal() {
            document.getElementById('realizationModal').classList.remove('hidden');
        }

        function closeRealizationModal() {
            document.getElementById('realizationModal').classList.add('hidden');
        }
    </script>
