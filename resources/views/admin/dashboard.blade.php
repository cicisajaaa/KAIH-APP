@extends('admin.layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-6">
    
</h2>

<div class="grid grid-cols-4 gap-6">

    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-gray-500">Total Jurusan</h3>
        <p class="text-4xl font-bold text-indigo-700 mt-2">
            {{ $totalJurusan }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-gray-500">Total Kelas</h3>
        <p class="text-4xl font-bold text-green-600 mt-2">
            {{ $totalKelas }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-gray-500">Total Siswa</h3>
        <p class="text-4xl font-bold text-blue-600 mt-2">
            {{ $totalSiswa }}
        </p>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-gray-500">Total Orang Tua</h3>
        <p class="text-4xl font-bold text-red-500 mt-2">
            {{ $totalOrangTua }}
        </p>
    </div>

</div>

<div class="bg-white shadow rounded-xl mt-8 p-6">

    <h3 class="text-xl font-bold mb-3">
        Selamat Datang 👋
    </h3>

    <p class="text-gray-600">
        Selamat datang di Sistem Informasi Akademik KAIH.
        Gunakan menu di sebelah kiri untuk mengelola data Jurusan,
        Kelas, Siswa, Orang Tua, dan Laporan.
    </p>

</div>

@endsection