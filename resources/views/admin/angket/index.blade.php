@extends('admin.layouts.app')


@section('title','Monitoring Angket Harian')


@section('page-title','Monitoring Angket Harian')



@section('content')


<div class="space-y-6">



{{-- HEADER --}}


<div class="
bg-white
border
rounded-2xl
p-6
shadow-sm
">


<div class="
flex
flex-col
md:flex-row
md:justify-between
md:items-center
gap-4
">


<div>

<h2 class="
text-2xl
font-bold
text-slate-800
">

Monitoring Angket Harian

</h2>


<p class="
text-sm
text-slate-500
mt-2
">

Pemantauan aktivitas harian siswa yang diisi oleh orang tua.

</p>


</div>





<div class="
bg-indigo-50
text-indigo-700
px-5
py-3
rounded-xl
font-semibold
text-sm
">


Total Pengisian :

{{ $angket->count() }}


</div>



</div>


</div>









{{-- STATISTIK --}}


<div class="
grid
grid-cols-1
md:grid-cols-4
gap-5
">



<div class="
bg-white
border
rounded-2xl
p-5
">

<p class="text-sm text-gray-500">

Total Angket

</p>

<h3 class="
text-3xl
font-bold
text-indigo-600
mt-2
">

{{ $angket->count() }}

</h3>

</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-gray-500">

Siswa Terdata

</p>


<h3 class="
text-3xl
font-bold
text-blue-600
mt-2
">

{{ $angket->pluck('siswa_id')->unique()->count() }}

</h3>


</div>







<div class="
bg-green-50
border
border-green-100
rounded-2xl
p-5
">


<p class="text-sm text-green-700">

Tepat Waktu

</p>


<h3 class="
text-3xl
font-bold
text-green-700
mt-2
">


{{ 

$angket->filter(function($item){

return $item->tanggal == $item->tanggal_pengisian;

})->count()

}}


</h3>


</div>







<div class="
bg-yellow-50
border
border-yellow-100
rounded-2xl
p-5
">


<p class="text-sm text-yellow-700">

Telat Isi

</p>


<h3 class="
text-3xl
font-bold
text-yellow-700
mt-2
">


{{ 

$angket->filter(function($item){

return $item->tanggal != $item->tanggal_pengisian;

})->count()

}}


</h3>


</div>



</div>









{{-- TABLE --}}



<div class="
bg-white
border
rounded-2xl
shadow-sm
overflow-hidden
">



<div class="
px-6
py-5
border-b
">


<h3 class="
font-bold
text-slate-800
">

Daftar Aktivitas Siswa

</h3>


<p class="
text-sm
text-gray-500
mt-1
">

Riwayat pengisian angket oleh orang tua.

</p>


</div>







<div class="overflow-x-auto">


<table class="
w-full
text-sm
">


<thead class="bg-slate-50">


<tr>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

No

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Siswa

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Orang Tua

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Tanggal

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Skor

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Kategori

</th>


<th class="px-6 py-4 text-left text-xs text-gray-500 uppercase">

Status

</th>


<th class="px-6 py-4 text-center text-xs text-gray-500 uppercase">

Aksi

</th>


</tr>


</thead>







<tbody class="divide-y">



@forelse($angket as $item)



<tr class="hover:bg-slate-50 transition">



<td class="px-6 py-4">

{{ $loop->iteration }}

</td>







<td class="px-6 py-4">


<p class="
font-semibold
text-slate-800
">

{{ $item->siswa->nama_siswa ?? '-' }}

</p>


<p class="
text-xs
text-gray-400
">

NIS {{ $item->siswa->nis ?? '-' }}

</p>


<p class="
text-xs
text-indigo-600
mt-1
">

{{ $item->siswa->kelas->nama_kelas ?? '-' }}

</p>


</td>







<td class="px-6 py-4">


{{ $item->orangTua->nama_orang_tua ?? '-' }}


</td>







<td class="px-6 py-4">


<p class="font-medium">

{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

</p>


<p class="text-xs text-gray-400">

Isi :

{{ 
$item->tanggal_pengisian
?
\Carbon\Carbon::parse($item->tanggal_pengisian)->format('d M Y')
:
'-'
}}


</p>


</td>







<td class="px-6 py-4">


<span class="
font-bold
text-indigo-600
">

{{ $item->skor ?? 0 }}

</span>

/100


</td>







<td class="px-6 py-4">


@if($item->kategori=='Baik')


<span class="
bg-green-100
text-green-700
px-3
py-1
rounded-full
text-xs
font-semibold
">

Baik

</span>


@elseif($item->kategori=='Perlu Perhatian')


<span class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
text-xs
font-semibold
">

Perhatian

</span>


@else


<span class="
bg-red-100
text-red-700
px-3
py-1
rounded-full
text-xs
font-semibold
">

Pendampingan

</span>


@endif


</td>








<td class="px-6 py-4">


@if(
$item->tanggal ==
$item->tanggal_pengisian
)


<span class="
bg-green-100
text-green-700
px-3
py-1
rounded-full
text-xs
font-semibold
">

✓ Tepat

</span>


@else


<span class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
text-xs
font-semibold
">

⚠ Telat

</span>


@endif


</td>








<td class="
px-6
py-4
text-center
">


<a href="{{ route('admin.angket.detail',$item->id) }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-4
py-2
rounded-lg
text-xs
font-semibold
">


Detail


</a>


</td>



</tr>



@empty


<tr>

<td colspan="8"

class="
text-center
py-12
text-gray-500
">


Belum ada data angket.


</td>


</tr>


@endforelse




</tbody>



</table>


</div>


</div>



</div>


@endsection