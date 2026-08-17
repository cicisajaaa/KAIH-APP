<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="min-h-screen bg-gray-100">

        <div class="bg-white shadow p-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">
                    Dashboard Orang Tua
                </h1>

                <p class="text-gray-600">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded"
                >
                    Logout
                </button>
            </form>
        </div>

        <div class="p-6">

            <div class="bg-white rounded-lg shadow p-6">

                <h2 class="text-xl font-bold mb-4">
                    Data Orang Tua
                </h2>

                <p>
                    <strong>Nama:</strong>
                    {{ $orangTua->nama_orang_tua }}
                </p>

                <p>
                    <strong>Hubungan:</strong>
                    {{ $orangTua->hubungan }}
                </p>

                <p>
                    <strong>No HP:</strong>
                    {{ $orangTua->no_hp ?? '-' }}
                </p>

                <p>
                    <strong>Pekerjaan:</strong>
                    {{ $orangTua->pekerjaan ?? '-' }}
                </p>

            </div>

            <div class="bg-white rounded-lg shadow p-6 mt-6">

                <h2 class="text-xl font-bold mb-4">
                    Data Siswa
                </h2>

                <p>
                    <strong>NIS:</strong>
                    {{ $orangTua->siswa->nis }}
                </p>

                <p>
                    <strong>Nama Siswa:</strong>
                    {{ $orangTua->siswa->nama_siswa }}
                </p>

            </div>

        </div>

    </div>

</body>
</html>