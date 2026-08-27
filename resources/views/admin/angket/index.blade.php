@extends('admin.layouts.app')


@section('title','Monitoring Angket Harian')


@section('page-title','Monitoring Angket Harian')



@section('content')


<div class="space-y-6">



{{-- HEADER --}}


<div class="bg-white rounded-2xl shadow-sm border p-6">


<div class="flex justify-between items-center">


<div>

<h2 class="text-2xl font-bold text-gray-800">

Monitoring Angket Harian

</h2>


<p class="text-gray-500 mt-1">

Rekap aktivitas harian siswa yang diisi oleh orang tua.

</p>


</div>




<div>

<span class="
bg-indigo-50
text-indigo-700
px-4
py-2
rounded-xl
font-semibold
">

Total :
{{ $angket->count() }}

</span>


</div>



</div>


</div>









{{-- TABLE --}}


<div class="
bg-white
rounded-2xl
shadow-sm
border
overflow-hidden
">



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
Tanggal Aktivitas
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
Tanggal Isi
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
Ibadah
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
Belajar
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">
Kegiatan
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



@forelse($angket as $item)



<tr class="hover:bg-gray-50 transition">



<td class="px-6 py-4">

{{ $loop->iteration }}

</td>







<td class="px-6 py-4">


<div class="font-semibold text-gray-800">

{{ $item->siswa->nama_siswa ?? '-' }}

</div>


<div class="text-xs text-gray-500">

NIS:
{{ $item->siswa->nis ?? '-' }}

</div>


</td>







<td class="px-6 py-4">


<span class="
bg-indigo-50
text-indigo-700
px-3
py-1
rounded-full
text-xs
font-semibold
">


{{ $item->siswa->kelas->nama_kelas ?? '-' }}


</span>


</td>







<td class="px-6 py-4">


{{ $item->orangTua->nama_orang_tua ?? '-' }}


</td>







<td class="px-6 py-4">


{{ 
\Carbon\Carbon::parse($item->tanggal)
->format('d-m-Y')
}}


</td>







<td class="px-6 py-4">


@if($item->tanggal_pengisian)


{{ 
\Carbon\Carbon::parse($item->tanggal_pengisian)
->format('d-m-Y')
}}


@else

-

@endif


</td>







<td class="px-6 py-4">


{{

$item->sholat_subuh +

$item->sholat_dzuhur +

$item->sholat_ashar +

$item->sholat_magrib +

$item->sholat_isya

}} / 5


</td>







<td class="px-6 py-4">


@if($item->belajar)


<span class="
bg-green-100
text-green-700
px-3
py-1
rounded-full
text-xs
">

Ya

</span>


@else


<span class="
bg-red-100
text-red-700
px-3
py-1
rounded-full
text-xs
">

Tidak

</span>


@endif


</td>







<td class="px-6 py-4 max-w-xs">


<p class="truncate">

{{ $item->kegiatan_membantu ?? '-' }}

</p>


</td>







<td class="px-6 py-4">


@if(
$item->tanggal_pengisian
&&
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
font-semibold
">

⚠ Telat Isi

</span>


@endif


</td>







<td class="px-6 py-4">


<a href="{{ route(
    'admin.angket.detail',
    $item->id
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



@empty



<tr>

<td colspan="11"

class="
px-6
py-12
text-center
text-gray-500
">


<div class="text-4xl mb-3">

📝

</div>


<p class="font-semibold">

Belum ada data angket

</p>


</td>


</tr>



@endforelse




</tbody>



</table>


</div>


</div>





</div>


@endsection