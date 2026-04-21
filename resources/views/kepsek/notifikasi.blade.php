<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Notifikasi - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .noti-card { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .noti-card:hover { transform: translateX(8px); }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen pb-20">
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-4xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="/dashboard/kepsek" class="p-2 hover:bg-white/10 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="font-extrabold text-xl tracking-tight uppercase">Riwayat Notifikasi</h1>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 mt-10">
        <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h2 class="font-black text-gray-900 uppercase tracking-widest text-sm text-center">Semua Notifikasi</h2>
                <span class="text-[10px] bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold">Total {{ $notifications->count() }}</span>
            </div>

            <div class="divide-y divide-gray-50">
                @forelse($notifications as $notif)
                    <div class="p-8 noti-card flex gap-6 items-start {{ $notif->read_at ? 'opacity-60' : 'bg-blue-50/30' }}">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center {{ $notif->read_at ? 'bg-gray-100 text-gray-400' : 'bg-blue-600 text-white shadow-lg shadow-blue-100' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-1">
                            <div class="flex justify-between items-start">
                                <p class="text-sm font-bold text-gray-900 leading-relaxed">{{ $notif->data['message'] }}</p>
                                @if(!$notif->read_at)
                                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                @endif
                            </div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $notif->created_at->isoFormat('D MMMM Y, HH:mm') }} ({{ $notif->created_at->diffForHumans() }})</p>
                        </div>
                    </div>
                @empty
                    <div class="py-32 text-center space-y-4">
                        <div class="w-20 h-20 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <p class="text-gray-400 text-xs font-black uppercase tracking-widest">Belum ada riwayat notifikasi</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
