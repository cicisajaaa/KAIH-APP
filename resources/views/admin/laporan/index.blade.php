@extends('admin.layouts.app')


@section('title','Laporan Monitoring')


@section('content')


<div class="space-y-6">



{{-- HEADER --}}


<div class="bg-white border rounded-xl p-5">

<div class="
flex
flex-col
md:flex-row
md:justify-between
md:items-center
gap-5
">


<div>

<h2 class="
text-2xl
font-bold
text-gray-800
">

Laporan Monitoring Siswa

</h2>


<p class="
text-sm
text-gray-500
mt-2
">

Rekap perkembangan aktivitas harian siswa KAIH.

</p>


</div>




<div class="
flex
items-center
gap-4
">


<div class="text-right">


<p class="
text-xs
text-gray-400
">

Periode

</p>


<p class="
text-sm
font-semibold
text-gray-700
">
@if($tanggalMulai && $tanggalAkhir)

{{ $tanggalMulai }}
s/d
{{ $tanggalAkhir }}

@elseif($tanggalMulai)

Mulai {{ $tanggalMulai }}

@elseif($tanggalAkhir)

Sampai {{ $tanggalAkhir }}

@else

Semua Data

@endif


</p>


</div>





<a href="{{ route('laporan.export',request()->query()) }}"

class="
bg-green-600
hover:bg-green-700
text-white
px-5
py-2.5
rounded-xl
text-sm
font-semibold
shadow-sm
">

⬇ Export Excel

</a>

<a href="{{ route('laporan.pdf',request()->query()) }}"

class="
bg-red-600
hover:bg-red-700
text-white
px-5
py-2.5
rounded-xl
text-sm
font-semibold
shadow-sm
">

🖨 Cetak PDF

</a>

</div>



</div>
</div>








{{-- FILTER --}}


<div class="bg-white border rounded-xl p-5">


<h3 class="font-semibold text-gray-800 mb-4">

Filter Laporan

</h3>



<form method="GET">


<div class="grid md:grid-cols-5 gap-4">



<div>

<label class="text-xs text-gray-500">

Kelas

</label>


<select

name="kelas_id"

class="
w-full
mt-2
border
rounded-lg
px-3
py-2
text-sm
">


<option value="">

Semua Kelas

</option>


@foreach($kelas as $item)


<option

value="{{ $item->id }}"

{{ $kelasId==$item->id?'selected':'' }}

>

{{ $item->nama_kelas }}

</option>


@endforeach


</select>


</div>






<div>

<label class="text-xs text-gray-500">

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
text-sm
"


>

</div>






<div>

<label class="text-xs text-gray-500">

Tanggal Akhir

</label>


<input

type="date"

name="tanggal_selesai"

value="{{ $tanggalAkhir }}"

class="
w-full
mt-2
border
rounded-lg
px-3
py-2
text-sm
"


>

</div>



<div>

<label class="text-xs text-gray-500">

Kategori

</label>


<select
name="kategori"
class="
w-full
mt-2
border
rounded-lg
px-3
py-2
text-sm
">


<option value="">
Semua Kondisi
</option>


<option value="Baik"
{{ ($kategori ?? '')=='Baik'?'selected':'' }}
>
Baik
</option>


<option value="Perlu Perhatian"
{{ ($kategori ?? '')=='Perlu Perhatian'?'selected':'' }}
>
Perlu Perhatian
</option>


<option value="Perlu Pendampingan"
{{ ($kategori ?? '')=='Perlu Pendampingan'?'selected':'' }}
>
Perlu Pendampingan
</option>


</select>


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
text-sm
font-semibold
shadow-sm
transition
">

Tampilkan

</button>


</div>



</div>


</form>


</div>









{{-- STATISTIK UTAMA --}}


<div class="
grid
grid-cols-1
sm:grid-cols-2
lg:grid-cols-4
gap-5
">



<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Total Siswa

</p>

<h2 class="text-2xl font-bold text-gray-800 mt-2">

{{ $totalSiswa }}

</h2>


</div>





<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Total Angket

</p>


<h2 class="text-2xl font-bold text-indigo-600 mt-2">

{{ $totalAngket }}

</h2>


</div>





<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Rata-rata Skor

</p>


<h2 class="text-2xl font-bold text-blue-600 mt-2">

{{ $rataRataSkor }}

</h2>


</div>





<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Kepatuhan Pengisian

</p>


<h2 class="text-2xl font-bold text-green-600 mt-2">

{{ $persentasePengisian }}%

</h2>


</div>


</div>









{{-- KONDISI SISWA --}}



<div class="
grid
grid-cols-1
md:grid-cols-3
gap-5
">



<div class="bg-green-50 border border-green-100 rounded-xl p-4">


<p class="text-sm text-green-700">

Kondisi Baik

</p>


<h2 class="text-2xl font-bold text-green-700 mt-2">

{{ $jumlahBaik }}

</h2>


</div>





<div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4">


<p class="text-sm text-yellow-700">

Perlu Perhatian

</p>


<h2 class="text-2xl font-bold text-yellow-700 mt-2">

{{ $jumlahPerhatian }}

</h2>


</div>





<div class="bg-red-50 border border-red-100 rounded-xl p-4">


<p class="text-sm text-red-700">

Perlu Pendampingan

</p>


<h2 class="text-2xl font-bold text-red-700 mt-2">

{{ $jumlahPendampingan }}

</h2>


</div>


</div>






{{-- TABEL --}}

<div class="bg-white border rounded-xl overflow-hidden">


<div class="p-5 border-b">

<h3 class="font-semibold text-gray-800">

Rekap Perkembangan Siswa

</h3>

</div>



<div class="overflow-x-auto">


<table class="w-full text-sm whitespace-nowrap">


<thead class="bg-slate-50">

<tr>


<th class="px-6 py-4 text-left">
No
</th>


<th class="px-6 py-4 text-left">
Siswa
</th>


<th class="px-6 py-4 text-left">
Kelas
</th>


<th class="px-6 py-4 text-left">
Jumlah Angket
</th>


<th class="px-6 py-4 text-left">
Skor
</th>


<th class="px-6 py-4 text-left">
Kondisi
</th>


<th class="px-6 py-4 text-left">
Status
</th>


<th class="px-6 py-4 text-left">
Aksi
</th>


</tr>

</thead>




<tbody>


@if($siswas->count())


@foreach($siswas as $siswa)


@php

$data = $siswa->angketHarian;


if($tanggalMulai && $tanggalAkhir)
{

$data = $data->whereBetween(
'tanggal',
[
$tanggalMulai,
$tanggalAkhir
]
);

}


if($kategori)
{

$data = $data->where(
'kategori',
$kategori
);

}



$terakhir = $data

->sortByDesc('tanggal')

->sortByDesc('id')

->first();



$skor = round(
$data->avg('skor') ?? 0
);



$kategoriSiswa = $terakhir->kategori ?? null;


@endphp




<tr class="border-t hover:bg-gray-50">



<td class="px-6 py-4">

{{ $loop->iteration }}

</td>




<td class="px-6 py-4">


<p class="font-semibold">

{{ $siswa->nama_siswa }}

</p>


<p class="text-xs text-gray-400">

NIS {{ $siswa->nis }}

</p>


</td>




<td class="px-6 py-4">

{{ $siswa->kelas->nama_kelas ?? '-' }}

</td>




<td class="px-6 py-4">

{{ $data->count() }}

</td>




<td class="px-6 py-4 font-semibold">

{{ $skor }}

</td>




<td class="px-6 py-4">


@if($kategoriSiswa == 'Baik')


<span class="
px-3 py-1
rounded-full
text-xs
bg-green-100
text-green-700
">

Baik

</span>



@elseif($kategoriSiswa == 'Perlu Perhatian')


<span class="
px-3 py-1
rounded-full
text-xs
bg-yellow-100
text-yellow-700
">

Perhatian

</span>



@elseif($kategoriSiswa == 'Perlu Pendampingan')


<span class="
px-3 py-1
rounded-full
text-xs
bg-red-100
text-red-700
">

Pendampingan

</span>



@else

-

@endif


</td>





<td class="px-6 py-4">


@if($data->count())


<span class="
text-green-600
text-xs
font-semibold
">

Terdata

</span>


@else


<span class="
text-gray-400
text-xs
">

Belum Ada

</span>


@endif


</td>




<td class="px-6 py-4">


<a href="{{ route(
'monitoring.angket.detail',
$siswa->id
) }}"

class="
bg-indigo-100
text-indigo-700
px-3
py-1
rounded-lg
text-xs
font-semibold
">

Detail

</a>


</td>



</tr>



@endforeach



@else


<tr>

<td colspan="8"

class="
text-center
py-6
text-gray-500
">

Belum ada data siswa

</td>

</tr>


@endif



</tbody>



</table>


</div>


</div>

@endsection