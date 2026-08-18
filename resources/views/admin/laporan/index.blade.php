@extends('admin.layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')


<div class="space-y-6">


    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-gray-900">
                Laporan Sistem KAIH
            </h2>

            <p class="text-gray-500 mt-1">
                Rekap data siswa dan aktivitas angket harian.
            </p>
        </div>


        <a href="{{ route('laporan.export') }}"
           class="inline-flex items-center gap-2
                  bg-green-600
                  hover:bg-green-700
                  text-white
                  font-semibold
                  px-5 py-3
                  rounded-xl
                  transition">

            📤 Export Excel

        </a>

    </div>
{{-- FILTER TANGGAL ANGKET --}}

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">


    <form method="GET"
          action="{{ route('laporan.index') }}"
          class="flex flex-col md:flex-row gap-4 items-end">


        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Dari Tanggal
            </label>

            <input
                type="date"
                name="tanggal_mulai"
                value="{{ $tanggalMulai ?? '' }}"
                class="border border-gray-300 rounded-lg px-4 py-2"
            >

        </div>



        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Sampai Tanggal
            </label>

            <input
                type="date"
                name="tanggal_akhir"
                value="{{ $tanggalAkhir ?? '' }}"
                class="border border-gray-300 rounded-lg px-4 py-2"
            >

        </div>



        <button
            type="submit"
            class="bg-indigo-600
                   hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-5 py-2.5
                   rounded-lg">

            🔍 Filter

        </button>


        <a href="{{ route('laporan.index') }}"
           class="bg-gray-500
                  hover:bg-gray-600
                  text-white
                  font-semibold
                  px-5 py-2.5
                  rounded-lg">

            Reset

        </a>


    </form>


</div>


    {{-- LAPORAN SISWA --}}

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


        <div class="px-6 py-5 border-b">

            <h3 class="text-xl font-bold text-gray-800">
                Laporan Data Siswa
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Total {{ $siswas->count() }} siswa.
            </p>

        </div>



        <div class="overflow-x-auto">

            <table class="w-full">


                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm">
                            NIS
                        </th>

                        <th class="px-6 py-4 text-left text-sm">
                            Nama Siswa
                        </th>

                        <th class="px-6 py-4 text-left text-sm">
                            Kelas
                        </th>

                        <th class="px-6 py-4 text-left text-sm">
                            Jurusan
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse($siswas as $siswa)


                    <tr class="border-t hover:bg-gray-50">


                        <td class="px-6 py-4">
                            {{ $siswa->nis }}
                        </td>


                        <td class="px-6 py-4 font-semibold">
                            {{ $siswa->nama_siswa }}
                        </td>


                        <td class="px-6 py-4">
                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </td>


                        <td class="px-6 py-4">
                            {{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}
                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="4"
                            class="px-6 py-10 text-center text-gray-500">

                            Belum ada data siswa.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>

        </div>


    </div>




    {{-- LAPORAN ANGKET --}}


    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">


        <div class="px-6 py-5 border-b">

            <h3 class="text-xl font-bold text-gray-800">
                Laporan Angket Harian
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Rekap aktivitas harian siswa.
            </p>

        </div>



        <div class="overflow-x-auto">


            <table class="w-full">


                <thead class="bg-gray-50">

                    <tr>


                        <th class="px-6 py-4 text-left">
                            Tanggal
                        </th>


                        <th class="px-6 py-4 text-left">
                            Siswa
                        </th>


                        <th class="px-6 py-4 text-left">
                            Belajar
                        </th>


                        <th class="px-6 py-4 text-left">
                            Sholat Subuh
                        </th>


                    </tr>


                </thead>



                <tbody>


                @forelse($angketHarian as $angket)


                    <tr class="border-t hover:bg-gray-50">


                        <td class="px-6 py-4">
                            {{ $angket->tanggal }}
                        </td>


                        <td class="px-6 py-4 font-semibold">

                            {{ $angket->siswa->nama_siswa ?? '-' }}

                        </td>


                        <td class="px-6 py-4">

                            {{ $angket->belajar ? 'Ya' : 'Tidak' }}

                        </td>


                        <td class="px-6 py-4">

                            {{ $angket->sholat_subuh ? 'Ya' : 'Tidak' }}

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="4"
                            class="px-6 py-10 text-center text-gray-500">

                            Belum ada data angket harian.

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>


    </div>



</div>


@endsection