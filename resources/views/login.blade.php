<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col items-center justify-center
             bg-gradient-to-b from-blue-500 to-blue-800 text-white">

    <!-- ICON -->
    <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mb-4 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-8 w-8 text-blue-600"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M9 5l7 7-7 7" />
        </svg>
    </div>

    <!-- TITLE -->
    <div class="text-center mb-6">
        <h1 class="text-lg font-semibold">Sistem Informasi</h1>
        <p class="text-sm">Pengelolaan Keuangan Sekolah</p>
        <p class="text-xs opacity-80">BOS Management System</p>
    </div>

    <!-- LOGIN CARD -->
    <div class="bg-white text-gray-800 w-96 p-8 rounded-3xl shadow-2xl">

        <h2 class="text-center text-base font-semibold mb-6">
            Masuk ke Akun Anda
        </h2>

        @if(session('error'))
            <p class="text-red-500 text-sm mb-4 text-center">
                {{ session('error') }}
            </p>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm text-gray-600">Email / Username</label>
                <input type="email" name="email"
                    placeholder="Masukkan email"
                    class="w-full mt-1 px-4 py-2 rounded-xl border bg-gray-100
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="text-sm text-gray-600">Password</label>
                <input type="password" name="password"
                    placeholder="Masukkan password"
                    class="w-full mt-1 px-4 py-2 rounded-xl border bg-gray-100
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full py-2 rounded-xl text-white font-medium
                       bg-gradient-to-r from-blue-500 to-blue-700
                       hover:opacity-90 transition">
                Masuk
            </button>
        </form>

    </div>

    <!-- FOOTER -->
    <p class="mt-8 text-xs opacity-80">
        © 2024 BOS Management System
    </p>

</body>
</html>