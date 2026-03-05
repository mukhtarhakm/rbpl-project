<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .filter-chip {
            transition: all 0.2s ease;
        }
        .filter-chip.active {
            box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-20">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-6 flex items-center shadow-lg sticky top-0 z-50">
        <a href="{{ url('/dashboard/civitas') }}" class="mr-4 hover:bg-white/20 p-2 rounded-full transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-extrabold tracking-tight">Riwayat Pengajuan</h1>
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-8 animate-in fade-in duration-500">

        <!-- SEARCH BAR -->
        <div class="relative group">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchInput" 
                class="w-full bg-white border border-gray-100 rounded-[2rem] py-5 pl-14 pr-6 outline-none focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-900 placeholder:text-gray-300 shadow-sm"
                placeholder="Cari pengajuan...">
        </div>

        <!-- FILTER CHIPS -->
        <div class="flex gap-2 overflow-x-auto pb-4 no-scrollbar -mx-2 px-2">
            <button onclick="filterStatus('semua')" id="btn-semua" class="filter-chip active flex-shrink-0 px-6 py-2.5 bg-blue-600 text-white rounded-full text-xs font-black uppercase tracking-widest">
                Semua
            </button>
            <button onclick="filterStatus('menunggu')" id="btn-menunggu" class="filter-chip flex-shrink-0 px-6 py-2.5 bg-white border border-gray-100 text-gray-400 rounded-full text-xs font-black uppercase tracking-widest hover:border-orange-200">
                Menunggu
            </button>
            <button onclick="filterStatus('disetujui')" id="btn-disetujui" class="filter-chip flex-shrink-0 px-6 py-2.5 bg-white border border-gray-100 text-gray-400 rounded-full text-xs font-black uppercase tracking-widest hover:border-emerald-200">
                Disetujui
            </button>
            <button onclick="filterStatus('ditolak')" id="btn-ditolak" class="filter-chip flex-shrink-0 px-6 py-2.5 bg-white border border-gray-100 text-gray-400 rounded-full text-xs font-black uppercase tracking-widest hover:border-rose-200">
                Ditolak
            </button>
        </div>

        <!-- LIST PENGALAMAN -->
        <div id="pengajuanList" class="space-y-4">
            @foreach($pengajuans as $pengajuan)
                <div class=" pengajuan-item bg-white p-6 rounded-[2.5rem] shadow-sm card-premium flex items-center justify-between group" 
                     data-status="{{ $pengajuan->status }}" 
                     data-judul="{{ strtolower($pengajuan->judul) }}">
                    
                    <div class="space-y-1">
                        <h3 class="font-bold text-gray-900 text-base group-hover:text-blue-600 transition">{{ $pengajuan->judul }}</h3>
                        <div class="flex items-center gap-4">
                            <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</p>
                            <span class="text-gray-200 text-xs">•</span>
                            <p class="text-[10px] font-bold text-gray-300">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @if($pengajuan->status == 'menunggu')
                            <span class="bg-amber-50 text-amber-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest border border-amber-100">
                                Menunggu
                            </span>
                        @elseif($pengajuan->status == 'disetujui')
                            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest border border-emerald-100">
                                Disetujui
                            </span>
                        @elseif($pengajuan->status == 'ditolak')
                            <span class="bg-rose-50 text-rose-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest border border-rose-100">
                                Ditolak
                            </span>
                        @elseif($pengajuan->status == 'dicairkan')
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest border border-blue-100">
                                Dicairkan
                            </span>
                        @elseif($pengajuan->status == 'selesai')
                            <span class="bg-gray-50 text-gray-400 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest border border-gray-100">
                                Selesai
                            </span>
                        @endif

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            @endforeach

            <!-- EMPTY STATE -->
            <div id="emptyState" class="hidden text-center py-20 animate-in fade-in slide-in-from-top-4">
                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Data tidak ditemukan</p>
            </div>
        </div>

    </main>

    <script>
        const searchInput = document.getElementById('searchInput');
        const items = document.querySelectorAll('.pengajuan-item');
        const emptyState = document.getElementById('emptyState');
        let currentStatus = 'semua';

        function filterStatus(status) {
            currentStatus = status;
            
            // Update chip styles
            document.querySelectorAll('.filter-chip').forEach(btn => {
                btn.classList.remove('active', 'bg-blue-600', 'bg-amber-500', 'bg-emerald-500', 'bg-rose-500', 'text-white');
                btn.classList.add('bg-white', 'text-gray-400', 'border-gray-100');
            });

            const activeBtn = document.getElementById('btn-' + status);
            activeBtn.classList.remove('bg-white', 'text-gray-400', 'border-gray-100');
            
            if(status === 'semua') activeBtn.classList.add('bg-blue-600', 'text-white');
            else if(status === 'menunggu') activeBtn.classList.add('bg-amber-500', 'text-white');
            else if(status === 'disetujui') activeBtn.classList.add('bg-emerald-500', 'text-white');
            else if(status === 'ditolak') activeBtn.classList.add('bg-rose-500', 'text-white');
            
            activeBtn.classList.add('active');
            
            applyFilters();
        }

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            let hasVisible = false;

            items.forEach(item => {
                const status = item.getAttribute('data-status');
                const judul = item.getAttribute('data-judul');
                
                const matchesStatus = currentStatus === 'semua' || status === currentStatus;
                const matchesSearch = judul.includes(searchTerm);

                if (matchesStatus && matchesSearch) {
                    item.style.display = 'flex';
                    hasVisible = true;
                } else {
                    item.style.display = 'none';
                }
            });

            emptyState.style.display = hasVisible ? 'none' : 'block';
        }

        searchInput.addEventListener('input', applyFilters);
    </script>

</body>
</html>