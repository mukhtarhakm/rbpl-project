<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Persetujuan - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-32">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center shadow-lg sticky top-0 z-50">
        <a href="/dashboard/kepsek/persetujuan" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-extrabold tracking-tight">Detail Persetujuan</h1>
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- HEADER INFO -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="flex justify-between items-start">
                <div class="space-y-3">
                    <span class="{{ $type === 'rkas' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }} text-[10px] font-black px-3 py-1 rounded-lg uppercase tracking-wider">
                        {{ strtoupper($type) }}
                    </span>
                    <h2 class="text-3xl font-black text-gray-900 leading-tight">
                        {{ $type === 'rkas' ? 'RKAS Tahun ' . $item->tahun_ajaran : $item->judul }}
                    </h2>
                    <p class="text-gray-400 font-medium tracking-wide">
                        Pengaju: <span class="text-gray-900 font-bold ml-1">{{ $item->user->name ?? '-' }}</span>
                    </p>
                </div>
                <div class="text-right space-y-2">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Status</p>
                    <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-4 py-2 rounded-full border border-amber-100 uppercase tracking-widest block w-fit ml-auto shadow-sm">
                        {{ $item->status }}
                    </span>
                </div>
            </div>

            <div class="h-px bg-gray-100"></div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total Dana</p>
                    <p class="text-2xl font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Diajukan Pada</p>
                    <p class="text-lg font-bold text-gray-700">{{ $item->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-4">
            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
                Deskripsi
            </h3>
            <p class="text-gray-600 font-medium leading-relaxed">
                {{ $item->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
            </p>
        </div>

        <!-- RINCIAN KEGIATAN (For RKAS) -->
        @if($type === 'rkas' && !empty($item->kegiatan_list))
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 space-y-6">
            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Rincian Kegiatan
            </h3>
            <div class="space-y-4">
                @foreach($item->kegiatan_list as $kegiatan)
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="font-bold text-gray-700">{{ $kegiatan['name'] ?? 'Kegiatan' }}</p>
                    <p class="font-black text-gray-900">Rp {{ number_format($kegiatan['amount'] ?? 0, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </main>

    <!-- STICKY BUTTONS -->
    <div class="fixed bottom-0 left-0 right-0 p-6 bg-white/80 backdrop-blur-xl border-t border-gray-100 z-50">
        <div class="max-w-xl mx-auto flex gap-4">
            <button onclick="openModalDetail()" 
                class="flex-1 bg-[#F43F5E] text-white py-5 rounded-[2rem] font-black shadow-xl shadow-rose-100 hover:bg-[#E11D48] transition-all active:scale-95 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Tolak Pengajuan
            </button>
            <form action="{{ $type === 'rkas' ? '/rkas/'.$item->id.'/approve' : '/pengajuan/'.$item->id.'/approve' }}" method="POST" class="flex-1">
                @csrf
                <button class="w-full bg-[#10B981] text-white py-5 rounded-[2rem] font-black shadow-xl shadow-emerald-100 hover:bg-[#059669] transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Setujui Sekarang
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL TOLAK -->
    <div id="modalTolak" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white w-full max-w-sm rounded-[3rem] p-10 shadow-2xl animate-in zoom-in duration-300">
            <div class="bg-rose-50 w-20 h-20 rounded-[2rem] flex items-center justify-center mb-6 mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-2 text-center">Alasan Penolakan</h2>
            <p class="text-sm text-gray-500 mb-8 text-center leading-relaxed px-4">Berikan alasan mengapa pengajuan ini ditolak agar pengaju dapat memperbaikinya.</p>

            <form action="{{ $type === 'rkas' ? '/rkas/'.$item->id.'/reject' : '/pengajuan/'.$item->id.'/reject' }}" method="POST" class="space-y-8">
                @csrf
                <textarea name="alasan_penolakan"
                    class="w-full border-none bg-gray-100 rounded-[2rem] p-6 focus:ring-4 focus:ring-rose-200 outline-none text-gray-800 font-bold transition-all resize-none shadow-inner"
                    placeholder="Contoh: Lampiran kurang lengkap..."
                    rows="4" required></textarea>

                <div class="flex gap-4">
                    <button type="button" onclick="closeModalDetail()"
                        class="flex-1 bg-gray-100 text-gray-600 py-5 rounded-[2rem] font-black hover:bg-gray-200 transition-all active:scale-95">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-[#F43F5E] text-white py-5 rounded-[2rem] font-black shadow-xl shadow-rose-200 hover:bg-[#E11D48] transition-all active:scale-95">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalDetail() {
            const modal = document.getElementById('modalTolak');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModalDetail() {
            const modal = document.getElementById('modalTolak');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>

</body>
</html>
