@extends('layouts.orangtua')


@section('title','Isi Angket')


@section('page-title','Isi Angket Harian')



@section('content')


<div class="space-y-6">





{{-- HEADER --}}


<div class="
bg-white
rounded-2xl
border
p-6
">


<div class="flex justify-between items-center">


<div>


<h2 class="
text-xl
font-bold
text-slate-800
">

Isi Angket Harian

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Catat aktivitas harian anak.

</p>


</div>




<a href="{{ route('orangtua.angket.index') }}"

class="
bg-slate-600
hover:bg-slate-700
text-white
px-5
py-3
rounded-xl
text-sm
">

← Kembali

</a>



</div>


</div>









{{-- DATA ANAK --}}


<div class="
bg-indigo-50
border
border-indigo-100
rounded-2xl
p-5
">


<div class="
flex
items-center
gap-4
">


<div class="
w-14
h-14
rounded-2xl
bg-indigo-600
text-white
flex
items-center
justify-center
text-xl
font-bold
">


{{ strtoupper(substr(
$siswa->nama_siswa,
0,
1
)) }}


</div>






<div>


<h3 class="
font-bold
text-indigo-900
">

{{ $siswa->nama_siswa }}

</h3>


<p class="
text-sm
text-indigo-700
">

NIS:
{{ $siswa->nis }}

</p>


<p class="
text-sm
text-indigo-700
">

Kelas:
{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


</div>


</div>


</div>









{{-- FORM --}}



<div class="
bg-white
rounded-2xl
border
p-6
">



<form

action="{{ route('orangtua.angket.store') }}"

method="POST"

>
@if(session('success'))

<div class="
bg-green-50
border
border-green-200
text-green-700
rounded-xl
p-4
mb-5
">

{{ session('success') }}

</div>

@endif



@if(session('error'))

<div class="
bg-red-50
border
border-red-200
text-red-700
rounded-xl
p-4
mb-5
">

{{ session('error') }}

</div>

@endif

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

$tanggalInput = old(
'tanggal',
$tanggalHariIni
);


$statusTelat =
$tanggalInput != $tanggalHariIni;


@endphp







@if($statusTelat)


<div class="
bg-yellow-50
border
border-yellow-200
text-yellow-700
rounded-xl
p-4
mb-5
">


⚠️ Aktivitas tanggal:

<b>
{{ $tanggalInput }}
</b>


<br>


Akan tercatat sebagai:

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
rounded-xl
p-4
mb-5
">


ℹ️ Angket dapat diisi hari ini atau maksimal satu hari sebelumnya.


</div>


@endif







{{-- TANGGAL DAN WAKTU --}}



<div class="
grid
md:grid-cols-2
gap-5
">



<div>


<label class="
text-sm
font-semibold
text-slate-700
">

Tanggal Aktivitas

</label>



<input

type="date"

name="tanggal"

value="{{ $tanggalInput }}"

max="{{ $tanggalHariIni }}"

min="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}"

class="
mt-2
w-full
border
rounded-xl
px-4
py-3
"

>


</div>









<div>


<label class="
text-sm
font-semibold
text-slate-700
">

Bangun Pagi

</label>



<input

type="time"

name="bangun_pagi"

value="{{ old('bangun_pagi') }}"

class="
mt-2
w-full
border
rounded-xl
px-4
py-3
"

>


</div>



</div>









{{-- IBADAH --}}


<div class="mt-6">


<h3 class="
font-semibold
text-slate-800
mb-4
">

Ibadah Harian

</h3>





<div class="
grid
md:grid-cols-5
gap-3
">





@php

$ibadah = [

'sholat_subuh'=>'Subuh',

'sholat_dzuhur'=>'Dzuhur',

'sholat_ashar'=>'Ashar',

'sholat_magrib'=>'Magrib',

'sholat_isya'=>'Isya'

];


@endphp






@foreach($ibadah as $key=>$label)


<label class="
flex
items-center
gap-3
border
rounded-xl
p-4
cursor-pointer
hover:bg-slate-50
">


<input

type="checkbox"

name="{{ $key }}"

value="1"

{{ old($key) ? 'checked':'' }}

class="
rounded
text-indigo-600
"

>


<span class="text-sm">

{{ $label }}

</span>


</label>



@endforeach



</div>


</div>









{{-- AKTIVITAS --}}



<div class="mt-6">


<h3 class="
font-semibold
text-slate-800
mb-4
">

Aktivitas Anak

</h3>






<label class="
text-sm
font-semibold
">

Belajar

</label>



<div class="
flex
gap-5
mt-3
">


<label class="
flex
items-center
gap-2
">


<input

type="radio"

name="belajar"

value="1"

{{ old('belajar')=='1'?'checked':'' }}

>


Ya


</label>





<label class="
flex
items-center
gap-2
">


<input

type="radio"

name="belajar"

value="0"

{{ old('belajar')=='0'?'checked':'' }}

>


Tidak


</label>



</div>









<div class="mt-5">


<label class="
text-sm
font-semibold
">

Kegiatan Membantu

</label>



<textarea

name="kegiatan_membantu"

rows="3"

class="
mt-2
w-full
border
rounded-xl
px-4
py-3
"

placeholder="Contoh: membantu membersihkan rumah"

>{{ old('kegiatan_membantu') }}</textarea>


</div>









<div class="mt-5">


<label class="
text-sm
font-semibold
">

Tidur Malam

</label>



<input

type="time"

name="tidur_malam"

value="{{ old('tidur_malam') }}"

class="
mt-2
w-full
border
rounded-xl
px-4
py-3
"


>


</div>




</div>









<div class="
flex
justify-end
gap-3
mt-8
">


<a href="{{ route('orangtua.angket.index') }}"

class="
px-5
py-3
rounded-xl
border
text-slate-600
">

Batal

</a>




<button

type="submit"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-6
py-3
rounded-xl
font-semibold
">

Simpan Angket

</button>



</div>






</form>


</div>









{{-- RIWAYAT TERAKHIR --}}



<div class="
bg-white
rounded-2xl
border
p-6
">


<h3 class="
font-bold
text-slate-800
mb-5
">

Riwayat Angket Terakhir

</h3>





@php

$riwayat = $siswa
->angketHarian()
->orderBy(
'tanggal',
'desc'
)
->take(3)
->get();


@endphp







@if($riwayat->count())



<div class="space-y-4">



@foreach($riwayat as $item)



@php


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
">


<div class="
flex
justify-between
">


<div>


<p class="font-semibold">

{{

\Carbon\Carbon::parse(
$item->tanggal
)->format('d-m-Y')

}}

</p>


<p class="text-xs text-slate-500">

Diisi:

{{

$item->tanggal_pengisian
?
\Carbon\Carbon::parse(
$item->tanggal_pengisian
)->format('d-m-Y H:i')
:
'-'

}}

</p>


</div>




@if($tanggalAktivitas == $tanggalIsi)


<span class="
bg-emerald-100
text-emerald-700
px-3
py-1
rounded-full
text-xs
">

✓ Tepat Waktu

</span>


@else


<span class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
text-xs
">

⚠ Telat

</span>


@endif



</div>






<div class="
mt-4
grid
md:grid-cols-3
gap-3
text-sm
">



<div>

Belajar:

<b>
{{ $item->belajar == 1 ? 'Ya' : 'Tidak' }}
</b>

</div>



<div>

Ibadah:

<b>

{{

$item->sholat_subuh+
$item->sholat_dzuhur+
$item->sholat_ashar+
$item->sholat_magrib+
$item->sholat_isya

}}/5

</b>

</div>



<div>

Tidur:

<b>

{{ $item->tidur_malam ?? '-' }}

</b>

</div>



</div>



</div>



@endforeach



</div>



@else


<p class="text-sm text-slate-500">

Belum ada riwayat angket.

</p>


@endif



</div>






</div>


<script>

document.addEventListener('DOMContentLoaded', function(){

    const form = document.querySelector(
        'form[action="{{ route('orangtua.angket.store') }}"]'
    );


    if(form)
    {

        const button = form.querySelector(
            'button[type="submit"]'
        );


        form.addEventListener(
            'submit',
            function(){

                button.disabled = true;

                button.innerHTML = 'Menyimpan...';

            }
        );

    }


});

</script>

@endsection