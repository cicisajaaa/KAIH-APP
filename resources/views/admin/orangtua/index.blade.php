@extends('admin.layouts.app')

@section('title', 'Data Orang Tua')
@section('page-title', 'Data Orang Tua')

@section('content')

<div>

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Data Orang Tua
            </h2>

            <p class="text-gray-500 mt-1">
                Kelola data orang tua dan wali siswa.
            </p>
        </div>

        <a
            href="{{ route('orangtua.create') }}"
            class="inline-flex items-center justify-center
                   bg-indigo-600
                   hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-5 py-3
                   rounded-lg
                   shadow
                   transition"
        >
            <span class="text-lg mr-2">+</span>
            Tambah Orang Tua
        </a>

    </div>


    {{-- ================= IMPORT EXCEL ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div>

                <h3 class="text-xl font-bold text-gray-800">
                    Import Data Orang Tua
                </h3>

                <p class="text-gray-500 mt-1">
                    Upload data orang tua melalui file Excel.
                </p>

            </div>


            <form
                action="{{ route('orangtua.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex flex-col sm:flex-row gap-3"
            >

                @csrf

                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls"
                    required

                    class="border border-gray-300
                           rounded-lg
                           px-3 py-2
                           bg-white
                           text-sm
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >


                <button
                    type="submit"
                    class="bg-green-600
                           hover:bg-green-700
                           text-white
                           font-semibold
                           px-5 py-2
                           rounded-lg
                           shadow
                           transition
                           whitespace-nowrap"
                >

                    📥 Import Excel

                </button>

            </form>

        </div>

    </div>


    {{-- ================= CARD DATA ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header Card --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                <div>

                    <h3 class="text-xl font-bold text-gray-800">
                        Daftar Orang Tua
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Total {{ $orangTuas->count() }} data orang tua.
                    </p>

                </div>

            </div>

        </div>


        {{-- ================= TABLE ================= --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nama Orang Tua
                        </th>

                        <th class="px-6 py-4 text-left">
                            Siswa
                        </th>

                        <th class="px-6 py-4 text-left">
                            Hubungan
                        </th>

                        <th class="px-6 py-4 text-left">
                            No HP
                        </th>

                        <th class="px-6 py-4 text-left">
                            Pekerjaan
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($orangTuas as $orangTua)

                        <tr class="border-t hover:bg-gray-50 transition">

                            {{-- No --}}
                            <td class="px-6 py-4">

                                {{ $loop->iteration }}

                            </td>


                            {{-- Nama Orang Tua --}}
                            <td class="px-6 py-4 font-semibold text-gray-800">

                                {{ $orangTua->nama_orang_tua }}

                            </td>


                            {{-- Siswa --}}
                            <td class="px-6 py-4">

                                {{ $orangTua->siswa?->nama_siswa ?? '-' }}

                            </td>


                            {{-- Hubungan --}}
                            <td class="px-6 py-4">

                                @if($orangTua->hubungan)

                                    <span
                                        class="inline-block
                                               px-3 py-1
                                               rounded-full
                                               text-xs
                                               font-semibold
                                               bg-indigo-100
                                               text-indigo-700"
                                    >

                                        {{ $orangTua->hubungan }}

                                    </span>

                                @else

                                    -

                                @endif

                            </td>


                            {{-- No HP --}}
                            <td class="px-6 py-4">

                                {{ $orangTua->no_hp ?? '-' }}

                            </td>


                            {{-- Pekerjaan --}}
                            <td class="px-6 py-4">

                                {{ $orangTua->pekerjaan ?? '-' }}

                            </td>


                            {{-- Aksi --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('orangtua.edit', $orangTua->id) }}"
                                        class="bg-yellow-500
                                               hover:bg-yellow-600
                                               text-white
                                               px-3 py-2
                                               rounded-lg
                                               text-sm
                                               font-semibold
                                               transition"
                                    >

                                        Edit

                                    </a>


                                    {{-- Hapus --}}
                                    <form
                                        action="{{ route('orangtua.destroy', $orangTua->id) }}"
                                        method="POST"

                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus data orang tua {{ $orangTua->nama_orang_tua }}?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-500
                                                   hover:bg-red-600
                                                   text-white
                                                   px-3 py-2
                                                   rounded-lg
                                                   text-sm
                                                   font-semibold
                                                   transition"
                                        >

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        {{-- Data kosong --}}
                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-10 text-center text-gray-500"
                            >

                                <div class="text-4xl mb-3">
                                    👨‍👩‍👧
                                </div>

                                <p class="font-semibold">
                                    Belum ada data orang tua.
                                </p>

                                <p class="text-sm mt-1">
                                    Silakan tambahkan data orang tua secara manual
                                    atau melalui import Excel.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection