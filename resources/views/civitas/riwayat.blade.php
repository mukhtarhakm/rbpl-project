<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pengajuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
<div class="bg-blue-600 text-white px-6 py-4 flex items-center shadow">
    <a href="/dashboard/civitas" class="mr-4 text-xl">←</a>
    <h1 class="text-lg font-semibold">Riwayat Pengajuan</h1>
</div>

<div class="p-6 space-y-4">

    <!-- SEARCH -->
    <input type="text"
           placeholder="Cari pengajuan..."
           class="w-full border rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-400 outline-none">

    <!-- FILTER BUTTON -->
    <div class="flex gap-2 text-sm">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-full">Semua</button>
        <button class="px-4 py-2 bg-gray-200 rounded-full">Menunggu</button>
        <button class="px-4 py-2 bg-gray-200 rounded-full">Disetujui</button>
        <button class="px-4 py-2 bg-gray-200 rounded-full">Ditolak</button>
    </div>

    <!-- LIST -->
    @foreach($pengajuans as $pengajuan)

    <div class="bg-white p-4 rounded-2xl shadow hover:shadow-lg transition cursor-pointer">

        <div class="flex justify-between items-start">

            <div>
                <h2 class="font-semibold text-gray-800">
                    {{ $pengajuan->judul }}
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Rp {{ number_format($pengajuan->jumlah_dana) }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y') }}
                </p>
            </div>

            <!-- STATUS BADGE -->
            @if($pengajuan->status == 'menunggu')
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                    Menunggu
                </span>

            @elseif($pengajuan->status == 'disetujui')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                    Disetujui
                </span>

            @elseif($pengajuan->status == 'ditolak')
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                    Ditolak
                </span>

            @elseif($pengajuan->status == 'dicairkan')
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                    Dicairkan
                </span>

            @elseif($pengajuan->status == 'selesai')
                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs">
                    Selesai
                </span>
            @endif

        </div>
    </div>

    @endforeach

</div>

</body>
</html>