@extends('admin.layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-6">
    Tambah Kelas
</h2>

<div class="bg-white p-6 rounded-xl shadow">

    <form action="{{ route('kelas.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Nama Kelas
            </label>

            <input type="text"
                   name="nama_kelas"
                   class="w-full border rounded-lg px-4 py-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Jurusan
            </label>
            <select name="jurusan_id"
                    class="w-full border rounded-lg px-4 py-3">

                <option value="">-- Pilih Jurusan --</option>

                @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}">
                        {{ $jurusan->nama_jurusan }}
                    </option>
                @endforeach

            </select>
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
            Simpan
        </button>

    </form>

</div>

@endsection