@extends('admin.layouts.app')

@section('content')


<div class="flex items-center justify-between mb-6">

    <div>
        <h2 class="text-3xl font-bold text-gray-800">
            Data Jurusan
        </h2>
        <p class="text-gray-500 mt-1">
            Kelola data jurusan sekolah.
        </p>
    </div>

    <a href="{{ route('jurusan.create') }}"
   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
    + Tambah Jurusan
    </a>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-4 text-left font-semibold">
                    No
                </th>

                <th class="px-6 py-4 text-left font-semibold">
                    Kode Jurusan
                </th>

                <th class="px-6 py-4 text-left font-semibold">
                    Nama Jurusan
                </th>

                <th class="px-6 py-4 text-center font-semibold">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($jurusans as $jurusan)

            <tr class="border-t hover:bg-gray-50">

                <td class="px-6 py-4">
                    {{ $loop->iteration }}
                </td>

                <td class="px-6 py-4">
                    {{ $jurusan->kode_jurusan }}
                </td>

                <td class="px-6 py-4">
                    {{ $jurusan->nama_jurusan }}
                </td>

                <td class="px-6 py-4 text-center">

                    <a href="{{ route('jurusan.edit', $jurusan->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg">
                        Edit
                    </a>

                    <form action="{{ route('jurusan.destroy', $jurusan->id) }}"
                         method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                    <button
                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg ml-2">
                    Hapus
                </button>
            </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="4" class="py-12 text-center text-gray-500">

                    Belum ada data jurusan.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection