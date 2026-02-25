<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Persetujuan Pengeluaran</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- HEADER -->
    <div class="bg-blue-600 text-white px-6 py-4 flex items-center shadow">
        <a href="/dashboard/kepsek" class="mr-4 text-xl">←</a>
        <h1 class="text-lg font-semibold">Persetujuan Pengeluaran</h1>
    </div>

    <div class="p-6 space-y-6">

        <!-- TAB -->
        <div class="flex gap-3">
            <div class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm">
                Permintaan Dana ({{ $pengajuans->count() }})
            </div>
            <div class="bg-gray-200 text-gray-600 px-4 py-2 rounded-full text-sm">
                RKAS (0)
            </div>
        </div>

        <!-- LIST -->
        <div class="space-y-4">

            @foreach($pengajuans as $pengajuan)

                <div class="bg-white rounded-2xl shadow p-4 border-l-4 border-yellow-400">

                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $pengajuan->judul }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Pengaju: {{ $pengajuan->user->name ?? '-' }}
                            </p>
                            <p class="text-sm font-medium text-gray-700 mt-1">
                                Rp {{ number_format($pengajuan->jumlah_dana) }}
                            </p>
                        </div>

                        <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">
                            Menunggu
                        </span>
                    </div>

                    <div class="flex gap-3 mt-4">

                        <a href="/kepsek/persetujuan/{{ $pengajuan->id }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm">
                            Tinjau
                        </a>

                        <form action="/pengajuan/{{ $pengajuan->id }}/approve" method="POST">
                            @csrf
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                Setujui
                            </button>
                        </form>

                        <form action="/pengajuan/{{ $pengajuan->id }}/reject" method="POST">
                            @csrf
                            <input type="hidden" name="alasan_penolakan" value="Ditolak oleh Kepala Sekolah">
                            <button type="button" onclick="openModal({{ $pengajuan->id }})"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg">
                                Tolak
                            </button>
                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <!-- MODAL TOLAK -->
<div id="modalTolak"
     class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">

    <div class="bg-white w-96 rounded-2xl shadow-lg p-6">

        <h2 class="text-lg font-semibold mb-3">Alasan Penolakan</h2>

        <form id="formTolak" method="POST">
            @csrf

            <textarea name="alasan_penolakan"
                      class="w-full border rounded-lg p-2 mb-4"
                      placeholder="Masukkan alasan penolakan..."
                      required></textarea>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded-lg">
                    Batal
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg">
                    Tolak
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById('modalTolak');
    const form = document.getElementById('formTolak');

    form.action = `/pengajuan/${id}/reject`;
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalTolak')
            .classList.add('hidden');
}
</script>
</body>

</html>