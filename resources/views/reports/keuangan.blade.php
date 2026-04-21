<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-premium { border: 1px solid rgba(229, 231, 235, 0.5); }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/dashboard/kepsek" class="p-2 hover:bg-white/10 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="font-extrabold text-xl tracking-tight uppercase">Laporan Keuangan</h1>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 mt-10 space-y-10">
        <!-- FILTERS -->
        <section class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 flex flex-wrap items-end gap-6">
            <form action="/dashboard/kepsek/laporan" method="GET" class="flex flex-wrap items-end gap-6 w-full">
                <div class="flex-1 min-w-[200px]">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Pilih Bulan</label>
                    <select name="month" class="w-full border-none bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-2 block">Tahun Ajaran (RKAS)</label>
                    <select name="rkas_id" class="w-full border-none bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800">
                        <option value="">Semua RKAS</option>
                        @foreach($rkas_list as $r)
                            <option value="{{ $r->id }}" {{ request('rkas_id') == $r->id ? 'selected' : '' }}>
                                RKAS {{ $r->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition shadow-lg shadow-gray-200">
                        Filter
                    </button>
                    <a href="/dashboard/kepsek/laporan/download?{{ http_build_query(request()->all()) }}" 
                       class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-100 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export PDF
                    </a>
                </div>
            </form>
        </section>

        <!-- TABLE PREVIEW -->
        <section class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h2 class="font-black text-gray-900 uppercase tracking-widest text-sm">Preview Transaksi Realisasi</h2>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Total Pengeluaran</p>
                    <p class="text-xl font-black text-blue-600">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] uppercase font-black text-gray-400 tracking-tighter border-b border-gray-50">
                            <th class="px-8 py-6">Tanggal</th>
                            <th class="px-8 py-6">Judul Transaksi</th>
                            <th class="px-8 py-6">Kategori RKAS</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transaksi as $t)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-8 py-6">
                                    <p class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($t->tanggal_pencairan)->format('d M Y') }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs font-bold text-gray-900">{{ $t->judul }}</p>
                                    <p class="text-[10px] text-gray-400 font-medium">{{ Str::limit($t->deskripsi, 40) }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-blue-50 text-blue-600 text-[9px] font-black px-2 py-1 rounded uppercase">
                                        {{ $t->rkas->kegiatan_list[$t->kegiatan_idx]['name'] ?? 'Lainnya' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="bg-emerald-50 text-emerald-600 text-[9px] font-black px-2 py-1 rounded uppercase tracking-tighter">SUCCESS</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <p class="text-sm font-black text-gray-900">Rp {{ number_format($t->jumlah_dana, 0, ',', '.') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <p class="text-gray-400 text-xs font-black uppercase tracking-widest">Tidak ada data transaksi ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
