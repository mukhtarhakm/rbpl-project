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
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-4 lg:px-6 h-16 flex items-center gap-4">
            <a href="/civitas/upload-bukti" class="p-2 -ml-2 rounded-full hover:bg-white/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="font-bold text-lg tracking-wide">Upload Bukti</h1>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 lg:px-6 mt-8">

        <!-- DETAIL PERMINTAAN -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm mb-6">
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-100 p-4 rounded-2xl flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs font-bold text-rose-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Detail Permintaan</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center group">
                    <p class="text-sm font-medium text-gray-500">Judul:</p>
                    <p class="text-sm font-bold text-gray-900">{{ $pengajuan->judul }}</p>
                </div>
                <div class="flex justify-between items-center group">
                    <p class="text-sm font-medium text-gray-500">Jumlah:</p>
                    <p class="text-sm font-black text-blue-600">Rp {{ number_format($pengajuan->jumlah_dana, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-center group">
                    <p class="text-sm font-medium text-gray-500">Status:</p>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 rounded-md uppercase tracking-wider">
                        Dicairkan
                    </span>
                </div>
            </div>
        </div>

        <!-- FORM UPLOAD -->
        <form action="/pengajuan/{{ $pengajuan->id }}/upload-bukti" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Upload Bukti Pengeluaran</h2>

                <!-- DROPZONE -->
                <div id="dropzone" class="relative group cursor-pointer">
                    <input type="file" name="bukti" id="fileInput" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required onchange="handleFileSelect(this)">
                    <div onclick="document.getElementById('fileInput').click()" 
                         class="border-2 border-dashed border-gray-200 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 group-hover:border-blue-400 group-hover:bg-blue-50/30 transition duration-300">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold text-gray-900">Tap untuk pilih file</p>
                            <p class="text-xs text-gray-500 mt-1">atau drag & drop</p>
                            <p class="text-[10px] text-gray-400 mt-3 font-semibold">JPG, PNG, PDF (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- FILE PREVIEW (Hidden by default) -->
                <div id="filePreview" class="hidden bg-gray-50 p-4 rounded-xl border border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white p-2 rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p id="fileName" class="text-xs font-bold text-gray-900 truncate max-w-[150px]">filename.jpg</p>
                            <p id="fileSize" class="text-[10px] text-gray-500 font-medium">1.2 MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile()" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#2563EB] hover:bg-blue-700 text-white font-bold text-sm py-4 rounded-2xl shadow-lg shadow-blue-100 transition active:scale-[0.98]">
                        Upload Bukti
                    </button>
                    <a href="/civitas/upload-bukti" class="block w-full text-center text-gray-500 font-bold text-sm mt-4 hover:bg-gray-50 py-3 rounded-2xl transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>

        <!-- NOTES -->
        <div class="mt-8 bg-amber-50 border border-amber-100 p-5 rounded-3xl">
            <div class="flex items-center gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xs font-black text-amber-700 uppercase tracking-widest">Penting:</h3>
            </div>
            <ul class="text-[11px] text-amber-800 font-medium space-y-2 list-disc list-inside leading-relaxed opacity-80">
                <li>Upload foto bukti struk/kuitansi yang jelas</li>
                <li>Pastikan nominal sesuai dengan jumlah dana</li>
                <li>Bukti akan divalidasi oleh Bendahara</li>
            </ul>
        </div>

    </main>

    <script>
        function handleFileSelect(input) {
            const preview = document.getElementById('filePreview');
            const dropzone = document.getElementById('dropzone');
            const fileNameView = document.getElementById('fileName');
            const fileSizeView = document.getElementById('fileSize');
            const submitBtn = document.querySelector('button[type="submit"]');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                fileNameView.innerText = file.name;
                
                let size = file.size / 1024; // KB
                if (size > 1024) {
                    fileSizeView.innerText = (size / 1024).toFixed(1) + ' MB';
                } else {
                    fileSizeView.innerText = size.toFixed(0) + ' KB';
                }

                if (file.size > maxSize) {
                    fileSizeView.classList.add('text-rose-500');
                    fileSizeView.innerText += ' (Terlalu Besar! Maks 2MB)';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    fileSizeView.classList.remove('text-rose-500');
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }

                preview.classList.remove('hidden');
                dropzone.classList.add('hidden');
            }
        }

        function removeFile() {
            const input = document.getElementById('fileInput');
            const preview = document.getElementById('filePreview');
            const dropzone = document.getElementById('dropzone');

            input.value = '';
            preview.classList.add('hidden');
            dropzone.classList.remove('hidden');
        }

        // Basic Drag & Drop
        const dropBox = document.getElementById('dropzone');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropBox.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        dropBox.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('fileInput').files = files;
            handleFileSelect(document.getElementById('fileInput'));
        }, false);
    </script>
</body>
</html>
