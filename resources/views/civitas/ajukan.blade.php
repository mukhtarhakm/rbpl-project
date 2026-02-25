<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajukan Dana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-xl mx-auto py-8 px-6 space-y-6">

    <!-- HEADER -->
    <div class="bg-blue-600 text-white px-6 py-4 rounded-xl shadow flex items-center gap-3">
        <a href="{{ url('/dashboard/civitas') }}" class="text-white text-xl">←</a>
        <h1 class="font-semibold text-lg">Ajukan Dana</h1>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl shadow-md p-6 space-y-5">

        <div class="bg-blue-50 text-blue-700 text-sm p-3 rounded-lg">
            Isi formulir dengan lengkap untuk mengajukan dana dari anggaran BOS
        </div>

        <form action="{{ url('/pengajuan/store') }}" method="POST">
            @csrf

            <!-- Judul -->
            <div>
                <label class="text-sm font-medium text-gray-600">
                    Judul Pengajuan
                </label>
                <input type="text"
                       name="judul"
                       class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Contoh: Pembelian ATK Kelas"
                       required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="text-sm font-medium text-gray-600">
                    Deskripsi Kebutuhan
                </label>
                <textarea name="deskripsi"
                          rows="4"
                          class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                          placeholder="Jelaskan kebutuhan dan alasan pengajuan dana..."
                          required></textarea>
            </div>

            <!-- Jumlah Dana -->
            <div>
                <label class="text-sm font-medium text-gray-600">
                    Jumlah Dana
                </label>
                <input type="number"
                       name="jumlah_dana"
                       class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Rp 0"
                       required>
            </div>

            <!-- Tanggal -->
            <div>
                <label class="text-sm font-medium text-gray-600">
                    Tanggal Dibutuhkan
                </label>
                <input type="date"
                       name="tanggal_dibutuhkan"
                       class="w-full mt-1 p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                       required>
            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl shadow hover:bg-blue-700 transition mt-4">
                Kirim Pengajuan
            </button>

        </form>

        <!-- Catatan -->
        <div class="text-sm text-gray-500 border-t pt-3">
            <strong>Catatan:</strong><br>
            Pengajuan akan ditinjau oleh Kepala Sekolah.<br>
            Pastikan data yang diisi lengkap dan akurat.
        </div>

    </div>

</div>

</body>
</html>