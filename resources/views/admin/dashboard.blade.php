@extends('admin.layouts.app')


@section('title','Dashboard Admin')


@section('content')


<div class="space-y-8">



{{-- HEADER --}}

<div class="
bg-white
rounded-2xl
border
p-7
flex
justify-between
items-center
">


<div>

<h2 class="
text-2xl
font-bold
text-slate-800
">

Selamat Datang, Administrator

</h2>


<p class="
text-slate-500
mt-2
">

Kelola data akademik dan monitoring aktivitas siswa melalui sistem KAIH.

</p>


</div>




<div class="
hidden md:block
bg-indigo-50
px-5
py-3
rounded-xl
text-indigo-700
text-sm
font-semibold
">

Monitoring Aktif

</div>



</div>








{{-- DATA MASTER --}}


<div>


<h3 class="text-lg font-semibold mb-4">

Data Master

</h3>




<div class="
grid
grid-cols-1
md:grid-cols-4
gap-5
">



@php

$master = [

[
'judul'=>'Jurusan',
'value'=>$totalJurusan,
'label'=>'Program',
'color'=>'text-indigo-600'
],

[
'judul'=>'Kelas',
'value'=>$totalKelas,
'label'=>'Rombel',
'color'=>'text-emerald-600'
],

[
'judul'=>'Siswa',
'value'=>$totalSiswa,
'label'=>'Peserta',
'color'=>'text-blue-600'
],

[
'judul'=>'Orang Tua',
'value'=>$totalOrangTua,
'label'=>'Akun',
'color'=>'text-purple-600'
]

];

@endphp



@foreach($master as $item)


<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

{{ $item['judul'] }}

</p>


<div class="flex justify-between items-end mt-4">


<h2 class="
text-4xl
font-bold
{{ $item['color'] }}
">

{{ $item['value'] }}

</h2>


<span class="
text-xs
text-slate-400
">

{{ $item['label'] }}

</span>


</div>


</div>


@endforeach



</div>


</div>









{{-- KONDISI SISWA --}}



<div>


<div class="flex justify-between items-center mb-4">


<h3 class="text-lg font-semibold">

Kondisi Siswa

</h3>



<a href="{{ route('monitoring.angket') }}"

class="
text-sm
text-indigo-600
hover:underline
">

Lihat Monitoring →

</a>


</div>





<div class="
grid
md:grid-cols-3
gap-5
">





<div class="
bg-emerald-50
border
border-emerald-100
rounded-2xl
p-6
">


<p class="text-sm text-emerald-700">

Kondisi Baik

</p>


<h2 class="
text-4xl
font-bold
text-emerald-600
mt-3
">

{{ $jumlahBaik }}

</h2>


<p class="text-xs text-emerald-600 mt-4">

Perkembangan positif

</p>


</div>








<div class="
bg-yellow-50
border
border-yellow-100
rounded-2xl
p-6
">


<p class="text-sm text-yellow-700">

Perlu Perhatian

</p>


<h2 class="
text-4xl
font-bold
text-yellow-600
mt-3
">

{{ $jumlahPerhatian }}

</h2>


<p class="text-xs text-yellow-600 mt-4">

Perlu pemantauan rutin

</p>


</div>








<div class="
bg-red-50
border
border-red-100
rounded-2xl
p-6
">


<p class="text-sm text-red-700">

Perlu Pendampingan

</p>


<h2 class="
text-4xl
font-bold
text-red-600
mt-3
">

{{ $jumlahPendampingan }}

</h2>


<p class="text-xs text-red-600 mt-4">

Membutuhkan tindakan

</p>


</div>




</div>


</div>









{{-- MONITORING ANGKET --}}


<div>


<h3 class="text-lg font-semibold mb-4">

Monitoring Angket Hari Ini

</h3>



<div class="
grid
md:grid-cols-3
gap-5
">





<div class="
bg-white
border
rounded-2xl
p-6
">

<p class="text-sm text-slate-500">

Sudah Mengisi

</p>


<h2 class="
text-4xl
font-bold
text-emerald-600
mt-3
">

{{ $angketHariIni }}

</h2>


</div>







<div class="
bg-white
border
rounded-2xl
p-6
">

<p class="text-sm text-slate-500">

Belum Mengisi

</p>


<h2 class="
text-4xl
font-bold
text-red-500
mt-3
">

{{ $belumIsiAngket }}

</h2>


</div>







<div class="
bg-white
border
rounded-2xl
p-6
">


<p class="text-sm text-slate-500">

Tingkat Kepatuhan

</p>


<h2 class="
text-4xl
font-bold
text-indigo-600
mt-3
">

{{ $persentaseAngket }}%

</h2>


<div class="
mt-4
h-2
bg-slate-100
rounded-full
overflow-hidden
">


<div class="
bg-indigo-600
h-full
rounded-full
"

style="
width:{{ $persentaseAngket }}%
">

</div>


</div>


</div>




</div>


</div>









{{-- SISWA PERHATIAN --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<div class="mb-5">


<h3 class="font-semibold text-lg">

Siswa Perlu Perhatian

</h3>


<p class="text-sm text-slate-400">

Data monitoring terakhir

</p>


</div>






@if($siswaPerhatian->count())

<div class="overflow-x-auto">


<table class="w-full">


<thead>


<tr class="
border-b
text-sm
text-slate-500
">


<th class="text-left py-3">

Nama

</th>


<th class="text-left py-3">

Kelas

</th>


<th class="text-left py-3">

Skor

</th>


<th class="text-left py-3">

Kategori

</th>


</tr>


</thead>




<tbody>


@foreach($siswaPerhatian as $item)


<tr class="border-b">


<td class="py-3">

{{ $item->siswa->nama_siswa ?? '-' }}

</td>


<td class="py-3">

{{ $item->siswa->kelas->nama_kelas ?? '-' }}

</td>


<td class="py-3">

{{ $item->skor }}

</td>


<td class="py-3">


<span class="
px-3
py-1
rounded-full
text-xs
{{ 
$item->kategori == 'Perlu Perhatian'
?
'bg-yellow-100 text-yellow-700'
:
'bg-red-100 text-red-700'
}}
">

{{ $item->kategori }}

</span>


</td>


</tr>


@endforeach


</tbody>


</table>


</div>


@else


<div class="
text-center
py-8
text-emerald-600
">

Tidak ada siswa yang membutuhkan perhatian.

</div>


@endif


</div>









{{-- GRAFIK --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="font-semibold text-lg mb-5">

Tren Pengisian Angket

</h3>


<canvas id="angketChart"></canvas>


</div>









{{-- BELUM ISI --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="font-semibold text-lg mb-5">

Siswa Belum Mengisi

</h3>




@if($siswaBelumIsi->count())


<div class="overflow-x-auto">


<table class="w-full">


<thead>


<tr class="
border-b
text-sm
text-slate-500
">


<th class="text-left py-3">

Nama

</th>


<th class="text-left py-3">

Kelas

</th>


<th class="text-left py-3">

Status

</th>


</tr>


</thead>



<tbody>


@foreach($siswaBelumIsi as $siswa)


<tr class="border-b">


<td class="py-3">

{{ $siswa->nama_siswa }}

</td>


<td class="py-3">

{{ $siswa->kelas->nama_kelas ?? '-' }}

</td>


<td class="py-3">


<span class="
bg-red-100
text-red-700
px-3
py-1
rounded-full
text-xs
">

Belum Isi

</span>


</td>


</tr>


@endforeach


</tbody>


</table>


</div>



@else


<div class="
text-center
py-8
text-emerald-600
">

Semua siswa sudah mengisi angket.

</div>


@endif


</div>






</div>








<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


const ctx = document.getElementById('angketChart');


if(ctx)
{


new Chart(ctx,{


type:'line',


data:{


labels:@json($grafikTanggal ?? []),


datasets:[{

label:'Jumlah Pengisian',

data:@json($grafikJumlah ?? []),

borderWidth:2,

tension:0.35,

pointRadius:4

}]


},



options:{


responsive:true,


plugins:{


legend:{


display:false


}


},


scales:{


y:{


beginAtZero:true,


ticks:{


stepSize:1


}


}


}



}



});


}


</script>



@endsection