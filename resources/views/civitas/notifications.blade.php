<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - BOS Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-premium { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .card-premium:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-10">

    <!-- HEADER -->
    <header class="bg-[#2563EB] text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="/dashboard/civitas" class="p-2 bg-white/10 rounded-full hover:bg-white/20 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l-7-7m7 7h18" />
                    </svg>
                </a>
                <h1 class="font-extrabold text-xl tracking-tight">Notifikasi</h1>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Logout -->
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-2.5 bg-white/10 rounded-full hover:bg-rose-500 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-6 mt-10 space-y-6">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-gray-900 font-black text-lg tracking-tight uppercase px-2 bg-blue-100 w-fit rounded-md text-[10px] py-1">Semua Notifikasi</h2>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $notifications->count() }} Notifikasi</p>
        </div>

        <div class="space-y-4">
            @forelse($notifications as $noti)
                <div class="bg-white p-6 rounded-[2rem] shadow-sm card-premium flex items-start gap-5 @if(!$noti->read_at) border-l-4 border-blue-600 @endif">
                    <div class="p-3 rounded-2xl @if($noti->data['status'] == 'ditolak') bg-rose-100 text-rose-600 @else bg-blue-100 text-blue-600 @endif">
                        @if($noti->data['status'] == 'ditolak')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 space-y-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-gray-900 text-sm italic">"{{ $noti->data['judul'] }}"</h3>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $noti->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $noti->data['message'] }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                    <p class="text-gray-400 text-sm font-black uppercase tracking-widest">Belum ada notifikasi ✨</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>
