@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Edit Jurusan
        </h2>
        <p class="text-gray-500">
            Ubah data jurusan.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Kode Jurusan
                </label>

                <input
                    type="text"
                    name="kode_jurusan"
                    value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold">
                    Nama Jurusan
                </label>

                <input
                    type="text"
                    name="nama_jurusan"
                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="flex gap-3">

                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                    Simpan Perubahan
                </button>

                <a href="{{ route('jurusan.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection