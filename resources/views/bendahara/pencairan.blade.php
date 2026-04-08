<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencairan Dana - BOS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tab-btn.active {
            background-color: #2563EB;
            color: white;
        }
        .tab-btn {
            background-color: transparent;
            color: #6B7280;
            border: 1px solid #E5E7EB;
        }
        .card-hover {
            transition: all 0.2s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 lg:px-6 h-16 flex items-center gap-4">
            <a href="/dashboard/bendahara" class="p-2 -ml-2 rounded-full hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg tracking-wide">Pencairan Dana</h1>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 lg:px-6 mt-6">

        <!-- SUCCESS ALERT -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Flash success modal for aesthetics
                    const modal = document.getElementById('successModal');
                    if(modal) {
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 3000);
                    }
                });
            </script>
        @endif

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <p class="text-blue-600 text-sm font-medium leading-relaxed">
                Pencairan dana yang telah disetujui Kepala Sekolah.
            </p>
        </div>

        <!-- TABS -->
        <div class="flex gap-3 mb-6">
            <button onclick="switchTab('siap')" id="btn-siap" class="tab-btn active flex-1 py-2.5 rounded-full text-sm font-semibold transition">
                Siap Dicairkan ({{ $siap_cair->count() }})
            </button>
            <button onclick="switchTab('sudah')" id="btn-sudah" class="tab-btn flex-1 py-2.5 rounded-full text-sm font-semibold transition">
                Sudah Dicairkan ({{ $sudah_cair->count() }})
            </button>
        </div>

        <!-- LIST SIAP DICAIRKAN -->
        <div id="tab-siap" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($siap_cair as $item)
                <a href="/pencairan/detail/{{ $item->id }}" class="block bg-white p-5 rounded-2xl border border-gray-100 card-hover">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-gray-900 leading-tight mb-1">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 font-medium">Pemohon: <span class="text-gray-700">{{ $item->user->name ?? 'Pengguna' }}</span></p>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                            Disetujui
                        </span>
                    </div>
                    <div class="mt-4 flex justify-between items-end">
                        <div>
                            <p class="text-lg font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-1">Diajukan: {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-10">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium text-sm">Tidak ada yang perlu dicairkan.</p>
                </div>
            @endforelse
        </div>

        <!-- LIST SUDAH DICAIRKAN -->
        <div id="tab-sudah" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
            @forelse ($sudah_cair as $item)
                <a href="/pencairan/detail/{{ $item->id }}" class="block bg-white p-5 rounded-2xl border border-gray-100 card-hover">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-gray-900 leading-tight mb-1">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 font-medium">Pemohon: <span class="text-gray-700">{{ $item->user->name ?? 'Pengguna' }}</span></p>
                        </div>
                        @if($item->status == 'selesai')
                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                Selesai
                            </span>
                        @else
                            <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                Dicairkan
                            </span>
                        @endif
                    </div>
                    <div class="mt-4 flex justify-between items-end">
                        <div>
                            <p class="text-lg font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-1">Dicairkan: {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-10">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 font-medium text-sm">Belum ada dana yang dicairkan.</p>
                </div>
            @endforelse
        </div>

    </main>

    <!-- SUCCESS MODAL (Triggered via session) -->
    <div id="successModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>
        <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center shadow-2xl relative z-10 animate-[scale-up_0.3s_ease-out]">
            <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 scale-110">
                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <h3 class="font-black text-gray-900 text-lg mb-2">Dana Dicairkan!</h3>
            <p class="text-sm font-medium text-gray-500 leading-relaxed mb-6">Pencairan berhasil. Status telah diupdate.</p>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const btnSiap = document.getElementById('btn-siap');
            const btnSudah = document.getElementById('btn-sudah');
            const tabSiap = document.getElementById('tab-siap');
            const tabSudah = document.getElementById('tab-sudah');

            if (tab === 'siap') {
                btnSiap.classList.add('active', 'bg-[#2563EB]', 'text-white');
                btnSiap.classList.remove('text-[#6B7280]', 'border', 'border-[#E5E7EB]', 'bg-transparent');
                
                btnSudah.classList.remove('active', 'bg-[#2563EB]', 'text-white');
                btnSudah.classList.add('text-[#6B7280]', 'border', 'border-[#E5E7EB]', 'bg-transparent');

                tabSiap.classList.remove('hidden');
                tabSudah.classList.add('hidden');
            } else {
                btnSudah.classList.add('active', 'bg-[#2563EB]', 'text-white');
                btnSudah.classList.remove('text-[#6B7280]', 'border', 'border-[#E5E7EB]', 'bg-transparent');
                
                btnSiap.classList.remove('active', 'bg-[#2563EB]', 'text-white');
                btnSiap.classList.add('text-[#6B7280]', 'border', 'border-[#E5E7EB]', 'bg-transparent');

                tabSudah.classList.remove('hidden');
                tabSiap.classList.add('hidden');
            }
        }
    </script>
    <style>
        @keyframes scale-up {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</body>
</html>
