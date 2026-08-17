@extends('admin.layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

@section('content')

{{-- =====================================================
    HEADER
====================================================== --}}

<div class="mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-2xl font-bold text-gray-900">
                Data Kelas
            </h2>

            <p class="text-gray-500 mt-1">
                Kelola data kelas dan jurusan sekolah.
            </p>

        </div>


        {{-- Tombol Tambah --}}
        <a
            href="{{ route('kelas.create') }}"

            class="inline-flex items-center justify-center
                   gap-2
                   bg-indigo-600
                   hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-5 py-3
                   rounded-xl
                   shadow-sm
                   hover:shadow-md
                   transition"
        >

            <span class="text-lg">
                +
            </span>

            <span>
                Tambah Kelas
            </span>

        </a>

    </div>

</div>


{{-- =====================================================
    PESAN SUCCESS
====================================================== --}}

@if(session('success'))

    <div
        class="mb-6
               bg-green-50
               border border-green-200
               text-green-700
               px-5 py-4
               rounded-xl"
    >

        <div class="flex items-center gap-3">

            <span class="text-lg">
                ✓
            </span>

            <span>
                {{ session('success') }}
            </span>

        </div>

    </div>

@endif


{{-- =====================================================
    ERROR
====================================================== --}}

@if($errors->any())

    <div
        class="mb-6
               bg-red-50
               border border-red-200
               text-red-700
               px-5 py-4
               rounded-xl"
    >

        <p class="font-semibold mb-2">
            Terjadi kesalahan:
        </p>

        <ul class="list-disc ml-5 text-sm">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- =====================================================
    IMPORT & EXPORT
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


        {{-- Info --}}
        <div>

            <h3 class="font-semibold text-gray-800">
                Kelola Data Kelas
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Import data dari Excel atau export data kelas.
            </p>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">


            {{-- Import Excel --}}
            <form
                action="{{ route('kelas.import') }}"
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
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           font-semibold
                           px-4 py-2.5
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


            {{-- Export --}}
            <a
                href="{{ route('kelas.export') }}"

                class="inline-flex items-center justify-center
                       gap-2
                       bg-green-600
                       hover:bg-green-700
                       text-white
                       font-semibold
                       px-4 py-2.5
                       rounded-xl
                       transition
                       whitespace-nowrap"
            >

                📤

                <span>
                    Export Excel
                </span>

            </a>

        </div>

    </div>

</div>


{{-- =====================================================
    TABEL DATA KELAS
====================================================== --}}

<div
    class="bg-white
           rounded-2xl
           shadow-sm
           border border-gray-100
           overflow-hidden"
>


    {{-- Table Header --}}
    <div class="px-6 py-5 border-b border-gray-100">

        <h3 class="text-lg font-bold text-gray-800">
            Daftar Kelas
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Total {{ $kelas->count() }} kelas terdaftar.
        </p>

    </div>


    {{-- Responsive Table --}}
    <div class="overflow-x-auto">

        <table class="w-full">


            {{-- Header --}}
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
                               w-20"
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
                        Nama Kelas
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
                        Jurusan
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


            {{-- Body --}}
            <tbody class="divide-y divide-gray-100">


                @forelse($kelas as $item)

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


                        {{-- Nama Kelas --}}
                        <td class="px-6 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $item->nama_kelas }}

                            </div>

                        </td>


                        {{-- Jurusan --}}
                        <td class="px-6 py-4">

                            @if($item->jurusan)

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

                                    {{ $item->jurusan->nama_jurusan }}

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

                                    Tidak ada jurusan

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
                                    href="{{ route('kelas.edit', $item->id) }}"

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
                                    action="{{ route('kelas.destroy', $item->id) }}"
                                    method="POST"

                                    onsubmit="return confirm(
                                        'Yakin ingin menghapus kelas {{ $item->nama_kelas }}?'
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


                    {{-- Empty State --}}
                    <tr>

                        <td
                            colspan="4"
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

                                    📚

                                </div>


                                <h4 class="font-semibold text-gray-700">

                                    Belum ada data kelas

                                </h4>


                                <p class="text-sm text-gray-500 mt-1 mb-5">

                                    Silakan tambahkan data kelas terlebih dahulu.

                                </p>


                                <a
                                    href="{{ route('kelas.create') }}"

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

                                    Tambah Kelas

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