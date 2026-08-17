@extends('admin.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">

        <h2 class="text-3xl font-bold text-gray-800">
            Tambah Orang Tua
        </h2>

        <p class="text-gray-500 mt-1">
            Tambahkan data orang tua atau wali siswa.
        </p>

    </div>


    {{-- Error Validasi --}}
    @if($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700
                    px-5 py-4 rounded-xl mb-6">

            <p class="font-semibold mb-2">
                Data belum dapat disimpan.
            </p>

            <ul class="list-disc ml-5 text-sm">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        <form
            action="{{ route('orangtua.store') }}"
            method="POST"
        >

            @csrf


            {{-- Siswa --}}
            <div class="mb-6">

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

                    @foreach($siswas as $siswa)

                        <option
                            value="{{ $siswa->id }}"
                            {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}
                        >

                            {{ $siswa->nis }}
                            -
                            {{ $siswa->nama_siswa }}
                            -
                            {{ $siswa->kelas?->nama_kelas ?? 'Tanpa Kelas' }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Nama Orang Tua --}}
            <div class="mb-6">

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

                    value="{{ old('nama_orang_tua') }}"

                    required
                    placeholder="Masukkan nama orang tua / wali"

                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

            </div>


            {{-- Hubungan --}}
            <div class="mb-6">

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

                    <option value="">
                        -- Pilih Hubungan --
                    </option>

                    <option
                        value="Ayah"
                        {{ old('hubungan') == 'Ayah' ? 'selected' : '' }}
                    >
                        Ayah
                    </option>

                    <option
                        value="Ibu"
                        {{ old('hubungan') == 'Ibu' ? 'selected' : '' }}
                    >
                        Ibu
                    </option>

                    <option
                        value="Wali"
                        {{ old('hubungan') == 'Wali' ? 'selected' : '' }}
                    >
                        Wali
                    </option>

                </select>

            </div>


            {{-- No HP --}}
            <div class="mb-6">

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

                    value="{{ old('no_hp') }}"

                    placeholder="Contoh: 081234567890"

                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

            </div>


            {{-- Pekerjaan --}}
            <div class="mb-8">

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

                    value="{{ old('pekerjaan') }}"

                    placeholder="Contoh: Wiraswasta"

                    class="w-full px-4 py-3
                           border border-gray-300
                           rounded-xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

            </div>


            {{-- Tombol --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('orangtua.index') }}"

                    class="px-5 py-3
                           bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           font-semibold
                           rounded-xl
                           transition"
                >
                    Batal
                </a>


                <button
                    type="submit"

                    class="px-6 py-3
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           rounded-xl
                           shadow-sm
                           transition"
                >
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>

@endsection