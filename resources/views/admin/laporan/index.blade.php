@extends('admin.layouts.app')


@section('title','Laporan Monitoring')


@section('content')


<div class="space-y-8">





{{-- HEADER --}}


<div class="
bg-white
rounded-2xl
border
p-7
">


<div class="flex justify-between items-center">


<div>


<h2 class="
text-2xl
font-bold
text-slate-800
">

Laporan Monitoring Siswa

</h2>


<p class="
text-slate-500
mt-2
">

Rekap aktivitas harian siswa melalui pengisian angket KAIH.

</p>


</div>




<div class="
text-right
hidden md:block
">


<p class="
text-sm
text-slate-400
">

Periode Monitoring

</p>


<p class="
font-semibold
text-slate-700
">


@if($tanggalMulai && $tanggalAkhir)

{{ $tanggalMulai }}
s/d
{{ $tanggalAkhir }}

@else

Hari Ini

@endif


</p>


</div>



</div>


</div>









{{-- SUMMARY --}}



<div class="
grid
grid-cols-1
md:grid-cols-4
gap-5
">





<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Total Siswa

</p>


<div class="flex items-center justify-between mt-4">


<h2 class="
text-4xl
font-bold
text-blue-600
">

{{ $totalSiswa }}

</h2>


<div class="
w-10
h-10
rounded-xl
bg-blue-50
flex
items-center
justify-center
text-blue-600
">

👤

</div>


</div>


</div>








<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Sudah Isi

</p>


<div class="flex items-center justify-between mt-4">


<h2 class="
text-4xl
font-bold
text-emerald-600
">

{{ $sudahIsi }}

</h2>


<div class="
w-10
h-10
rounded-xl
bg-emerald-50
flex
items-center
justify-center
text-emerald-600
">

✓

</div>


</div>


</div>








<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Belum Isi

</p>


<div class="flex items-center justify-between mt-4">


<h2 class="
text-4xl
font-bold
text-red-500
">

{{ $belumIsi }}

</h2>


<div class="
w-10
h-10
rounded-xl
bg-red-50
flex
items-center
justify-center
text-red-600
">

!

</div>


</div>


</div>








<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Kepatuhan

</p>



<div class="flex justify-between mt-4">


<h2 class="
text-4xl
font-bold
text-indigo-600
">

{{ $persentasePengisian }}%

</h2>



</div>




<div class="
mt-4
h-2
bg-slate-100
rounded-full
">


<div

class="
h-2
bg-indigo-600
rounded-full
"

style="
width:{{ $persentasePengisian }}%
">

</div>


</div>


</div>




</div>









{{-- FILTER --}}



<div class="
bg-white
rounded-2xl
border
p-6
">



<div class="
flex
justify-between
items-center
mb-6
">


<div>


<h3 class="
font-semibold
text-lg
">

Pencarian Data

</h3>


<p class="
text-sm
text-slate-400
">

Gunakan filter untuk melihat data tertentu.

</p>


</div>




<a href="{{ route('laporan.index') }}"

class="
text-sm
text-slate-500
hover:text-indigo-600
">

Reset

</a>



</div>







<form method="GET">


<div class="
grid
md:grid-cols-4
gap-5
">



<div>

<label class="text-sm font-medium">

Kelas

</label>


<select

name="kelas_id"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
">


<option value="">

Semua Kelas

</option>



@foreach($kelas as $item)


<option value="{{ $item->id }}"

{{ $kelasId==$item->id?'selected':'' }}

>

{{ $item->nama_kelas }}

</option>


@endforeach


</select>


</div>






<div>

<label class="text-sm font-medium">

Tanggal Awal

</label>


<input

type="date"

name="tanggal_mulai"

value="{{ $tanggalMulai }}"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
">


</div>







<div>

<label class="text-sm font-medium">

Tanggal Akhir

</label>


<input

type="date"

name="tanggal_selesai"

value="{{ $tanggalAkhir }}"

class="
mt-2
w-full
rounded-xl
border
px-4
py-3
">


</div>







<div class="flex items-end">


<button

class="
w-full
bg-indigo-600
hover:bg-indigo-700
text-white
rounded-xl
py-3
font-semibold
">

Tampilkan Data

</button>


</div>


</div>



</form>



</div>









{{-- TABLE --}}



<div class="
bg-white
rounded-2xl
border
overflow-hidden
">



<div class="
px-6
py-5
border-b
">


<h3 class="
font-semibold
text-lg
">

Detail Aktivitas Siswa

</h3>


<p class="
text-sm
text-slate-400
">

Status pengisian dan perkembangan aktivitas harian.

</p>


</div>






<div class="overflow-x-auto">


<table class="w-full">


<thead class="bg-slate-50">


<tr>


<th class="px-6 py-4 text-left text-sm">

Siswa

</th>


<th class="px-6 py-4 text-left text-sm">

Kelas

</th>


<th class="px-6 py-4 text-left text-sm">

Status

</th>


<th class="px-6 py-4 text-left text-sm">

Ibadah

</th>


<th class="px-6 py-4 text-left text-sm">

Belajar

</th>


<th class="px-6 py-4 text-left text-sm">

Waktu Isi

</th>


</tr>


</thead>





<tbody>



@foreach($siswas as $siswa)


<tr class="
border-b
hover:bg-slate-50
transition
">



<td class="px-6 py-4">


<p class="
font-semibold
">

{{ $siswa->nama_siswa }}

</p>


<p class="
text-xs
text-slate-400
">

NIS {{ $siswa->nis }}

</p>


</td>





<td class="px-6 py-4">

{{ $siswa->kelas->nama_kelas ?? '-' }}

</td>







<td class="px-6 py-4">


@if($siswa->angketHariIni)


<span class="
px-3
py-1
rounded-full
bg-emerald-50
text-emerald-600
text-xs
font-semibold
">

Selesai

</span>


@else


<span class="
px-3
py-1
rounded-full
bg-red-50
text-red-600
text-xs
font-semibold
">

Belum

</span>


@endif


</td>







<td class="px-6 py-4">


@if($siswa->angketHariIni)


{{ 
$siswa->angketHariIni->sholat_subuh+
$siswa->angketHariIni->sholat_dzuhur+
$siswa->angketHariIni->sholat_ashar+
$siswa->angketHariIni->sholat_magrib+
$siswa->angketHariIni->sholat_isya
}} / 5


@else

-

@endif


</td>







<td class="px-6 py-4">


@if($siswa->angketHariIni)

{{ $siswa->angketHariIni->belajar?'Ya':'Tidak' }}

@else

-

@endif


</td>







<td class="px-6 py-4 text-sm">


@if($siswa->angketHariIni)

{{ $siswa->angketHariIni->tanggal_pengisian }}

@else

-

@endif


</td>




</tr>


@endforeach



</tbody>



</table>


</div>



</div>





</div>


@endsection