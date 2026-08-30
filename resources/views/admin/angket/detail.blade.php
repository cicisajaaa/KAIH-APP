@extends('admin.layouts.app')


@section('title','Detail Angket')


@section('content')


<div class="space-y-6">



{{-- HEADER --}}

<div class="bg-white border rounded-xl p-6">


<div class="flex justify-between items-start">


<div>

<h2 class="text-xl font-bold text-gray-800">
Detail Monitoring Angket
</h2>


<p class="text-sm text-gray-500 mt-1">
Riwayat aktivitas harian siswa berdasarkan pengisian orang tua.
</p>


</div>



<a href="{{ route('angket.index') }}"
class="
px-4 py-2
rounded-lg
bg-gray-100
hover:bg-gray-200
text-sm
font-semibold
">

← Kembali

</a>



</div>


</div>








{{-- IDENTITAS --}}


<div class="bg-white border rounded-xl">


<div class="px-6 py-4 border-b">

<h3 class="font-semibold text-gray-800">
Identitas Siswa
</h3>

</div>



<div class="p-6 grid md:grid-cols-2 gap-6">


<div class="space-y-3 text-sm">


<div class="flex justify-between">

<span class="text-gray-500">
Nama Siswa
</span>

<span class="font-semibold">
{{ $angket->siswa->nama_siswa ?? '-' }}
</span>

</div>



<div class="flex justify-between">

<span class="text-gray-500">
NIS
</span>

<span>
{{ $angket->siswa->nis ?? '-' }}
</span>

</div>



<div class="flex justify-between">

<span class="text-gray-500">
Kelas
</span>

<span>
{{ $angket->siswa->kelas->nama_kelas ?? '-' }}
</span>

</div>


</div>





<div class="space-y-3 text-sm">


<div class="flex justify-between">

<span class="text-gray-500">
Orang Tua Pengisi
</span>

<span class="font-semibold">
{{ $angket->orangTua->nama_orang_tua ?? '-' }}
</span>

</div>




<div class="flex justify-between">

<span class="text-gray-500">
Tanggal Aktivitas
</span>

<span>
{{ \Carbon\Carbon::parse($angket->tanggal)->format('d-m-Y') }}
</span>

</div>




<div class="flex justify-between">

<span class="text-gray-500">
Tanggal Pengisian
</span>

<span>
{{ 
$angket->tanggal_pengisian
?
\Carbon\Carbon::parse($angket->tanggal_pengisian)->format('d-m-Y H:i')
:
'-'
}}
</span>

</div>



</div>



</div>

</div>









{{-- HASIL --}}


<div class="bg-white border rounded-xl">


<div class="px-6 py-4 border-b">

<h3 class="font-semibold text-gray-800">
Hasil Evaluasi
</h3>

</div>



<div class="p-6 flex flex-wrap gap-8">


<div>

<p class="text-xs text-gray-500">
Skor Aktivitas
</p>

<p class="text-3xl font-bold text-indigo-600">
{{ $angket->skor ?? 0 }}
<span class="text-base text-gray-400">
/100
</span>
</p>

</div>




<div>

<p class="text-xs text-gray-500">
Kategori
</p>


@if($angket->kategori == 'Baik')

<span class="
inline-block
mt-2
px-3 py-1
rounded-full
text-xs
font-semibold
bg-green-100
text-green-700
">
Baik
</span>


@elseif($angket->kategori == 'Perlu Perhatian')


<span class="
inline-block
mt-2
px-3 py-1
rounded-full
text-xs
font-semibold
bg-yellow-100
text-yellow-700
">
Perlu Perhatian
</span>


@else


<span class="
inline-block
mt-2
px-3 py-1
rounded-full
text-xs
font-semibold
bg-red-100
text-red-700
">
Perlu Pendampingan
</span>


@endif


</div>



</div>


</div>









{{-- AKTIVITAS --}}



<div class="bg-white border rounded-xl overflow-hidden">


<div class="px-6 py-4 border-b">

<h3 class="font-semibold text-gray-800">
Detail Aktivitas Harian
</h3>

</div>




<table class="w-full text-sm">


<tbody class="divide-y">


<tr>

<td class="px-6 py-3 text-gray-500 w-1/3">
Sholat Subuh
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->sholat_subuh ? 'Dilaksanakan' : 'Tidak' }}
</td>

</tr>



<tr>

<td class="px-6 py-3 text-gray-500">
Sholat Dzuhur
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->sholat_dzuhur ? 'Dilaksanakan' : 'Tidak' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Sholat Ashar
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->sholat_ashar ? 'Dilaksanakan' : 'Tidak' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Sholat Magrib
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->sholat_magrib ? 'Dilaksanakan' : 'Tidak' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Sholat Isya
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->sholat_isya ? 'Dilaksanakan' : 'Tidak' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Belajar
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->belajar ? 'Ya' : 'Tidak' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Bangun Pagi
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->bangun_pagi ?? '-' }}
</td>

</tr>




<tr>

<td class="px-6 py-3 text-gray-500">
Tidur Malam
</td>

<td class="px-6 py-3 font-medium">
{{ $angket->tidur_malam ?? '-' }}
</td>

</tr>


</tbody>


</table>


</div>









{{-- CATATAN --}}


<div class="bg-white border rounded-xl p-6">


<h3 class="font-semibold text-gray-800 mb-3">
Catatan Kegiatan
</h3>


<p class="text-sm text-gray-600 leading-relaxed">

{{ $angket->kegiatan_membantu ?? 'Tidak ada catatan kegiatan.' }}

</p>


</div>




</div>


@endsection