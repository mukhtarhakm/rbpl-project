<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Pengeluaran - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tab-active { background-color: #2563EB; color: white; }
        .tab-inactive { background-color: #E5E7EB; color: #4B5563; }
        .card-perspective { perspective: 1000px; }
        .card-premium { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-20">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center shadow-lg sticky top-0 z-50">
        <a href="/dashboard/kepsek" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-extrabold tracking-tight">Persetujuan Pengeluaran</h1>
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8">

        <!-- TABS PILLS -->
        <div class="flex p-1.5 bg-gray-200/80 rounded-[2rem] gap-1 shadow-inner">
            <button onclick="switchTab('permintaan')" id="tab-permintaan"
                class="tab-active flex-1 py-3 rounded-[1.8rem] text-sm font-bold transition-all duration-300">
                Permintaan Dana ({{ $pengajuans->count() }})
            </button>
            <button onclick="switchTab('rkas')" id="tab-rkas"
                class="tab-inactive flex-1 py-3 rounded-[1.8rem] text-sm font-bold transition-all duration-300">
                RKAS ({{ $rkas_list->count() }})
            </button>
        </div>

        <!-- CONTENT: PERMINTAAN DANA -->
        <div id="content-permintaan" class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
            @forelse($pengajuans as $pengajuan)
                <div class="bg-white rounded-[2rem] p-6 card-premium space-y-5">
                    <div class="flex justify-between items-start">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-wider">Permintaan</span>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $pengajuan->judul }}</h3>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Pengaju: <span class="text-gray-900 font-bold ml-1">{{ $pengajuan->user->name ?? '-' }}</span></p>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Diajukan: {{ $pengajuan->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <span class="bg-amber-50 text-amber-600 text-[10px] font-extrabold px-4 py-2 rounded-full border border-amber-100 uppercase tracking-widest shadow-sm">
                            Menunggu
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 pt-2">
                        <a href="/dashboard/kepsek/persetujuan/pengajuan/{{ $pengajuan->id }}" 
                            class="bg-gray-100 text-gray-700 py-3.5 rounded-2xl text-center text-xs font-black hover:bg-gray-200 transition-all border border-gray-200 active:scale-95">
                            Tinjau
                        </a>
                        <form action="/pengajuan/{{ $pengajuan->id }}/approve" method="POST">
                            @csrf
                            <button class="w-full bg-[#10B981] text-white py-3.5 rounded-2xl text-xs font-black hover:bg-[#059669] transition-all shadow-lg shadow-emerald-100 active:scale-95">
                                Setujui
                            </button>
                        </form>
                        <button onclick="openModal({{ $pengajuan->id }}, 'pengajuan')" 
                            class="bg-[#F43F5E] text-white py-3.5 rounded-2xl text-xs font-black hover:bg-[#E11D48] transition-all shadow-lg shadow-rose-100 active:scale-95">
                            Tolak
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[2rem] border-2 border-dashed border-gray-200">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Data Kosong</p>
                    <p class="text-gray-500 font-medium">Tidak ada permintaan dana.</p>
                </div>
            @endforelse
        </div>

        <!-- CONTENT: RKAS -->
        <div id="content-rkas" class="hidden space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
            @forelse($rkas_list as $rkas)
                <div class="bg-white rounded-[2rem] p-6 card-premium space-y-5">
                    <div class="flex justify-between items-start">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="bg-purple-50 text-purple-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase tracking-wider">RKAS</span>
                                <h3 class="font-bold text-gray-900 text-lg">RKAS Tahun {{ $rkas->tahun_ajaran }}</h3>
                            </div>
                            <p class="text-sm text-gray-400 font-medium">Pengaju: <span class="text-gray-900 font-bold ml-1">{{ $rkas->user->name ?? '-' }}</span></p>
                            <p class="text-2xl font-black text-gray-900">Rp {{ number_format($rkas->jumlah_dana, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Diajukan: {{ $rkas->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <span class="bg-amber-50 text-amber-600 text-[10px] font-extrabold px-4 py-2 rounded-full border border-amber-100 uppercase tracking-widest shadow-sm">
                            Menunggu
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 pt-2">
                        <a href="/dashboard/kepsek/persetujuan/rkas/{{ $rkas->id }}" 
                            class="bg-gray-100 text-gray-700 py-3.5 rounded-2xl text-center text-xs font-black hover:bg-gray-200 transition-all border border-gray-200 active:scale-95">
                            Tinjau
                        </a>
                        <form action="/rkas/{{ $rkas->id }}/approve" method="POST">
                            @csrf
                            <button class="w-full bg-[#10B981] text-white py-3.5 rounded-2xl text-xs font-black hover:bg-[#059669] transition-all shadow-lg shadow-emerald-100 active:scale-95">
                                Setujui
                            </button>
                        </form>
                        <button onclick="openModal({{ $rkas->id }}, 'rkas')" 
                            class="bg-[#F43F5E] text-white py-3.5 rounded-2xl text-xs font-black hover:bg-[#E11D48] transition-all shadow-lg shadow-rose-100 active:scale-95">
                            Tolak
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[2rem] border-2 border-dashed border-gray-200">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Data Kosong</p>
                    <p class="text-gray-500 font-medium">Tidak ada RKAS tertunda.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- SUCCESS TOAST -->
    @if(session('success'))
    <div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-gray-900/95 backdrop-blur-md text-white px-8 py-4 rounded-[2rem] text-sm font-bold shadow-2xl animate-in fade-in slide-in-from-bottom-10 duration-500 z-50 flex items-center gap-3">
        <div class="bg-emerald-500 rounded-full p-1 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            toast.classList.add('fade-out', 'translate-y-10');
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    </script>
    @endif

    <!-- MODAL TOLAK PREMIUM -->
    <div id="modalTolak" class="hidden fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white w-full max-w-sm rounded-[3rem] p-10 shadow-2xl animate-in zoom-in duration-300">
            <div class="bg-rose-50 w-20 h-20 rounded-[2rem] flex items-center justify-center mb-6 mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-2 text-center">Alasan Penolakan</h2>
            <p class="text-sm text-gray-500 mb-8 text-center leading-relaxed px-4">Berikan alasan mengapa pengajuan ini ditolak agar pengaju dapat memperbaikinya.</p>

            <form id="formTolak" method="POST" class="space-y-8">
                @csrf
                <textarea name="alasan_penolakan"
                    class="w-full border-none bg-gray-100 rounded-[2rem] p-6 focus:ring-4 focus:ring-rose-200 outline-none text-gray-800 font-bold transition-all resize-none shadow-inner"
                    placeholder="Contoh: Lampiran kurang lengkap..."
                    rows="4" required></textarea>

                <div class="flex gap-4">
                    <button type="button" onclick="closeModal()"
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
        function switchTab(tab) {
            const btnPermintaan = document.getElementById('tab-permintaan');
            const btnRkas = document.getElementById('tab-rkas');
            const contentPermintaan = document.getElementById('content-permintaan');
            const contentRkas = document.getElementById('content-rkas');

            if (tab === 'permintaan') {
                btnPermintaan.classList.add('tab-active');
                btnPermintaan.classList.remove('tab-inactive', 'bg-gray-200/80', 'text-gray-600');
                btnRkas.classList.add('tab-inactive');
                btnRkas.classList.remove('tab-active');
                contentPermintaan.classList.remove('hidden');
                contentRkas.classList.add('hidden');
            } else {
                btnRkas.classList.add('tab-active');
                btnRkas.classList.remove('tab-inactive');
                btnPermintaan.classList.add('tab-inactive');
                btnPermintaan.classList.remove('tab-active');
                contentRkas.classList.remove('hidden');
                contentPermintaan.classList.add('hidden');
            }
        }

        function openModal(id, type) {
            const modal = document.getElementById('modalTolak');
            const form = document.getElementById('formTolak');

            if (type === 'pengajuan') {
                form.action = `/pengajuan/${id}/reject`;
            } else {
                form.action = `/rkas/${id}/reject`;
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modalTolak');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>