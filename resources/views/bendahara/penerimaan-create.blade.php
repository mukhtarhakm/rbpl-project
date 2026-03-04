<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Input Dana Masuk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .input-focus:focus-within { border-color: #2563EB; ring: 2px; ring-color: #2563EB; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="bg-[#2563EB] text-white px-6 py-5 flex items-center shadow-sm sticky top-0 z-10">
        <a href="/penerimaan" class="mr-4 hover:bg-blue-600 p-1 rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-bold tracking-tight">Input Dana Masuk</h1>
    </div>

    <div class="max-w-md mx-auto p-5 space-y-6">

        <!-- INFO CARD -->
        <div class="bg-blue-50 border border-blue-100 text-blue-700 p-4 rounded-2xl text-sm font-medium leading-relaxed">
            Input data penerimaan dana dari pemerintah atau sumber lain
        </div>

        <!-- FORM -->
        <form action="/penerimaan/store" method="POST" class="space-y-4">
            @csrf

            <!-- SUMBER DANA -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Sumber Dana
                </label>
                <input type="text" name="sumber_dana"
                    class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none text-gray-800 font-medium placeholder-gray-400 transition-all"
                    placeholder="Contoh: BOS Reguler Triwulan 4" required>
            </div>

            <!-- JUMLAH DANA -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Jumlah Dana
                </label>
                <div class="relative items-center">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                    <input type="number" name="jumlah"
                        class="w-full border-none bg-gray-50 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-500 outline-none text-gray-800 font-bold placeholder-gray-400 transition-all"
                        placeholder="0" required>
                </div>
            </div>

            <!-- TANGGAL -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Tanggal Penerimaan
                </label>
                <input type="date" name="tanggal_penerimaan"
                    class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-2 focus:ring-purple-500 outline-none text-gray-800 font-medium transition-all"
                    required>
            </div>

            <!-- KETERANGAN -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Keterangan (Opsional)
                </label>
                <textarea name="keterangan" rows="3"
                    class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-2 focus:ring-gray-400 outline-none text-gray-800 font-medium placeholder-gray-400 transition-all"
                    placeholder="Tambahkan keterangan jika perlu"></textarea>
            </div>

            <!-- BUTTON -->
            <div class="pt-4 space-y-3">
                <button type="submit"
                    class="w-full bg-[#10B981] text-white py-4 rounded-2xl font-bold shadow-md hover:bg-emerald-600 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Penerimaan Dana
                </button>

                <a href="/penerimaan" class="block w-full text-center py-3 text-gray-500 font-bold hover:text-gray-700 transition-colors">
                    Batal
                </a>
            </div>

        </form>

    </div>

    <!-- SUCCESS MODAL -->
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white w-full max-w-xs rounded-[32px] p-8 text-center shadow-2xl scale-100 animate-in fade-in zoom-in duration-300">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Data Tersimpan!</h3>
            <p class="text-gray-500 font-medium mb-8 leading-relaxed">
                Penerimaan dana telah berhasil dicatat.
            </p>

            <button onclick="closeModalAndRedirect()" class="w-full bg-[#2563EB] text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 active:scale-95 transition-all">
                Selesai
            </button>
        </div>
    </div>

    <script>
        function closeModalAndRedirect() {
            const modal = document.getElementById('successModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                window.location.href = '/penerimaan';
            }, 300);
        }

        // Auto redirect after 3 seconds if user doesn't click
        // setTimeout(closeModalAndRedirect, 3000);
    </script>
    @endif

</body>

</html>
