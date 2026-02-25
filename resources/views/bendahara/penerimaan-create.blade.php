<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Input Dana Masuk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="bg-blue-700 text-white px-6 py-4 flex items-center shadow">
        <a href="/penerimaan" class="mr-4 text-xl">←</a>
        <h1 class="text-lg font-semibold">Input Dana Masuk</h1>
    </div>

    <div class="p-6 space-y-6">

        <!-- INFO CARD -->
        <div class="bg-blue-100 text-blue-700 p-4 rounded-xl text-sm">
            Input data penerimaan dana dari pemerintah atau sumber lain
        </div>

        <!-- FORM -->
        <form action="/penerimaan/store" method="POST" class="space-y-4">
            @csrf

            <!-- SUMBER DANA -->
            <div class="bg-white p-4 rounded-xl shadow">
                <label class="block text-sm text-gray-600 mb-1">
                    Sumber Dana
                </label>
                <input type="text" name="sumber_dana"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 outline-none"
                    placeholder="Contoh: BOS Reguler Triwulan 4" required>
            </div>

            <!-- JUMLAH DANA -->
            <div class="bg-white p-4 rounded-xl shadow">
                <label class="block text-sm text-gray-600 mb-1">
                    Jumlah Dana
                </label>
                <input type="number" name="jumlah"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-400 outline-none"
                    placeholder="Rp 0" required>
            </div>

            <!-- TANGGAL -->
            <div class="bg-white p-4 rounded-xl shadow">
                <label class="block text-sm text-gray-600 mb-1">
                    Tanggal Penerimaan
                </label>
                <input type="date" name="tanggal_penerimaan"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-purple-400 outline-none"
                    required>
            </div>

            <!-- KETERANGAN -->
            <div class="bg-white p-4 rounded-xl shadow">
                <label class="block text-sm text-gray-600 mb-1">
                    Keterangan (Opsional)
                </label>
                <textarea name="keterangan"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 outline-none"
                    placeholder="Tambahkan keterangan jika perlu"></textarea>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-3 rounded-xl shadow hover:bg-green-700 transition">
                + Simpan Penerimaan Dana
            </button>

            <a href="/penerimaan" class="block text-center text-gray-500 text-sm mt-2">
                Batal
            </a>

        </form>

    </div>

</body>

</html>