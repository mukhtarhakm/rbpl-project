<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti - BOS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 lg:px-6 h-16 flex items-center gap-4">
            <a href="/dashboard/civitas" class="p-2 -ml-2 rounded-full hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg tracking-wide">Upload Bukti</h1>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 lg:px-6 mt-8">

        <!-- INFO BOX -->
        <div class="bg-blue-50 border border-blue-100 p-5 rounded-2xl mb-8 flex items-start gap-4">
            <div class="bg-blue-600 p-2 rounded-xl text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-blue-700 text-sm font-semibold leading-relaxed">
                Pilih pengajuan yang sudah dicairkan untuk upload bukti pengeluaran.
            </p>
        </div>

        <!-- LIST CONTAINER -->
        <div class="space-y-4">
            <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Pengajuan yang Sudah Dicairkan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($pengajuans as $item)
                    <div class="bg-white p-5 rounded-3xl border border-gray-100 card-hover flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="font-bold text-gray-900 leading-tight group-hover:text-blue-600 transition">{{ $item->judul }}</h3>
                                <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">
                                    Dicairkan
                                </span>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-lg font-black text-gray-900">Rp {{ number_format($item->jumlah_dana, 0, ',', '.') }}</p>
                                <p class="text-[10px] text-gray-400 font-medium tracking-wide">Dicairkan: {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}</p>
                            </div>
                        </div>
                        
                        <a href="/civitas/upload-bukti/{{ $item->id }}" class="w-full bg-blue-50 text-blue-600 font-bold text-sm py-3 rounded-xl border border-blue-100 hover:bg-blue-600 hover:text-white transition text-center active:scale-[0.98]">
                            Upload Bukti
                        </a>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 text-center py-20 bg-white rounded-[2.5rem] border-2 border-dashed border-gray-100">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm font-bold">Tidak ada pengajuan yang perlu diupload buktinya.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    @if (session('success_upload'))
        <!-- SUCCESS MODAL (Persistent state if needed) -->
        <div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="this.parentElement.remove()"></div>
            <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full text-center shadow-2xl relative z-10 animate-[scale-up_0.3s_ease-out]">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 scale-110">
                    <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-black text-gray-900 text-lg mb-2">Upload Berhasil!</h3>
                <p class="text-sm font-medium text-gray-500 leading-relaxed mb-6">Bukti pengeluaran telah diupload dan menunggu verifikasi.</p>
                <button onclick="this.parentElement.parentElement.remove()" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    <style>
        @keyframes scale-up {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</body>
</html>
