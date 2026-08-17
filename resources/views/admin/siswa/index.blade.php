@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')

{{-- HEADER --}}

<div class="mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Data Siswa
            </h2>

            <p class="text-gray-500 mt-1">
                Kelola data siswa dan kelas.
            </p>

        </div>


        {{-- Tombol --}}
        <div class="flex flex-wrap gap-3">


            {{-- Export Excel --}}
            <a
                href="{{ route('siswa.export') }}"

                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       bg-green-600
                       hover:bg-green-700
                       text-white
                       font-semibold
                       px-5
                       py-3
                       rounded-xl
                       shadow-sm
                       hover:shadow-md
                       transition"
            >

                📤

                <span>
                    Export Excel
                </span>

            </a>


            {{-- Tambah Siswa --}}
            <a
                href="{{ route('siswa.create') }}"

                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       bg-indigo-600
                       hover:bg-indigo-700
                       text-white
                       font-semibold
                       px-5
                       py-3
                       rounded-xl
                       shadow-sm
                       hover:shadow-md
                       transition"
            >

                <span class="text-lg">
                    +
                </span>

                <span>
                    Tambah Siswa
                </span>

            </a>

        </div>

    </div>

</div>


{{-- =====================================================
    IMPORT EXCEL
====================================================== --}}

<div
    class="bg-white
           rounded-2xl
           shadow-sm
           border border-gray-100
           p-5
           mb-6"
>

    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">


        {{-- Informasi --}}
        <div>

            <h3 class="font-semibold text-gray-800">
                Import Data Siswa
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Import data siswa menggunakan file Excel.
            </p>

        </div>


        {{-- Form Import --}}
        <form
            action="{{ route('siswa.import') }}"
            method="POST"
            enctype="multipart/form-data"

            class="flex flex-col sm:flex-row gap-2"
        >

            @csrf


            <input
                type="file"
                name="file"
                accept=".xlsx,.xls"
                required

                class="w-full sm:w-auto
                       border border-gray-300
                       rounded-xl
                       px-3 py-2.5
                       text-sm
                       bg-white
                       focus:outline-none
                       focus:ring-2
                       focus:ring-indigo-500"
            >


            <button
                type="submit"

                class="inline-flex items-center justify-center
                       gap-2
                       bg-green-600
                       hover:bg-green-700
                       text-white
                       font-semibold
                       px-5 py-2.5
                       rounded-xl
                       transition
                       whitespace-nowrap"
            >

                📥

                <span>
                    Import Excel
                </span>

            </button>

        </form>

    </div>

</div>


{{-- =====================================================
    TABEL DATA SISWA
====================================================== --}}

<div
    class="bg-white
           rounded-2xl
           shadow-sm
           border border-gray-100
           overflow-hidden"
>


    {{-- Header Tabel --}}
    <div class="px-6 py-5 border-b border-gray-100">

        <h3 class="text-lg font-bold text-gray-800">
            Daftar Siswa
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Total {{ $siswas->count() }} siswa terdaftar.
        </p>

    </div>


    {{-- Table Responsive --}}
    <div class="overflow-x-auto">

        <table class="w-full">


            {{-- =================================================
                TABLE HEADER
            ================================================== --}}

            <thead class="bg-gray-50">

                <tr>

                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider
                               w-16"
                    >
                        No
                    </th>


                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        NIS
                    </th>


                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Nama Siswa
                    </th>


                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Jenis Kelamin
                    </th>


                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Kelas
                    </th>


                    <th
                        class="px-6 py-4
                               text-center
                               text-xs
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider
                               w-48"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>


            {{-- =================================================
                TABLE BODY
            ================================================== --}}

            <tbody class="divide-y divide-gray-100">


                @forelse($siswas as $siswa)

                    <tr
                        class="hover:bg-gray-50
                               transition"
                    >


                        {{-- No --}}
                        <td class="px-6 py-4">

                            <span class="text-sm text-gray-500">

                                {{ $loop->iteration }}

                            </span>

                        </td>


                        {{-- NIS --}}
                        <td class="px-6 py-4">

                            <span class="font-medium text-gray-700">

                                {{ $siswa->nis }}

                            </span>

                        </td>


                        {{-- Nama Siswa --}}
                        <td class="px-6 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $siswa->nama_siswa }}

                            </div>

                        </td>


                        {{-- Jenis Kelamin --}}
                        <td class="px-6 py-4">

                            @if($siswa->jenis_kelamin === 'L')

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1
                                           rounded-full
                                           text-xs
                                           font-semibold
                                           bg-blue-50
                                           text-blue-700"
                                >

                                    Laki-laki

                                </span>

                            @elseif($siswa->jenis_kelamin === 'P')

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1
                                           rounded-full
                                           text-xs
                                           font-semibold
                                           bg-pink-50
                                           text-pink-700"
                                >

                                    Perempuan

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1
                                           rounded-full
                                           text-xs
                                           font-semibold
                                           bg-gray-100
                                           text-gray-500"
                                >

                                    -

                                </span>

                            @endif

                        </td>


                        {{-- Kelas --}}
                        <td class="px-6 py-4">

                            @if($siswa->kelas)

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1
                                           rounded-full
                                           text-xs
                                           font-semibold
                                           bg-indigo-50
                                           text-indigo-700"
                                >

                                    {{ $siswa->kelas->nama_kelas }}

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1
                                           rounded-full
                                           text-xs
                                           font-semibold
                                           bg-gray-100
                                           text-gray-500"
                                >

                                    Tidak ada kelas

                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                            AKSI
                        ================================================== --}}

                        <td class="px-6 py-4">

                            <div
                                class="flex
                                       items-center
                                       justify-center
                                       gap-2"
                            >


                                {{-- Edit --}}
                                <a
                                    href="{{ route('siswa.edit', $siswa->id) }}"

                                    class="inline-flex
                                           items-center
                                           justify-center
                                           gap-1.5
                                           bg-yellow-500
                                           hover:bg-yellow-600
                                           text-white
                                           text-sm
                                           font-semibold
                                           px-3.5
                                           py-2
                                           rounded-lg
                                           transition"
                                >

                                    ✏️

                                    <span>
                                        Edit
                                    </span>

                                </a>


                                {{-- Hapus --}}
                                <form
                                    action="{{ route('siswa.destroy', $siswa->id) }}"
                                    method="POST"

                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus siswa {{ $siswa->nama_siswa }}?'
                                    );"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"

                                        class="inline-flex
                                               items-center
                                               justify-center
                                               gap-1.5
                                               bg-red-500
                                               hover:bg-red-600
                                               text-white
                                               text-sm
                                               font-semibold
                                               px-3.5
                                               py-2
                                               rounded-lg
                                               transition"
                                    >

                                        🗑️

                                        <span>
                                            Hapus
                                        </span>

                                    </button>

                                </form>


                            </div>

                        </td>


                    </tr>


                @empty


                    {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}

                    <tr>

                        <td
                            colspan="6"
                            class="px-6 py-14 text-center"
                        >

                            <div
                                class="flex
                                       flex-col
                                       items-center
                                       justify-center"
                            >


                                <div
                                    class="w-16 h-16
                                           bg-gray-100
                                           rounded-2xl
                                           flex
                                           items-center
                                           justify-center
                                           text-3xl
                                           mb-4"
                                >

                                    👨‍🎓

                                </div>


                                <h4 class="font-semibold text-gray-700">

                                    Belum ada data siswa

                                </h4>


                                <p class="text-sm text-gray-500 mt-1 mb-5">

                                    Silakan tambahkan data siswa terlebih dahulu.

                                </p>


                                <a
                                    href="{{ route('siswa.create') }}"

                                    class="inline-flex
                                           items-center
                                           gap-2
                                           bg-indigo-600
                                           hover:bg-indigo-700
                                           text-white
                                           font-semibold
                                           px-4 py-2.5
                                           rounded-xl
                                           transition"
                                >

                                    +

                                    Tambah Siswa

                                </a>

                            </div>

                        </td>

                    </tr>


                @endforelse


            </tbody>

        </table>

    </div>

</div>

@endsection