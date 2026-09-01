@extends('layouts.orangtua')


@section('title','Riwayat Angket')


@section('page-title')

Riwayat Angket Harian

@endsection





@section('content')


<div class="space-y-6">






{{-- HEADER --}}


<div class="bg-white border rounded-xl p-6">


<div class="flex justify-between items-center">


<div>


<h2 class="text-xl font-semibold text-gray-800">

Aktivitas Harian Anak

</h2>


<p class="text-sm text-gray-500 mt-1">

Riwayat laporan aktivitas anak.

</p>


</div>




<a href="{{ route('orangtua.angket.create') }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-2.5
rounded-lg
text-sm
">

+ Isi Angket

</a>



</div>


</div>









{{-- LIST --}}



<div class="bg-white border rounded-xl p-6">


<h3 class="font-semibold text-gray-800 mb-6">

Riwayat Terbaru

</h3>





@if($angketHarian->count())



<div class="space-y-5">





@foreach($angketHarian as $item)



@php


$totalIbadah =

$item->sholat_subuh +

$item->sholat_dzuhur +

$item->sholat_ashar +

$item->sholat_magrib +

$item->sholat_isya;



$tanggalAktivitas =

\Carbon\Carbon::parse(
$item->tanggal
)->format('Y-m-d');



$tanggalIsi =

$item->tanggal_pengisian

?

\Carbon\Carbon::parse(
$item->tanggal_pengisian
)->format('Y-m-d')

:

null;



@endphp







<div class="
border
rounded-xl
p-5
hover:shadow-md
transition
">







<div class="
flex
justify-between
items-start
">





<div>


<p class="text-sm text-gray-500">

Tanggal Aktivitas

</p>


<h4 class="font-semibold text-gray-800">

{{

\Carbon\Carbon::parse(
$item->tanggal
)->format('d F Y')

}}

</h4>



<p class="text-xs text-gray-400 mt-2">


Diisi:


@if($item->tanggal_pengisian)

{{

\Carbon\Carbon::parse(
$item->tanggal_pengisian
)->format('d-m-Y H:i')

}}


@else

-

@endif


</p>


</div>








@if($tanggalAktivitas == $tanggalIsi)


<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-green-100
text-green-700
">

✓ Tepat Waktu

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

⚠ Telat Isi

</span>



@endif




</div>









{{-- RINGKASAN --}}


<div class="
grid
md:grid-cols-3
gap-4
mt-5
">





<div class="
bg-gray-50
rounded-lg
p-4
">


<p class="text-xs text-gray-500">

Ibadah

</p>


<p class="text-xl font-bold mt-2">

{{ $totalIbadah }}/5

</p>


</div>







<div class="
bg-gray-50
rounded-lg
p-4
">


<p class="text-xs text-gray-500">

Belajar

</p>


<p class="text-xl font-bold mt-2">


@if($item->belajar)

<span class="text-green-600">

Ya

</span>


@else


<span class="text-red-600">

Tidak

</span>


@endif


</p>


</div>








<div class="
bg-gray-50
rounded-lg
p-4
">


<p class="text-xs text-gray-500">

Tidur

</p>


<p class="text-xl font-bold mt-2">

{{ $item->tidur_malam ?? '-' }}

</p>


</div>





</div>









{{-- DETAIL IBADAH --}}


<div class="mt-5">


<p class="
text-sm
font-semibold
text-gray-700
mb-3
">

Detail Ibadah

</p>





<div class="flex flex-wrap gap-2">


@php


$ibadah = [

'Subuh'=>$item->sholat_subuh,

'Dzuhur'=>$item->sholat_dzuhur,

'Ashar'=>$item->sholat_ashar,

'Magrib'=>$item->sholat_magrib,

'Isya'=>$item->sholat_isya

];


@endphp





@foreach($ibadah as $nama=>$nilai)



@if($nilai)


<span class="
px-3
py-1
rounded-full
text-xs
bg-green-100
text-green-700
">

✓ {{ $nama }}

</span>



@else


@if($item->alasan_tidak_sholat)


<span class="
px-3
py-1
rounded-full
text-xs
bg-yellow-100
text-yellow-700
">

⚠ {{ $nama }}

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-gray-100
text-gray-500
">

✕ {{ $nama }}

</span>


@endif



@endif



@endforeach



</div>



</div>









{{-- ALASAN TIDAK SHOLAT --}}


@if($item->alasan_tidak_sholat)


<div class="mt-5">


<p class="
text-sm
font-semibold
text-gray-700
mb-2
">

Keterangan Ibadah

</p>



<div class="
bg-yellow-50
border
border-yellow-200
rounded-lg
p-4
">


<p class="
text-sm
font-semibold
text-yellow-700
">

⚠ Alasan Tidak Sholat

</p>



<p class="
text-sm
text-yellow-800
mt-1
">

{{ $item->alasan_tidak_sholat }}

</p>



</div>


</div>


@endif










{{-- KEGIATAN MEMBANTU --}}



@if($item->kegiatan_membantu)



<div class="mt-5">


<p class="text-sm text-gray-500">

Kegiatan Membantu

</p>


<div class="
mt-2
bg-gray-50
rounded-lg
p-3
text-gray-700
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



@endsection