@extends('admin.layouts.app')

@section('content')

<div class="max-w-2xl">
    <h2 class="text-3xl font-bold text-gray-800">
        Edit Kelas
    </h2>
    <p class="text-gray-500 mb-6">
        Ubah data kelas.
    </p>

    <div class="bg-white rounded-xl shadow p-6">

        <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 font-medium">
                    Nama Kelas
                </label>

                <input type="text"
                    name="nama_kelas"
                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200">
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-medium">
                    Jurusan
                </label>

                <select name="jurusan_id"
                    class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-indigo-200">

                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}"
                            {{ $kelas->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="flex gap-3">

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
                    Update
                </button>

                <a href="{{ route('kelas.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                    Batal
                </a>

            </div>

        </form>

    </div>
</div>

@endsection