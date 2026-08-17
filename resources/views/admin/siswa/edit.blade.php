@extends('admin.layouts.app')

@section('content')

<div class="bg-white rounded-2xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold">
                Edit Siswa
            </h2>

            <p class="text-gray-500">
                Ubah data siswa.
            </p>
        </div>

        <a href="{{ route('siswa.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

            Kembali

        </a>

    </div>


    {{-- Error --}}
    @if($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('siswa.update', $siswa->id) }}"
          method="POST">

        @csrf
        @method('PUT')


        {{-- NIS --}}
        <div class="mb-4">

            <label class="block font-semibold mb-2">
                NIS
            </label>

            <input
                type="text"
                name="nis"
                value="{{ old('nis', $siswa->nis) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required
            >

        </div>


        {{-- Nama --}}
        <div class="mb-4">

            <label class="block font-semibold mb-2">
                Nama Siswa
            </label>

            <input
                type="text"
                name="nama_siswa"
                value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required
            >

        </div>


        {{-- Jenis Kelamin --}}
        <div class="mb-4">

            <label class="block font-semibold mb-2">
                Jenis Kelamin
            </label>

            <select
                name="jenis_kelamin"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required>

                <option value="L"
                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>

                    Laki-laki

                </option>

                <option value="P"
                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>

                    Perempuan

                </option>

            </select>

        </div>


        {{-- Kelas --}}
        <div class="mb-6">

            <label class="block font-semibold mb-2">
                Kelas
            </label>

            <select
                name="kelas_id"
                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                required>

                @foreach($kelas as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ old('kelas_id', $siswa->kelas_id) == $item->id ? 'selected' : '' }}>

                        {{ $item->nama_kelas }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Tombol --}}
        <div class="flex gap-3">

            <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">

                Simpan Perubahan

            </button>

            <a href="{{ route('siswa.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection