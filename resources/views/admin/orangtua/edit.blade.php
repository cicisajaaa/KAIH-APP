@extends('admin.layouts.app')

@section('title', 'Edit Orang Tua')
@section('page-title', 'Edit Orang Tua')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100
                    flex flex-col sm:flex-row
                    sm:items-center sm:justify-between gap-4">

            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Edit Orang Tua
                </h2>

                <p class="text-gray-500 mt-1">
                    Perbarui data orang tua atau wali siswa.
                </p>
            </div>

            <a
                href="{{ route('orangtua.index') }}"
                class="inline-flex items-center justify-center
                       bg-gray-500 hover:bg-gray-600
                       text-white font-semibold
                       px-5 py-2.5
                       rounded-xl
                       transition"
            >
                ← Kembali
            </a>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('orangtua.update', $orangTua->id) }}"
            method="POST"
            class="p-6"
        >

            @csrf
            @method('PUT')


            {{-- Error --}}
            @if ($errors->any())

                <div class="mb-6 p-4
                            bg-red-50
                            border border-red-200
                            rounded-xl
                            text-red-700">

                    <p class="font-semibold mb-2">
                        Data belum dapat diperbarui.
                    </p>

                    <ul class="list-disc ml-5 text-sm">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Siswa --}}
            <div class="mb-5">

                <label
                    for="siswa_id"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Siswa
                </label>

                <select
                    id="siswa_id"
                    name="siswa_id"
                    required
                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           bg-white
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                    <option value="">
                        -- Pilih Siswa --
                    </option>

                    @foreach ($siswas as $siswa)

                        <option
                            value="{{ $siswa->id }}"
                            {{ old('siswa_id', $orangTua->siswa_id) == $siswa->id ? 'selected' : '' }}
                        >
                            {{ $siswa->nama_siswa }}
                            — NIS {{ $siswa->nis }}
                        </option>

                    @endforeach

                </select>

                @error('siswa_id')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Nama Orang Tua --}}
            <div class="mb-5">

                <label
                    for="nama_orang_tua"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Nama Orang Tua / Wali
                </label>

                <input
                    type="text"
                    id="nama_orang_tua"
                    name="nama_orang_tua"
                    value="{{ old('nama_orang_tua', $orangTua->nama_orang_tua) }}"
                    required
                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                @error('nama_orang_tua')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Hubungan --}}
            <div class="mb-5">

                <label
                    for="hubungan"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Hubungan
                </label>

                <select
                    id="hubungan"
                    name="hubungan"
                    required
                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           bg-white
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                    <option
                        value="Ayah"
                        {{ old('hubungan', $orangTua->hubungan) == 'Ayah' ? 'selected' : '' }}
                    >
                        Ayah
                    </option>

                    <option
                        value="Ibu"
                        {{ old('hubungan', $orangTua->hubungan) == 'Ibu' ? 'selected' : '' }}
                    >
                        Ibu
                    </option>

                    <option
                        value="Wali"
                        {{ old('hubungan', $orangTua->hubungan) == 'Wali' ? 'selected' : '' }}
                    >
                        Wali
                    </option>

                </select>

                @error('hubungan')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- No HP --}}
            <div class="mb-5">

                <label
                    for="no_hp"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    No. HP
                </label>

                <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    value="{{ old('no_hp', $orangTua->no_hp) }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                @error('no_hp')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Pekerjaan --}}
            <div class="mb-7">

                <label
                    for="pekerjaan"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Pekerjaan
                </label>

                <input
                    type="text"
                    id="pekerjaan"
                    name="pekerjaan"
                    value="{{ old('pekerjaan', $orangTua->pekerjaan) }}"
                    placeholder="Contoh: Wiraswasta"
                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                @error('pekerjaan')

                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Tombol --}}
            <div class="flex flex-col sm:flex-row gap-3">

                <a
                    href="{{ route('orangtua.index') }}"
                    class="flex-1
                           text-center
                           bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           font-semibold
                           py-3
                           rounded-xl
                           transition"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="flex-1
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           py-3
                           rounded-xl
                           shadow-sm
                           transition"
                >
                    💾 Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection