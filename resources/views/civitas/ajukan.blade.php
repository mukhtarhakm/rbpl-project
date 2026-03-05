<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Dana - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .input-card:focus-within {
            border-color: #2563EB;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
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
        <h1 class="text-xl font-extrabold tracking-tight">Ajukan Dana</h1>
    </header>

    <main class="max-w-xl mx-auto p-6 space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">

        <!-- INFO BOX -->
        <div class="bg-blue-50/50 border border-blue-100/50 p-6 rounded-[2rem] text-center">
            <p class="text-blue-600 font-bold text-sm">Isi formulir dengan lengkap untuk mengajukan dana dari anggaran BOS</p>
        </div>

        <form action="{{ url('/pengajuan/store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- JUDUL -->
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm input-card space-y-3">
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Judul Pengajuan
                </label>
                <input type="text" name="judul" 
                    class="w-full bg-gray-50/50 rounded-2xl p-4 outline-none border-none focus:ring-0 text-gray-900 font-bold placeholder:text-gray-300 transition-all"
                    placeholder="Contoh: Pembelian ATK Kelas" required>
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm input-card space-y-3">
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    Deskripsi Kebutuhan
                </label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-gray-50/50 rounded-2xl p-4 outline-none border-none focus:ring-0 text-gray-900 font-bold placeholder:text-gray-300 transition-all resize-none"
                    placeholder="Jelaskan kebutuhan dan alasan pengajuan dana..." required></textarea>
            </div>

            <!-- JUMLAH DANA -->
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm input-card space-y-3">
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Jumlah Dana
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-black">Rp</span>
                    <input type="number" name="jumlah_dana" 
                        class="w-full bg-gray-50/50 rounded-2xl p-4 pl-12 outline-none border-none focus:ring-0 text-gray-900 font-black text-xl placeholder:text-gray-300 transition-all"
                        placeholder="0" required>
                </div>
            </div>

            <!-- TANGGAL -->
            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm input-card space-y-3">
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Tanggal Dibutuhkan
                </label>
                <input type="date" name="tanggal_dibutuhkan" 
                    class="w-full bg-gray-50/50 rounded-2xl p-4 outline-none border-none focus:ring-0 text-gray-900 font-bold transition-all"
                    required>
            </div>

            <!-- SUBMIT -->
            <button type="submit" 
                class="w-full bg-[#2563EB] text-white py-6 rounded-[2rem] font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-200 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kirim Pengajuan
            </button>

        </form>

        <!-- NOTES -->
        <div class="bg-gray-50/50 p-8 rounded-[2.5rem] space-y-4">
            <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Catatan:
            </h4>
            <ul class="text-[11px] text-gray-500 font-medium space-y-2">
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-gray-300 rounded-full mt-1.5"></span>
                    Pengajuan akan ditinjau oleh Kepala Sekolah
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-gray-300 rounded-full mt-1.5"></span>
                    Pastikan data yang diisi lengkap dan akurat
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-1 h-1 bg-gray-300 rounded-full mt-1.5"></span>
                    Anda akan menerima notifikasi status pengajuan
                </li>
            </ul>
        </div>

    </main>

    <!-- SUCCESS MODAL -->
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center px-6">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm animate-in fade-in duration-300"></div>
        <div class="bg-white w-full max-w-sm rounded-[3rem] p-10 shadow-2xl relative z-10 animate-in zoom-in-95 fade-in duration-300 flex flex-col items-center text-center space-y-6">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-2xl font-black text-gray-900">Pengajuan Berhasil!</h3>
                <p class="text-sm text-gray-500 font-medium px-4">
                    Pengajuan dana Anda telah dikirim dan menunggu persetujuan.
                </p>
            </div>
            <a href="{{ url('/dashboard/civitas') }}" 
                class="w-full bg-gray-100 text-gray-900 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-gray-200 transition-all text-sm flex items-center justify-center">
                Tutup
            </a>
        </div>
    </div>
    @endif

</body>
</html>