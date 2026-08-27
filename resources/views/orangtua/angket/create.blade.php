@extends('layouts.orangtua')


@section('title','Isi Angket')



@section('content')


<div class="space-y-6">





{{-- HEADER --}}

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">


<div class="flex justify-between items-center">


<div>

<h2 class="text-2xl font-bold text-gray-800">

Isi Angket Harian

</h2>


<p class="text-gray-500 mt-1">

Catat aktivitas harian anak.

</p>


</div>




<a href="{{ route('orangtua.angket.index') }}"

class="
bg-gray-500
hover:bg-gray-600
text-white
px-5
py-3
rounded-xl
">

← Kembali

</a>



</div>


</div>









{{-- FORM --}}


<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">



<form

action="{{ route('orangtua.angket.store') }}"

method="POST"

>


@csrf





@if($errors->any())


<div class="
bg-red-50
border
border-red-200
text-red-700
rounded-xl
p-4
mb-5
">


<ul class="list-disc ml-5">


@foreach($errors->all() as $error)


<li>

{{ $error }}

</li>


@endforeach


</ul>


</div>


@endif







@php

$tanggalInput = old('tanggal',$tanggalHariIni);


$statusTelat =
$tanggalInput != $tanggalHariIni;

@endphp







@if($statusTelat)


<div class="
bg-yellow-50
border
border-yellow-200
text-yellow-700
p-4
rounded-xl
mb-5
">


⚠️ Mengisi aktivitas tanggal:

<b>

{{ $tanggalInput }}

</b>


<br>


Data akan tercatat sebagai:

<b>

Telat Isi

</b>


</div>



@else


<div class="
bg-blue-50
border
border-blue-200
text-blue-700
p-4
rounded-xl
mb-5
">


ℹ️ Angket dapat diisi untuk hari ini atau maksimal 1 hari sebelumnya.


</div>



@endif







<div class="grid md:grid-cols-2 gap-5">






<div>


<label class="font-semibold">

Tanggal Aktivitas

</label>



<input

type="date"

name="tanggal"

value="{{ $tanggalInput }}"

max="{{ $tanggalHariIni }}"

min="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}"

class="
w-full
border
rounded-xl
px-4
py-3
mt-2
"


>


</div>








<div>


<label class="font-semibold">

Bangun Pagi

</label>



<input

type="time"

name="bangun_pagi"

value="{{ old('bangun_pagi') }}"

class="
w-full
border
rounded-xl
px-4
py-3
mt-2
"

>


</div>



</div>









{{-- SHOLAT + BELAJAR --}}


<div class="grid md:grid-cols-2 gap-5 mt-5">



@php

$fields = [

'sholat_subuh'=>'Sholat Subuh',

'sholat_dzuhur'=>'Sholat Dzuhur',

'sholat_ashar'=>'Sholat Ashar',

'sholat_magrib'=>'Sholat Magrib',

'sholat_isya'=>'Sholat Isya',

'belajar'=>'Belajar'

];

@endphp







@foreach($fields as $key=>$label)



<div>


<label class="font-semibold">

{{ $label }}

</label>



<select

name="{{ $key }}"

class="
w-full
border
rounded-xl
px-4
py-3
mt-2
"


>


<option value="1"

{{ old($key)=='1' ? 'selected':'' }}

>

Ya

</option>



<option value="0"

{{ old($key)=='0' ? 'selected':'' }}

>

Tidak

</option>



</select>


</div>




@endforeach




</div>









{{-- KEGIATAN --}}


<div class="mt-5">


<label class="font-semibold">

Kegiatan Membantu

</label>



<textarea

name="kegiatan_membantu"

rows="3"

class="
w-full
border
rounded-xl
px-4
py-3
mt-2
"

placeholder="Contoh: Membantu membersihkan rumah"

>{{ old('kegiatan_membantu') }}</textarea>


</div>









{{-- TIDUR --}}


<div class="mt-5">


<label class="font-semibold">

Tidur Malam

</label>




<input

type="time"

name="tidur_malam"

value="{{ old('tidur_malam') }}"

class="
w-full
border
rounded-xl
px-4
py-3
mt-2
"

>



</div>










<button

type="submit"

class="
mt-6
bg-indigo-600
hover:bg-indigo-700
text-white
px-6
py-3
rounded-xl
font-semibold
transition
"

>

Simpan Angket

</button>





</form>



</div>









{{-- RIWAYAT --}}


<div class="
bg-white
rounded-2xl
shadow-sm
border
border-gray-100
p-6
">


<h3 class="text-xl font-bold mb-4">

Riwayat Angket Terakhir

</h3>







@php


$riwayat = $orangTua
    ->angketHarian()
    ->orderBy(
        'tanggal',
        'desc'
    )
    ->take(3)
    ->get();



@endphp







@if($riwayat->count())



@foreach($riwayat as $item)



<div class="
border
rounded-xl
p-4
mb-3
">





<div class="flex justify-between items-center">



<div>



<p class="text-gray-700">

Tanggal Aktivitas:

<b>

{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

</b>

</p>





<p class="text-sm text-gray-500 mt-1">


Tanggal Pengisian:

<b>


@if($item->tanggal_pengisian)


{{ 
\Carbon\Carbon::parse(
$item->tanggal_pengisian
)->format('d-m-Y')
}}


@else

-

@endif


</b>


</p>



</div>







@php

$tanggalAktivitas =
\Carbon\Carbon::parse($item->tanggal)
->format('Y-m-d');


$tanggalIsi =
\Carbon\Carbon::parse($item->tanggal_pengisian)
->format('Y-m-d');


@endphp






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









<div class="mt-3 text-sm text-gray-600">


<p>

Belajar:

<b>

{{ $item->belajar ? 'Ya':'Tidak' }}

</b>

</p>





<div class="grid grid-cols-2 gap-3 mt-3">



<div>


<p>

Subuh:

<b>

{{ $item->sholat_subuh ? '✓':'✕' }}

</b>

</p>



<p>

Dzuhur:

<b>

{{ $item->sholat_dzuhur ? '✓':'✕' }}

</b>

</p>



<p>

Ashar:

<b>

{{ $item->sholat_ashar ? '✓':'✕' }}

</b>

</p>



</div>







<div>


<p>

Magrib:

<b>

{{ $item->sholat_magrib ? '✓':'✕' }}

</b>

</p>



<p>

Isya:

<b>

{{ $item->sholat_isya ? '✓':'✕' }}

</b>

</p>



</div>



</div>




</div>




</div>




@endforeach





@else



<p class="text-gray-500">

Belum ada riwayat angket.

</p>



@endif





</div>





</div>


@endsection