@extends('admin.layouts.app')


@section('title','Monitoring Angket')


@section('page-title','Monitoring Angket Harian')



@section('content')


<div class="space-y-6">





{{-- HEADER --}}


<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">


<div class="flex justify-between items-center">


<div>


<h2 class="text-2xl font-bold text-gray-800">

Monitoring Angket Orang Tua

</h2>


<p class="text-gray-500 mt-1">

Pemantauan pengisian aktivitas harian siswa.

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


<form method="GET"

action="{{ route('monitoring.angket') }}"

class="grid md:grid-cols-3 gap-5 items-end">





<div>


<label class="text-sm font-semibold text-gray-700">

Tanggal

</label>


<input

type="date"

name="tanggal"

value="{{ $tanggal }}"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
">


</div>







<div>


<label class="text-sm font-semibold text-gray-700">

Kelas

</label>



<select

name="kelas_id"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
">


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
">


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


<h3 class="text-3xl font-bold text-gray-800 mt-2">

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









{{-- TABEL --}}


<div class="bg-white border rounded-2xl shadow-sm overflow-hidden">



<div class="px-6 py-5 border-b">


<h3 class="font-bold text-gray-800">

Status Pengisian Siswa

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

Status

</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Aksi

</th>


</tr>


</thead>







<tbody class="divide-y">



@foreach($siswas as $siswa)



@php


$sudahMengisi = $siswa

    ->angketHarian()

    ->whereDate(

        'tanggal',

        $tanggal

    )

    ->exists();



$wali = $siswa

    ->orangTua

    ->first();



@endphp





<tr class="hover:bg-gray-50">



<td class="px-6 py-4">

{{ $loop->iteration }}

</td>





<td class="px-6 py-4">


<div class="font-semibold text-gray-800">

{{ $siswa->nama_siswa }}

</div>


<div class="text-sm text-gray-500">

NIS: {{ $siswa->nis }}

</div>


</td>







<td class="px-6 py-4">


@if($siswa->kelas)


<span class="
px-3
py-1
rounded-full
text-xs
bg-indigo-50
text-indigo-700
">


{{ $siswa->kelas->nama_kelas }}


</span>


@else

-

@endif


</td>







<td class="px-6 py-4">


@if($wali)


<p class="font-medium">

{{ $wali->nama_orang_tua }}

</p>


<p class="text-xs text-gray-500">

{{ $wali->hubungan }}

</p>


@else

-

@endif


</td>



<td class="px-6 py-4">


@if($sudahMengisi)


<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-green-100
text-green-700
">

✓ Sudah Isi

</span>



@else



<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-yellow-100
text-yellow-700
">

⚠ Belum Isi

</span>



@endif



</td>


<td class="px-6 py-4">


<a href="{{ route(
    'monitoring.angket.detail',
    $siswa->id
) }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-4
py-2
rounded-lg
text-xs
">

Detail

</a>


</td>





</tr>


@endforeach






</tbody>



</table>


</div>



</div>






</div>



@endsection