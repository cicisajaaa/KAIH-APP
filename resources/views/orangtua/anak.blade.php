@extends('layouts.orangtua')


@section('title','Data Anak')


@section('content')


<div class="space-y-6">



<div class="bg-white rounded-2xl shadow-sm border p-6">


<div class="flex justify-between items-center mb-6">


<div>

<h2 class="text-2xl font-bold text-gray-800">
Data Anak
</h2>


<p class="text-gray-500">
Informasi siswa yang terhubung dengan akun orang tua.
</p>


</div>



<a href="{{ route('orangtua.dashboard') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

← Kembali

</a>


</div>





<div class="grid md:grid-cols-2 gap-6">


<div>


<p class="text-gray-500 text-sm">
NIS
</p>

<h3 class="font-bold text-lg">
{{ $orangTua->siswa->nis ?? '-' }}
</h3>


</div>





<div>


<p class="text-gray-500 text-sm">
Nama Siswa
</p>

<h3 class="font-bold text-lg">
{{ $orangTua->siswa->nama_siswa ?? '-' }}
</h3>


</div>






<div>


<p class="text-gray-500 text-sm">
Kelas
</p>

<h3 class="font-bold text-lg">
{{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
</h3>


</div>






<div>


<p class="text-gray-500 text-sm">
Jurusan
</p>

<h3 class="font-bold text-lg">
{{ $orangTua->siswa->kelas->jurusan->nama_jurusan ?? '-' }}
</h3>


</div>





</div>


</div>




</div>


@endsection