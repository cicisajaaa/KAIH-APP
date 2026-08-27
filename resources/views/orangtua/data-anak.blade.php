@extends('layouts.orangtua')


@section('title','Data Anak')


@section('page-title')

Data Anak

@endsection




@section('content')


<div class="space-y-6">





{{-- PROFIL SISWA --}}


<div class="bg-white border rounded-xl p-6">



<div class="flex items-center gap-5">


<div class="
w-20
h-20
rounded-full
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
text-3xl
font-bold
">


{{ strtoupper(substr(
$orangTua->siswa->nama_siswa ?? 'S',
0,
1
)) }}


</div>





<div>


<h2 class="text-xl font-semibold text-gray-800">

{{ $orangTua->siswa->nama_siswa ?? '-' }}

</h2>



<p class="text-sm text-gray-500 mt-1">

Informasi data siswa

</p>



</div>



</div>



</div>









{{-- INFORMASI SISWA --}}


<div class="bg-white border rounded-xl p-6">



<h3 class="font-semibold text-gray-800 mb-5">

Biodata Siswa

</h3>




<div class="grid md:grid-cols-3 gap-6">





<div>

<p class="text-xs text-gray-400">

NIS

</p>


<p class="font-medium mt-1">

{{ $orangTua->siswa->nis ?? '-' }}

</p>


</div>






<div>

<p class="text-xs text-gray-400">

Nama Lengkap

</p>


<p class="font-medium mt-1">

{{ $orangTua->siswa->nama_siswa ?? '-' }}

</p>


</div>






<div>

<p class="text-xs text-gray-400">

Jenis Kelamin

</p>


<p class="font-medium mt-1">

{{ 
$orangTua->siswa->jenis_kelamin == 'L'
?
'Laki-laki'
:
'Perempuan'
}}

</p>


</div>








<div>

<p class="text-xs text-gray-400">

Kelas

</p>


<p class="font-medium mt-1">

{{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}

</p>


</div>








<div>

<p class="text-xs text-gray-400">

Jurusan

</p>


<p class="font-medium mt-1">

{{ $orangTua->siswa->kelas->jurusan->nama_jurusan ?? '-' }}

</p>


</div>






<div>

<p class="text-xs text-gray-400">

Tahun Data

</p>


<p class="font-medium mt-1">

{{ 
$orangTua->siswa->created_at
?
$orangTua->siswa->created_at->format('Y')
:
'-'
}}

</p>


</div>





</div>



</div>









{{-- DATA ORANG TUA --}}


<div class="bg-white border rounded-xl p-6">



<h3 class="font-semibold text-gray-800 mb-5">

Data Orang Tua

</h3>




<div class="grid md:grid-cols-3 gap-6">





<div>

<p class="text-xs text-gray-400">

Nama Orang Tua

</p>


<p class="font-medium mt-1">

{{ $orangTua->nama_orang_tua ?? '-' }}

</p>


</div>







<div>

<p class="text-xs text-gray-400">

Hubungan

</p>


<p class="font-medium mt-1">

{{ $orangTua->hubungan ?? '-' }}

</p>


</div>








<div>

<p class="text-xs text-gray-400">

Pekerjaan

</p>


<p class="font-medium mt-1">

{{ $orangTua->pekerjaan ?? '-' }}

</p>


</div>





</div>


</div>









{{-- RINGKASAN AKTIVITAS --}}



<div class="bg-white border rounded-xl p-6">



<h3 class="font-semibold text-gray-800 mb-5">

Ringkasan Aktivitas

</h3>




@php


$totalAngket = $orangTua
->angketHarian()
->count();



$totalBelajar = $orangTua
->angketHarian()
->where('belajar',1)
->count();



$totalIbadah = $orangTua
->angketHarian()
->get()
->sum(function($item){


return 
$item->sholat_subuh +
$item->sholat_dzuhur +
$item->sholat_ashar +
$item->sholat_magrib +
$item->sholat_isya;


});



$rataIbadah = $totalAngket > 0

?

round(
($totalIbadah /
($totalAngket*5))
*100
)

:

0;



$rataBelajar = $totalAngket > 0

?

round(
($totalBelajar /
$totalAngket)
*100
)

:

0;



@endphp







<div class="grid md:grid-cols-3 gap-5">





<div class="border rounded-lg p-5">


<p class="text-sm text-gray-500">

Total Pengisian Angket

</p>


<h3 class="text-3xl font-semibold mt-2">

{{ $totalAngket }}

</h3>


<p class="text-xs text-gray-400">

Riwayat aktivitas

</p>


</div>









<div class="border rounded-lg p-5">


<p class="text-sm text-gray-500">

Kedisiplinan Belajar

</p>


<h3 class="text-3xl font-semibold mt-2">

{{ $rataBelajar }}%

</h3>


<p class="text-xs text-gray-400">

Berdasarkan pengisian angket

</p>


</div>









<div class="border rounded-lg p-5">


<p class="text-sm text-gray-500">

Konsistensi Ibadah

</p>


<h3 class="text-3xl font-semibold mt-2">

{{ $rataIbadah }}%

</h3>


<p class="text-xs text-gray-400">

Berdasarkan sholat wajib

</p>


</div>





</div>



</div>









</div>


@endsection