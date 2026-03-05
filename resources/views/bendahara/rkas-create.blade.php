<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membuat RKAS - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen pb-20">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white px-6 py-5 flex items-center shadow-sm sticky top-0 z-10">
        <a href="/dashboard/bendahara" class="mr-4 hover:bg-blue-600 p-1 rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-bold tracking-tight">Membuat RKAS</h1>
    </header>

    <main class="max-w-md mx-auto p-5 space-y-6">

        <!-- INFO BOX -->
        <div class="bg-blue-50 border border-blue-100 text-blue-700 p-4 rounded-2xl text-sm font-medium leading-relaxed">
            Rencana Kegiatan dan Anggaran Sekolah (RKAS) untuk satu tahun ajaran
        </div>

        <form action="/rkas/store" method="POST" id="rkasForm" class="space-y-6">
            @csrf

            <!-- TAHUN AJARAN -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Tahun Ajaran
                </label>
                <select name="tahun_ajaran" 
                    class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none text-gray-800 font-medium transition-all appearance-none cursor-pointer"
                    required>
                    <option value="" disabled selected>Pilih Tahun Ajaran</option>
                    <option value="2024/2025">2024/2025</option>
                    <option value="2025/2026">2025/2026</option>
                    <option value="2026/2027">2026/2027</option>
                    <option value="2027/2028">2027/2028</option>
                </select>
            </div>

            <!-- ANGGARAN TERSEDIA -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Deskripsi RKAS
                </label>
                <textarea name="deskripsi" 
                    class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 outline-none text-gray-800 font-medium transition-all"
                    placeholder="Masukkan deskripsi singkat mengenai rencana anggaran ini..." rows="3"></textarea>
            </div>

            <!-- ANGGARAN TERSEDIA -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
                <label class="block text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Total Anggaran Tersedia
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-lg font-bold text-gray-800">Rp</span>
                    <input type="number" name="total_anggaran" value="120000000"
                        class="w-full border-none bg-gray-50 rounded-xl p-3 pl-10 focus:ring-2 focus:ring-green-500 text-lg font-bold text-gray-800 outline-none transition-all"
                        placeholder="0" required>
                </div>
            </div>

            <!-- DAFTAR KEGIATAN -->
            <div class="space-y-4">
                <div class="flex justify-between items-center px-1">
                    <h2 class="font-bold text-gray-800">Daftar Kegiatan</h2>
                    <button type="button" onclick="addActivity()" 
                        class="bg-[#2563EB] text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 hover:bg-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah
                    </button>
                </div>

                <div id="activitiesList" class="space-y-4 text-sm">
                    <!-- Dynamic Items Inject here -->
                </div>

                <div class="bg-gray-100/50 p-4 rounded-2xl flex justify-between items-center">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Rencana Anggaran:</span>
                    <span class="text-lg font-bold text-gray-800" id="grandTotal">Rp 0</span>
                </div>
            </div>

            <!-- BUTTON SIMPAN -->
            <div class="pt-4 space-y-4">
                <button type="submit"
                    class="w-full bg-[#2563EB] text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 active:scale-[0.98] transition-all">
                    Simpan RKAS
                </button>

                <!-- NOTES -->
                <div class="p-4 bg-orange-50 rounded-2xl border border-orange-100">
                    <h4 class="text-xs font-bold text-orange-800 mb-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Catatan:
                    </h4>
                    <ul class="text-[10px] text-orange-800/80 space-y-1 font-medium list-disc list-inside">
                        <li>RKAS akan dikirim ke Kepala Sekolah untuk persetujuan.</li>
                        <li>Pastikan semua kegiatan dan anggaran sudah sesuai.</li>
                        <li>Total anggaran tidak boleh melebihi dana tersedia.</li>
                    </ul>
                </div>
            </div>

        </form>

    </main>

    <!-- SUCCESS MODAL -->
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white w-full max-w-xs rounded-[32px] p-8 text-center shadow-2xl scale-100 animate-in fade-in zoom-in duration-300">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-800 mb-2">RKAS Berhasil Dibuat!</h3>
            <p class="text-gray-500 font-medium mb-8 leading-relaxed">
                RKAS telah dlikirim untuk persetujuan Kepala Sekolah.
            </p>

            <button onclick="closeModalAndRedirect()" class="w-full bg-[#2563EB] text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 active:scale-95 transition-all">
                Selesai
            </button>
        </div>
    </div>

    <script>
        function closeModalAndRedirect() {
            window.location.href = '/dashboard/bendahara';
        }
    </script>
    @endif

    <script>
        let activityCount = 0;

        function addActivity() {
            activityCount++;
            const list = document.getElementById('activitiesList');
            const item = document.createElement('div');
            item.className = 'bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-3 relative animate-in slide-in-from-right duration-300';
            item.id = `activity-${activityCount}`;
            
            item.innerHTML = `
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kegiatan ${activityCount}</span>
                    <button type="button" onclick="removeActivity(${activityCount})" class="text-red-400 hover:text-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
                <div>
                    <input type="text" name="activities[${activityCount}][name]" placeholder="Nama kegiatan" 
                        class="w-full border-none bg-gray-50 rounded-xl p-3 focus:ring-1 focus:ring-blue-500 outline-none font-medium text-gray-800 placeholder-gray-400">
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                    <input type="number" name="activities[${activityCount}][amount]" placeholder="Anggaran" oninput="calculateTotal()"
                        class="activity-amount w-full border-none bg-gray-50 rounded-xl p-3 pl-10 focus:ring-1 focus:ring-blue-500 outline-none font-bold text-gray-800 placeholder-gray-400">
                </div>
            `;
            list.appendChild(item);
            calculateTotal();
        }

        function removeActivity(id) {
            const item = document.getElementById(`activity-${id}`);
            item.remove();
            calculateTotal();
        }

        function calculateTotal() {
            const amounts = document.querySelectorAll('.activity-amount');
            let total = 0;
            amounts.forEach(input => {
                total += parseFloat(input.value || 0);
            });
            document.getElementById('grandTotal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
            document.querySelector('input[name="total_anggaran"]').value = total;
        }

        // Add first activity by default
        addActivity();
    </script>
</body>
</html>
