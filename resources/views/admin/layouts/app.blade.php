<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KAIH App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
       <aside class="fixed left-0 top-0 z-40
              w-64 h-screen
              bg-indigo-800 text-white
              overflow-y-auto">

            <div class="text-center text-2xl font-bold py-6 border-b border-indigo-700">
                🎓 KAIH App
            </div>

            <nav class="mt-5">

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🏠 Dashboard
                </a>

                <!-- Jurusan -->
                <a href="{{ route('jurusan.index') }}"
                   class="block px-6 py-3 hover:bg-indigo-700 transition">
                    🏫 Jurusan
                </a>

                <!-- Kelas -->
                <a href="{{ route('kelas.index') }}"
                   class="block px-6 py-3 hover:bg-indigo-700 transition">
                    📚 Kelas
                </a>

                <!-- Siswa -->
                <a href="{{ route('siswa.index') }}"
                   class="block px-6 py-3 hover:bg-indigo-700 transition">
                    👨‍🎓 Siswa
                </a>

                <!-- Orang Tua -->
                <a href="{{ route('orangtua.index') }}"
                    class="block px-6 py-3 hover:bg-indigo-700 transition">
                     👨‍👩‍👧 Orang Tua
                </a>

                <!-- Laporan -->
                <a href="#"
                   class="block px-6 py-3 hover:bg-indigo-700 transition">
                    📄 Laporan
                </a>

                <!-- Logout -->
                <form method="POST"
                      action="{{ route('logout') }}"
                      class="mt-10 px-6">

                    @csrf

                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg">
                        🚪 Logout
                    </button>

                </form>

            </nav>

        </aside>


        <!-- CONTENT -->
        <div class="flex-1 ml-64 min-h-screen">

            <!-- HEADER -->
            <header class="bg-white shadow px-8 py-5 flex justify-between items-center">

                <div>

                    <h1 class="text-2xl font-bold">
                        Dashboard Admin
                    </h1>

                    <p class="text-gray-500 text-sm">
                        Sistem Informasi Akademik KAIH
                    </p>

                </div>

                <div class="font-semibold">

                    @auth
                        👋 {{ Auth::user()->name }}
                    @else
                        👋 Admin
                    @endauth

                </div>

            </header>


            <!-- MAIN -->
            <main class="p-8">

                @if(session('success'))
                    <div class="mb-5 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>