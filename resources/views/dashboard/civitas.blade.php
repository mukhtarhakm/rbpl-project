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
        .notification-dropdown {
            display: none;
        }
        .notification-dropdown.active {
            display: block;
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
                <div class="relative">
                    <button id="notiBtn" class="relative p-2.5 bg-white/10 rounded-full hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($notifications->count() > 0)
                            <span class="absolute top-0 right-0 h-3 w-3 bg-rose-500 border-2 border-[#2563EB] rounded-full"></span>
                        @endif
                    </button>

                    <!-- Dropdown Notifikasi -->
                    <div id="notiDropdown" class="notification-dropdown absolute right-0 mt-3 w-80 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                        <div class="p-5 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Notifikasi</h3>
                            <span class="text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-bold">{{ $notifications->count() }} Baru</span>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse($notifications as $noti)
                                <div class="p-5 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                    <p class="text-xs font-bold text-gray-900 mb-1">{{ $noti->data['message'] }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium italic">{{ $noti->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <div class="p-10 text-center">
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-loose">Tidak ada<br>notifikasi baru ✨</p>
                                </div>
                            @endforelse
                        </div>
                        @if($notifications->count() > 0)
                            <a href="/civitas/notifications" class="block p-4 text-center text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50/50 hover:bg-blue-50 transition-all">Lihat Semua Notifikasi</a>
                        @endif
                    </div>
                </div>

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

        <!-- ALERTS -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-100 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-bold">{{ session('error') }}</span>
            </div>
        @endif

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
                    <p class="text-2xl font-black text-gray-900">
                        @if($totalDana >= 1000000000)
                            {{ number_format($totalDana/1000000000, 1) }}M
                        @elseif($totalDana >= 1000000)
                            {{ number_format($totalDana/1000000, 1) }}Jt
                        @else
                            Rp {{ number_format($totalDana, 0, ',', '.') }}
                        @endif
                    </p>
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

                <a href="/civitas/upload-bukti" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
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

                <a href="/civitas/notifications" class="bg-white rounded-[2.5rem] p-10 card-premium flex flex-col items-center group">
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
                    <div onclick='openDetailModal({
                            judul: "{{ addslashes($item->judul) }}",
                            dana: "Rp {{ number_format($item->jumlah_dana, 0, ",", ".") }}",
                            status: "{{ $item->status }}",
                            tanggal: "{{ $item->created_at->format("d M Y") }}",
                            deskripsi: "{{ addslashes($item->deskripsi) }}",
                            alasan: "{{ addslashes($item->alasan_penolakan) }}"
                        })' 
                        class="bg-white p-8 rounded-[2.5rem] shadow-sm card-premium space-y-4 cursor-pointer group">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-900 text-base mb-1 group-hover:text-blue-600 transition-colors">{{ Str::limit($item->judul, 30) }}</h3>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm
                                @if($item->status == 'menunggu') bg-amber-50 text-amber-600
                                @elseif($item->status == 'disetujui' || $item->status == 'disetujui_kepsek') bg-emerald-50 text-emerald-600
                                @elseif($item->status == 'dicairkan') bg-blue-50 text-blue-600
                                @elseif($item->status == 'selesai') bg-purple-50 text-purple-600
                                @elseif($item->status == 'ditolak') bg-rose-50 text-rose-600
                                @else bg-gray-50 text-gray-600
                                @endif">
                                {{ str_replace('_', ' ', $item->status) }}
                            </span>
                        </div>
                        <div class="h-px bg-gray-100"></div>
                        <div class="flex justify-between items-center">
                            <p class="text-xl font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                            <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all">
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

    <!-- MODAL DETAIL -->
    <div id="modalDetail" onclick="closeDetailModal(event)" class="hidden fixed inset-0 z-[100] bg-black/60 backdrop-blur-md flex items-center justify-center p-6 transition-all duration-300">
        <div onclick="event.stopPropagation()" class="bg-white w-full max-w-lg rounded-[3rem] p-10 shadow-2xl animate-in zoom-in duration-300 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50 rounded-full -z-10"></div>
            
            <div class="flex justify-between items-start mb-8">
                <div class="space-y-2">
                    <span id="modalStatus" class="text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm"></span>
                    <h2 id="modalJudul" class="text-2xl font-black text-gray-900 leading-tight"></h2>
                </div>
                <button onclick="closeDetailModal(event)" class="p-2 bg-gray-100 text-gray-400 rounded-full hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-6">
                <!-- Data Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Jumlah Dana</p>
                        <p id="modalDana" class="text-lg font-black text-gray-900"></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Tanggal</p>
                        <p id="modalTanggal" class="text-sm font-bold text-gray-700"></p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2">
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Deskripsi Kegiatan</p>
                    <p id="modalDeskripsi" class="text-sm text-gray-600 leading-relaxed font-medium"></p>
                </div>

                <!-- Alasan Penolakan (Hidden by default) -->
                <div id="modalAlasanContainer" class="hidden bg-rose-50 p-6 rounded-2xl border border-rose-100 space-y-2">
                    <p class="text-[9px] text-rose-400 font-bold uppercase tracking-widest">Alasan Penolakan</p>
                    <p id="modalAlasan" class="text-sm text-rose-700 font-bold leading-relaxed"></p>
                </div>
            </div>

            <button onclick="closeDetailModal(event)" class="w-full mt-10 bg-gray-900 text-white py-5 rounded-[2rem] font-black hover:bg-black transition-all active:scale-95 shadow-xl shadow-gray-200">
                Tutup Detail
            </button>
        </div>
    </div>

    <script>
        function openDetailModal(data) {
            const modal = document.getElementById('modalDetail');
            
            // Populate Data
            document.getElementById('modalJudul').innerText = data.judul;
            document.getElementById('modalDana').innerText = data.dana;
            document.getElementById('modalTanggal').innerText = data.tanggal;
            document.getElementById('modalDeskripsi').innerText = data.deskripsi;
            
            // Handle Status Badge
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.innerText = data.status.replace('_', ' ');
            statusBadge.className = 'text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm ';
            
            if(data.status === 'menunggu') statusBadge.classList.add('bg-amber-50', 'text-amber-600');
            else if(data.status === 'disetujui' || data.status === 'disetujui_kepsek') statusBadge.classList.add('bg-emerald-50', 'text-emerald-600');
            else if(data.status === 'dicairkan') statusBadge.classList.add('bg-blue-50', 'text-blue-600');
            else if(data.status === 'selesai') statusBadge.classList.add('bg-purple-50', 'text-purple-600');
            else if(data.status === 'ditolak') statusBadge.classList.add('bg-rose-50', 'text-rose-600');
            
            // Handle Alasan Penolakan
            const alasanContainer = document.getElementById('modalAlasanContainer');
            if(data.status === 'ditolak' && data.alasan) {
                document.getElementById('modalAlasan').innerText = data.alasan;
                alasanContainer.classList.remove('hidden');
            } else {
                alasanContainer.classList.add('hidden');
            }

            // Show Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Stop scroll
        }

        function closeDetailModal(e) {
            const modal = document.getElementById('modalDetail');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Enable scroll
        }

        // Notification Toggle
        document.getElementById('notiBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('notiDropdown').classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notiDropdown');
            if (!dropdown.contains(e.target) && e.target.id !== 'notiBtn') {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>
</html>
