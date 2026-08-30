@extends('layouts.orangtua')


@section('content')


<div class="min-h-screen bg-gray-50 p-5">


<div class="max-w-5xl mx-auto space-y-5">





{{-- HEADER --}}


<div class="bg-white border rounded-xl p-5">


<div class="flex justify-between items-center">


<div>


<h1 class="text-xl font-bold text-gray-800">

Riwayat Angket

</h1>


<p class="text-sm text-gray-500 mt-1">

Aktivitas harian
{{ $siswa->nama_siswa }}

</p>


</div>



<a href="{{ route('orangtua.dashboard') }}"

class="
text-sm
text-indigo-600
hover:underline
">

← Dashboard

</a>



</div>


</div>









{{-- STATISTIK --}}



<div class="grid md:grid-cols-3 gap-4">



<div class="bg-white border rounded-xl p-5">


<p class="text-xs text-gray-500">

Total Pengisian

</p>


<h2 class="
text-3xl
font-bold
text-indigo-600
mt-2
">

{{ $total }}

</h2>


</div>







<div class="bg-white border rounded-xl p-5">


<p class="text-xs text-gray-500">

Konsistensi Belajar

</p>


<h2 class="
text-3xl
font-bold
text-green-600
mt-2
">

{{ $persentaseBelajar }}%

</h2>


</div>







<div class="bg-white border rounded-xl p-5">


<p class="text-xs text-gray-500">

Siswa

</p>


<h2 class="
text-lg
font-bold
text-gray-800
mt-3
">

{{ $siswa->nama_siswa }}

</h2>


</div>



</div>









{{-- FILTER --}}


<div class="bg-white border rounded-xl p-5">


<form method="GET">


<div class="grid md:grid-cols-3 gap-4 items-end">



<div>


<label class="
text-sm
text-gray-600
">

Tanggal Mulai

</label>


<input

type="date"

name="tanggal_mulai"

value="{{ $tanggalMulai }}"

class="
w-full
mt-2
border
rounded-lg
px-3
py-2
">


</div>








<div>


<label class="
text-sm
text-gray-600
">

Tanggal Akhir

</label>


<input

type="date"

name="tanggal_akhir"

value="{{ $tanggalAkhir }}"

class="
w-full
mt-2
border
rounded-lg
px-3
py-2
">


</div>







<div>


<button

class="
w-full
bg-indigo-600
hover:bg-indigo-700
text-white
rounded-lg
py-2
font-semibold
text-sm
">

Tampilkan

</button>


</div>



</div>


</form>


</div>









{{-- RIWAYAT --}}



<div class="bg-white border rounded-xl p-5">


<h3 class="
font-bold
text-gray-800
mb-5
">

Aktivitas Harian

</h3>







@if($riwayat->count())



<div class="space-y-4">





@foreach($riwayat as $item)



@php


$jumlahSholat =

$item->sholat_subuh +

$item->sholat_dzuhur +

$item->sholat_ashar +

$item->sholat_magrib +

$item->sholat_isya;



@endphp





<div class="
border
rounded-xl
p-4
hover:shadow-sm
transition
">





<div class="flex justify-between items-start">


<div>


<h4 class="
font-semibold
text-gray-800
">

{{

\Carbon\Carbon::parse(
$item->tanggal
)
->format('d F Y')

}}

</h4>



<p class="
text-xs
text-gray-400
mt-1
">

Diisi:

{{

\Carbon\Carbon::parse(
$item->tanggal_pengisian
)
->format('d-m-Y H:i')

}}

</p>


</div>





@if(
\Carbon\Carbon::parse($item->tanggal)->format('Y-m-d')
==
\Carbon\Carbon::parse($item->tanggal_pengisian)->format('Y-m-d')
)



<span class="
text-xs
bg-green-100
text-green-700
px-3
py-1
rounded-full
font-semibold
">

Tepat Waktu

</span>


@else


<span class="
text-xs
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
font-semibold
">

Terlambat

</span>


@endif



</div>









<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">





<div class="
bg-gray-50
rounded-lg
p-3
">


<p class="text-xs text-gray-500">

Ibadah

</p>


<p class="font-bold">

{{ $jumlahSholat }}/5

</p>


</div>







<div class="
bg-gray-50
rounded-lg
p-3
">


<p class="text-xs text-gray-500">

Belajar

</p>


<p class="font-bold">

{{ $item->belajar ? 'Ya':'Tidak' }}

</p>


</div>







<div class="
bg-gray-50
rounded-lg
p-3
">


<p class="text-xs text-gray-500">

Bangun

</p>


<p class="font-bold">

{{ $item->bangun_pagi ?? '-' }}

</p>


</div>







<div class="
bg-gray-50
rounded-lg
p-3
">


<p class="text-xs text-gray-500">

Tidur

</p>


<p class="font-bold">

{{ $item->tidur_malam ?? '-' }}

</p>


</div>





</div>









@if($item->kegiatan_membantu)


<div class="mt-4">


<p class="
text-xs
text-gray-500
mb-1
">

Kegiatan Membantu

</p>


<div class="
bg-indigo-50
text-indigo-700
rounded-lg
p-3
text-sm
">


{{ $item->kegiatan_membantu }}


</div>


</div>


@endif







</div>






@endforeach




</div>






@else



<div class="
text-center
py-10
text-gray-500
">

Belum ada riwayat angket.

</div>



@endif



</div>








</div>


</div>



@endsection