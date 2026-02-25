<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Penerimaan Dana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
<div class="bg-blue-700 text-white px-6 py-4 flex items-center shadow">
    <a href="/dashboard/bendahara" class="mr-4 text-xl">←</a>
    <h1 class="text-lg font-semibold">Penerimaan Dana</h1>
</div>

<div class="p-6 space-y-6">

    <!-- TOTAL PENERIMAAN -->
    <div class="bg-green-600 text-white p-6 rounded-2xl shadow-lg">
        <p class="text-sm opacity-80">Total Penerimaan</p>
        <h2 class="text-2xl font-semibold">
            Rp {{ number_format($totalPenerimaan ?? 0) }}
        </h2>
        <p class="text-sm opacity-80">
            Bulan {{ now()->translatedFormat('F Y') }}
        </p>
    </div>

    <!-- BUTTON INPUT -->
    <a href="/penerimaan/create"
       class="block bg-blue-600 text-white text-center py-3 rounded-xl shadow hover:bg-blue-700 transition">
        + Input Dana Masuk
    </a>

    <!-- RIWAYAT -->
    <div class="space-y-4">

        <h2 class="font-semibold text-gray-700">
            Riwayat Penerimaan
        </h2>

        @forelse($penerimaans as $item)
            <div class="bg-white p-4 rounded-2xl shadow flex justify-between items-center">

                <div class="flex items-center gap-4">
                    <div class="bg-green-100 w-12 h-12 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('icons/penerimaan.svg') }}"
                             class="w-6 h-6">
                    </div>

                    <div>
                        <p class="font-medium text-gray-700">
                            {{ $item->sumber_dana }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="text-green-600 font-semibold">
                    Rp {{ number_format($item->jumlah) }}
                </div>

            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Belum ada data penerimaan
            </div>
        @endforelse

    </div>

</div>

</body>
</html>