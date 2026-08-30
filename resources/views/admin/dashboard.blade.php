@extends('admin.layouts.app')


@section('title','Dashboard Admin')


@section('content')


<div class="space-y-8">





{{-- HEADER DASHBOARD --}}


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


<h3 class="
text-lg
font-semibold
mb-4
">

Data Master

</h3>





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

Jurusan

</p>


<div class="flex justify-between items-end mt-4">


<h2 class="
text-4xl
font-bold
text-indigo-600
">

{{ $totalJurusan }}

</h2>


<span class="
text-xs
text-slate-400
">

Program

</span>


</div>


</div>









<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Kelas

</p>


<div class="flex justify-between items-end mt-4">


<h2 class="
text-4xl
font-bold
text-emerald-600
">

{{ $totalKelas }}

</h2>


<span class="
text-xs
text-slate-400
">

Rombel

</span>


</div>


</div>









<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Siswa

</p>


<div class="flex justify-between items-end mt-4">


<h2 class="
text-4xl
font-bold
text-blue-600
">

{{ $totalSiswa }}

</h2>


<span class="
text-xs
text-slate-400
">

Peserta

</span>


</div>


</div>








<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Orang Tua

</p>


<div class="flex justify-between items-end mt-4">


<h2 class="
text-4xl
font-bold
text-purple-600
">

{{ $totalOrangTua }}

</h2>


<span class="
text-xs
text-slate-400
">

Akun

</span>


</div>


</div>



</div>


</div>







{{-- KONDISI SISWA --}}


<div>


<div class="flex justify-between items-center mb-4">


<h3 class="text-lg font-semibold">
Kondisi Siswa
</h3>


<a href="{{ route('monitoring.angket') }}"
class="text-sm text-indigo-600 hover:underline">

Lihat Monitoring →

</a>


</div>



<div class="
grid
grid-cols-1
md:grid-cols-3
gap-5
">





{{-- BAIK --}}


<div class="
bg-emerald-50
border
border-emerald-100
rounded-2xl
p-6
">


<div class="
flex
justify-between
items-center
">


<div>


<p class="
text-sm
text-emerald-700
">

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


</div>



<div class="
w-12
h-12
rounded-xl
bg-emerald-100
flex
items-center
justify-center
text-xl
">

✓

</div>


</div>


<p class="
text-xs
text-emerald-600
mt-4
">

Siswa dengan perkembangan positif

</p>


</div>









{{-- PERHATIAN --}}


<div class="
bg-yellow-50
border
border-yellow-100
rounded-2xl
p-6
">


<div class="
flex
justify-between
items-center
">


<div>


<p class="
text-sm
text-yellow-700
">

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


</div>



<div class="
w-12
h-12
rounded-xl
bg-yellow-100
flex
items-center
justify-center
text-xl
">

!

</div>


</div>


<p class="
text-xs
text-yellow-600
mt-4
">

Perlu pemantauan rutin

</p>


</div>









{{-- PENDAMPINGAN --}}


<div class="
bg-red-50
border
border-red-100
rounded-2xl
p-6
">


<div class="
flex
justify-between
items-center
">


<div>


<p class="
text-sm
text-red-700
">

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


</div>



<div class="
w-12
h-12
rounded-xl
bg-red-100
flex
items-center
justify-center
text-xl
">

⚠

</div>


</div>


<p class="
text-xs
text-red-600
mt-4
">

Membutuhkan perhatian khusus

</p>


</div>






</div>


</div>

{{-- MONITORING --}}



<div>


<h3 class="
text-lg
font-semibold
mb-4
">

Monitoring Angket Hari Ini

</h3>




<div class="
grid
grid-cols-1
md:grid-cols-3
gap-5
">






<div class="
bg-white
rounded-2xl
border
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


<p class="
text-xs
text-slate-400
mt-2
">

Siswa mengirim laporan hari ini

</p>


</div>








<div class="
bg-white
rounded-2xl
border
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


<p class="
text-xs
text-slate-400
mt-2
">

Perlu tindak lanjut

</p>


</div>









<div class="
bg-white
rounded-2xl
border
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


<div

class="
h-full
bg-indigo-600
rounded-full
"

style="
width: {{ $persentaseAngket }}%
">

</div>


</div>


</div>






</div>


</div>

















{{-- SISWA PERLU PERHATIAN --}}


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
mb-5
">

<h3 class="
font-semibold
text-lg
">

Siswa Perlu Perhatian

</h3>


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


@foreach($siswaPerhatian as $angket)



<tr class="border-b">


<td class="py-3">

{{ $angket->siswa->nama_siswa ?? '-' }}

</td>



<td class="py-3">

{{ $angket->siswa->kelas->nama_kelas ?? '-' }}

</td>



<td class="py-3">

{{ $angket->skor }}

</td>




<td class="py-3">


@if($angket->kategori == 'Perlu Perhatian')


<span class="
px-3
py-1
rounded-full
text-xs
bg-yellow-50
text-yellow-600
">

Perlu Perhatian

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-red-50
text-red-600
">

Perlu Pendampingan

</span>


@endif



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
font-medium
">

Tidak ada siswa yang membutuhkan perhatian.

</div>



@endif



</div>


{{-- GRAFIK --}}



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
mb-5
">


<div>

<h3 class="
font-semibold
text-lg
">

Tren Pengisian Angket

</h3>


<p class="
text-sm
text-slate-400
">

7 hari terakhir

</p>


</div>


</div>





<div class="max-w-4xl mx-auto">


<canvas id="angketChart"
height="80">
</canvas>


</div>



</div>









{{-- BELUM ISI --}}



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
mb-5
">


<h3 class="
font-semibold
text-lg
">

Siswa Belum Mengisi

</h3>


<a href="{{ route('laporan.index') }}"

class="
text-sm
text-indigo-600
hover:underline
">

Lihat Laporan

</a>


</div>







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
px-3
py-1
rounded-full
text-xs
bg-red-50
text-red-600
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
font-medium
">


Semua siswa sudah mengisi angket hari ini.


</div>



@endif



</div>











</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


const ctx =
document.getElementById('angketChart');



new Chart(ctx, {


type:'line',


data:{


labels:@json($grafikTanggal ?? []),


datasets:[{


label:'Jumlah Pengisian',


data:@json($grafikJumlah ?? []),


borderWidth:2,


tension:0.35,


pointRadius:3,


fill:false


}]


},



options:{


responsive:true,


maintainAspectRatio:true,


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


</script>



@endsection