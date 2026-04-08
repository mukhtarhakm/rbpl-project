<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pencairan - BOS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20 relative">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 lg:px-6 h-16 flex items-center gap-4">
            <a href="/pencairan" class="p-2 -ml-2 rounded-full hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg tracking-wide">Detail Pengajuan</h1>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 lg:px-6 mt-6">
        
        <!-- CARD DETAIL -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col min-h-[60vh] relative">
            <div class="flex justify-between items-start mb-6 border-b border-gray-50 pb-6">
                <div>
                    <h2 class="font-black text-gray-900 text-xl leading-tight mb-2">{{ $pengajuan->judul }}</h2>
                    <p class="text-sm text-gray-500 font-medium">Pemohon: <span class="text-gray-900 font-bold">{{ $pengajuan->user->name ?? 'Pengguna' }}</span></p>
                    <p class="text-lg font-black text-gray-900 mt-3">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 font-medium mt-1">Diajukan: {{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d M Y') }}</p>
                </div>
                
                @if($pengajuan->status == 'disetujui_kepsek')
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm">
                        Disetujui
                    </span>
                @elseif($pengajuan->status == 'selesai')
                    <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm">
                        Selesai
                    </span>
                @else
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm">
                        Dicairkan
                    </span>
                @endif
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Deskripsi</h3>
                <p class="text-gray-700 text-sm leading-relaxed font-medium">
                    {{ $pengajuan->deskripsi }}
                </p>
            </div>

            <!-- STATE SUDAH DICAIRKAN -->
            @if(in_array($pengajuan->status, ['dicairkan', 'selesai']))
                <div class="mb-8">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Bukti Pembayaran</h3>
                    
                    @if($pengajuan->bukti_pengeluaran)
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center border-dashed">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-gray-700 mb-1">Bukti telah diupload</p>
                            <a href="{{ asset('storage/bukti/' . $pengajuan->bukti_pengeluaran) }}" target="_blank" class="text-blue-600 text-xs font-bold hover:underline">
                                Lihat Bukti
                            </a>
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center border-dashed">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500">Bukti belum di upload</p>
                        </div>
                    @endif
                </div>

                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-xl flex items-start gap-3 mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-[11px] text-emerald-800 font-bold leading-relaxed mt-0.5">
                        Dana telah dicairkan. Menunggu konfirmasi civitas untuk bukti pengeluaran.
                    </p>
                </div>
            @endif

            <div class="flex-1"></div>

            <!-- TOMBOL AKSI BAWAH -->
            @if($pengajuan->status == 'disetujui_kepsek')
                <div class="mt-8">
                    <div class="bg-blue-50 text-blue-800 text-[11px] font-bold p-4 rounded-xl flex items-start gap-3 mb-6 shadow-sm border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pastikan semua data sudah benar sebelum mencairkan dana.
                    </div>

                    <button type="button" onclick="openModal()" class="w-full bg-[#2563EB] hover:bg-blue-700 text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-blue-200 transition active:scale-95">
                        Cairkan Dana
                    </button>
                </div>
            @elseif($pengajuan->status == 'dicairkan')
                <div class="mt-8">
                    <button disabled class="w-full bg-gray-200 text-gray-500 font-bold text-sm py-4 rounded-2xl shadow-sm cursor-not-allowed transition">
                        Belum Dapat Diselesaikan (Bukti Belum Diunggah)
                    </button>
                </div>
            @elseif($pengajuan->status == 'selesai')
                <div class="mt-8">
                    <a href="/pencairan" class="block text-center w-full bg-[#059669] hover:bg-emerald-700 text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-emerald-200 transition active:scale-95">
                        Tutup & Selesai
                    </a>
                </div>
            @endif

        </div>

    </main>

    <!-- CONFIRMATION MODAL -->
    @if($pengajuan->status == 'disetujui_kepsek')
        <div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
            
            <div class="bg-white rounded-3xl p-6 w-full max-w-sm relative z-10 shadow-2xl animate-[scale-up_0.2s_ease-out]">
                <h3 class="font-black text-gray-900 text-lg mb-2">Konfirmasi Pencairan</h3>
                <p class="text-sm font-medium text-gray-500 leading-relaxed mb-6">
                    Yakin ingin mencairkan dana sebesar <strong class="text-gray-900">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</strong> untuk pengajuan {{ $pengajuan->judul }}?
                </p>
                
                <div class="flex gap-3">
                    <button onclick="closeModal()" type="button" class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition active:scale-95">
                        Batal
                    </button>
                    <!-- Form untuk mencairkan -->
                    <form action="/pengajuan/{{ $pengajuan->id }}/cairkan" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full h-full py-3 rounded-xl bg-[#2563EB] text-white font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 active:scale-95">
                            Ya, Cairkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        function openModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
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
