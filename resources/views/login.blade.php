<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BOS Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center
             bg-gradient-to-br from-blue-600 to-blue-800 text-white px-4">

    <!-- ICON ARROW -->
    <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center mb-6 shadow-xl border-4 border-white/20">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-10 w-10 text-blue-600"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
                  d="M17 8l4 4m0 0l-4 4m4-4H3" />
        </svg>
    </div>

    <!-- TITLE SECTION -->
    <div class="text-center mb-8">
        <p class="text-xs uppercase tracking-[0.2em] font-medium text-blue-100 mb-1 opacity-80 italic">Sistem Informasi</p>
        <h1 class="text-xl font-bold mb-1 leading-tight">Pengelolaan Keuangan Sekolah</h1>
        <p class="text-sm font-medium text-blue-100/90 tracking-wide">BOS Management System</p>
    </div>

    <!-- LOGIN CARD -->
    <div class="bg-white text-gray-800 w-full max-w-[400px] p-10 rounded-[2.5rem] shadow-2xl border-t border-white/20">
        
        <h2 class="text-center text-lg font-bold text-gray-800 mb-8 border-b border-gray-100 pb-4">
            Masuk ke Akun Anda
        </h2>

        @if(session('error'))
            <div class="bg-red-50 text-red-600 text-xs py-3 px-4 rounded-xl mb-6 font-medium text-center border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-6">
            @csrf

            <div>
                <label class="text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2 block ml-1">Email / Username</label>
                <input type="email" name="email"
                    placeholder="Masukkan email"
                    class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 bg-gray-50/50
                           text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 
                           focus:border-blue-500 transition-all duration-300">
            </div>

            <div class="relative">
                <label class="text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2 block ml-1">Password</label>
                <input type="password" name="password"
                    placeholder="Masukkan password"
                    class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 bg-gray-50/50
                           text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500/20 
                           focus:border-blue-500 transition-all duration-300">
            </div>

            <button type="submit"
                class="w-full py-4 rounded-2xl text-white text-sm font-bold shadow-lg shadow-blue-500/30
                       bg-blue-600 hover:bg-blue-700 active:scale-[0.98] transition-all duration-300">
                Masuk
            </button>
        </form>

    </div>

    <!-- FOOTER -->
    <div class="mt-12 text-center">
        <p class="text-xs font-semibold text-blue-100/60 tracking-wider">
            © 2024 BOS Management System
        </p>
    </div>

</body>
</html>
