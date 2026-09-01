@extends('admin.layouts.app')


@section('title','Monitoring Angket')


@section('page-title','Monitoring Angket Harian')



@section('content')


<div class="space-y-6">






{{-- HEADER --}}


<div class="bg-white rounded-2xl border shadow-sm p-6">


<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">


<div>


<h2 class="text-2xl font-bold text-gray-800">

Monitoring Angket Orang Tua

</h2>


<p class="text-gray-500 mt-1">

Pemantauan aktivitas dan kondisi harian siswa.

</p>


</div>





<div class="text-right">


<p class="text-xs text-gray-400">

Tanggal Monitoring

</p>


<p class="font-semibold text-gray-700">

{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}

</p>


</div>


</div>


</div>









{{-- FILTER --}}


<div class="bg-white border rounded-2xl shadow-sm p-6">


<form

method="GET"

action="{{ route('monitoring.angket') }}"

class="grid md:grid-cols-4 gap-5 items-end"

>


<div>


<label class="text-sm font-semibold text-gray-700">

Tanggal

</label>


<input

type="date"

name="tanggal"

value="{{ $tanggal }}"

class="w-full mt-2 border rounded-xl px-4 py-3"

>


</div>







<div>


<label class="text-sm font-semibold text-gray-700">

Kelas

</label>


<select

name="kelas_id"

class="w-full mt-2 border rounded-xl px-4 py-3"

>


<option value="">

Semua Kelas

</option>



@foreach($kelas as $item)


<option

value="{{ $item->id }}"

{{ $kelasId == $item->id ? 'selected':'' }}

>


{{ $item->nama_kelas }}


</option>


@endforeach


</select>


</div>








<div>


<label class="text-sm font-semibold text-gray-700">

Kategori

</label>



<select

name="kategori"

class="w-full mt-2 border rounded-xl px-4 py-3"

>


<option value="">

Semua Kondisi

</option>



<option value="Baik"

{{ $kategori=='Baik'?'selected':'' }}

>

Baik

</option>



<option value="Perlu Perhatian"

{{ $kategori=='Perlu Perhatian'?'selected':'' }}

>

Perlu Perhatian

</option>



<option value="Perlu Pendampingan"

{{ $kategori=='Perlu Pendampingan'?'selected':'' }}

>

Perlu Pendampingan

</option>


</select>


</div>







<div>


<button

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-6
py-3
rounded-xl
font-semibold
w-full
"

>

🔍 Tampilkan

</button>


</div>



</form>


</div>









{{-- STATISTIK --}}


<div class="grid md:grid-cols-4 gap-5">





<div class="bg-white border rounded-2xl p-5">

<p class="text-sm text-gray-500">

Total Siswa

</p>

<h3 class="text-3xl font-bold mt-2">

{{ $totalSiswa }}

</h3>

</div>







<div class="bg-green-50 border border-green-100 rounded-2xl p-5">

<p class="text-sm text-green-700">

Sudah Isi

</p>

<h3 class="text-3xl font-bold text-green-700 mt-2">

{{ $sudahIsi }}

</h3>

</div>







<div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5">

<p class="text-sm text-yellow-700">

Belum Isi

</p>

<h3 class="text-3xl font-bold text-yellow-700 mt-2">

{{ $belumIsi }}

</h3>

</div>







<div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-5">

<p class="text-sm text-indigo-700">

Persentase

</p>

<h3 class="text-3xl font-bold text-indigo-700 mt-2">

{{ $persentase }}%

</h3>

</div>



</div>









{{-- KATEGORI --}}


<div class="grid md:grid-cols-3 gap-5">



<div class="bg-green-50 border border-green-100 rounded-2xl p-5">

<p class="text-green-700 text-sm">

Kondisi Baik

</p>


<h3 class="text-3xl font-bold text-green-700 mt-2">

{{ $baik }}

</h3>

</div>






<div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5">


<p class="text-yellow-700 text-sm">

Perlu Perhatian

</p>


<h3 class="text-3xl font-bold text-yellow-700 mt-2">

{{ $perhatian }}

</h3>


</div>






<div class="bg-red-50 border border-red-100 rounded-2xl p-5">


<p class="text-red-700 text-sm">

Perlu Pendampingan

</p>


<h3 class="text-3xl font-bold text-red-700 mt-2">

{{ $pendampingan }}

</h3>


</div>



</div>









{{-- TABLE --}}


<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">


<div class="px-6 py-5 border-b">


<h3 class="font-bold text-gray-800">

Data Monitoring Siswa

</h3>


</div>








<div class="overflow-x-auto">


<table class="w-full">


<thead class="bg-gray-50">


<tr>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

No

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Siswa

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Kelas

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Orang Tua

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Skor

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Kategori

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Status

</th>


<th class="px-6 py-4 text-center text-xs uppercase text-gray-500">

Aksi

</th>


</tr>


</thead>








<tbody class="divide-y">



@forelse($siswas as $siswa)



@php

$angket = $siswa->angketHarian->first();

$wali = $siswa->orangTua->first();

@endphp





<tr class="hover:bg-gray-50 transition">





<td class="px-6 py-4">

{{ $siswas->firstItem()+$loop->index }}

</td>







<td class="px-6 py-4">


<p class="font-semibold text-gray-800">

{{ $siswa->nama_siswa }}

</p>


<p class="text-xs text-gray-500">

NIS : {{ $siswa->nis }}

</p>


</td>







<td class="px-6 py-4">

{{ $siswa->kelas->nama_kelas ?? '-' }}

</td>







<td class="px-6 py-4">

{{ $wali->nama_orang_tua ?? '-' }}

</td>







<td class="px-6 py-4 font-bold">

{{ $angket->skor ?? '-' }}

</td>







<td class="px-6 py-4">


@if($angket)


@if($angket->kategori == 'Baik')


<span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">

Baik

</span>


@elseif($angket->kategori == 'Perlu Perhatian')


<span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">

Perhatian

</span>


@else


<span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">

Pendampingan

</span>


@endif


@else

-

@endif


</td>







<td class="px-6 py-4">


@if($angket)


@if(
$angket->tanggal_pengisian &&
\Carbon\Carbon::parse($angket->tanggal)
->format('Y-m-d')
==
\Carbon\Carbon::parse($angket->tanggal_pengisian)
->format('Y-m-d')
)


<span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">

✓ Tepat Waktu

</span>


@else


<span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">

⚠ Telat Isi

</span>


@endif


@else


<span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">

Belum Isi

</span>


@endif


</td>








<td class="px-6 py-4 text-center">


<a

href="{{ route('monitoring.angket.detail',$siswa->id) }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-4
py-2
rounded-lg
text-xs
font-semibold
"

>

Detail

</a>


</td>





</tr>




@empty



<tr>


<td colspan="8"

class="text-center py-12 text-gray-500"

>


Belum ada data siswa.


</td>


</tr>



@endforelse



</tbody>



</table>


</div>







<div class="px-6 py-5 border-t">


{{ $siswas->links() }}


</div>



</div>






</div>


@endsection