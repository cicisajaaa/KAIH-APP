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

    <!-- Header -->
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
                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                Logout
            </button>

        </form>

    </div>


    <div class="p-6 space-y-6">


        <!-- Data Orang Tua -->
        <div class="bg-white rounded-lg shadow p-6">

            <h2 class="text-xl font-bold mb-4">
                Data Orang Tua
            </h2>


            <div class="space-y-2">

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

        </div>



        <!-- Data Siswa -->
        <div class="bg-white rounded-lg shadow p-6">


            <h2 class="text-xl font-bold mb-4">
                Data Siswa
            </h2>


            @if($orangTua->siswa)

                <div class="space-y-2">


                    <p>
                        <strong>NIS:</strong>
                        {{ $orangTua->siswa->nis }}
                    </p>


                    <p>
                        <strong>Nama Siswa:</strong>
                        {{ $orangTua->siswa->nama_siswa }}
                    </p>


                    <p>
                        <strong>Jenis Kelamin:</strong>
                        {{ $orangTua->siswa->jenis_kelamin }}
                    </p>


                    <p>
                        <strong>Kelas:</strong>
                        {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
                    </p>


                    <p>
                        <strong>Jurusan:</strong>
                        {{ $orangTua->siswa->kelas->jurusan->nama_jurusan ?? '-' }}
                    </p>


                </div>


            @else

                <p class="text-gray-500">
                    Data siswa belum tersedia.
                </p>

            @endif


        </div>



        <!-- Placeholder Angket -->
        <div class="bg-white rounded-lg shadow p-6">

    <h2 class="text-xl font-bold mb-4">
        Angket Harian
    </h2>


    @forelse($orangTua->angketHarian as $angket)

        <div class="border-b pb-4 mb-4">

            <p>
                <strong>Tanggal:</strong>
                {{ $angket->tanggal }}
            </p>

            <p>
                <strong>Bangun Pagi:</strong>
                {{ $angket->bangun_pagi ?? '-' }}
            </p>

            <p>
                <strong>Sholat Subuh:</strong>
                {{ $angket->sholat_subuh ? 'Ya' : 'Tidak' }}
            </p>

            <p>
                <strong>Belajar:</strong>
                {{ $angket->belajar ? 'Ya' : 'Tidak' }}
            </p>

            <p>
                <strong>Kegiatan Membantu:</strong>
                {{ $angket->kegiatan_membantu ?? '-' }}
            </p>

        </div>

    @empty

        <p class="text-gray-500">
            Belum ada data angket harian.
        </p>

    @endforelse

</div>


    </div>


</div>


</body>

</html>