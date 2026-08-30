@extends('admin.layouts.app')


@section('title','Detail Monitoring Siswa')


@section('page-title','Detail Monitoring Siswa')



@section('content')


<div class="space-y-5">


@php


$terakhir = $siswa->angketHarian->first();


$totalAngket = $siswa->angketHarian->count();



$totalBelajar = $siswa->angketHarian
    ->where('belajar',true)
    ->count();



$persenBelajar = $totalAngket > 0
    ? round(($totalBelajar/$totalAngket)*100)
    : 0;





$totalIbadah = 0;


foreach($siswa->angketHarian as $item)
{

    $totalIbadah +=

    $item->sholat_subuh +
    $item->sholat_dzuhur +
    $item->sholat_ashar +
    $item->sholat_magrib +
    $item->sholat_isya;

}




$persenIbadah = $totalAngket > 0

    ? round(($totalIbadah/($totalAngket*5))*100)

    : 0;






/*
|--------------------------------------------------------------------------
| DATA GRAFIK
|--------------------------------------------------------------------------
*/


$grafikData = $siswa->angketHarian

    ->whereNotNull('skor')

    ->where('skor','>',0)

    ->sortBy('tanggal');





$grafikTanggal = $grafikData

    ->pluck('tanggal')

    ->map(function($tanggal){

        return \Carbon\Carbon::parse($tanggal)
            ->format('d M Y');

    })

    ->values();





$grafikSkor = $grafikData

    ->pluck('skor')

    ->map(function($skor){

        return (int)$skor;

    })

    ->values();



@endphp







{{-- PROFIL --}}



<div class="bg-white border rounded-xl p-5">


<div class="flex justify-between items-center">


<div class="flex items-center gap-4">



<div class="
w-14
h-14
rounded-xl
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
font-bold
text-xl
">


{{ strtoupper(substr($siswa->nama_siswa,0,1)) }}


</div>






<div>


<h2 class="text-xl font-bold text-gray-800">

{{ $siswa->nama_siswa }}

</h2>


<p class="text-sm text-gray-500">

NIS : {{ $siswa->nis }}

</p>


<p class="text-sm text-gray-500">

Kelas : {{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


<p class="text-sm text-gray-500">

Orang Tua :
{{ $siswa->orangTua->first()->nama_orang_tua ?? '-' }}

</p>


</div>



</div>






<a href="{{ route('monitoring.angket') }}"

class="
bg-gray-100
hover:bg-gray-200
px-4
py-2
rounded-lg
text-sm
">

← Kembali

</a>



</div>


</div>









{{-- EVALUASI --}}



<div class="bg-white border rounded-xl p-5">


<h3 class="font-bold mb-4">

Evaluasi Terakhir

</h3>




@if($terakhir)


<div class="grid md:grid-cols-3 gap-5">



<div>


<p class="text-xs text-gray-500">

Skor

</p>


<p class="text-3xl font-bold text-indigo-600">

{{ $terakhir->skor ?? 0 }}

<span class="text-sm text-gray-400">

/100

</span>

</p>


</div>





<div>


<p class="text-xs text-gray-500">

Kategori

</p>


<span class="
inline-block
mt-2
px-3
py-1
rounded-full
text-xs
bg-green-100
text-green-700
">


{{ $terakhir->kategori ?? '-' }}


</span>


</div>





<div>


<p class="text-xs text-gray-500">

Tanggal

</p>


<p class="font-semibold text-sm mt-2">

{{ \Carbon\Carbon::parse($terakhir->tanggal)->format('d M Y') }}

</p>


</div>


</div>


@endif


</div>









{{-- CATATAN --}}



<div class="
bg-indigo-50
border
border-indigo-100
rounded-xl
p-5
">


<h3 class="font-bold text-indigo-800">

Catatan Monitoring

</h3>


<p class="text-sm text-indigo-700 mt-2">


@if(!$terakhir)

Belum ada aktivitas siswa.


@elseif($terakhir->skor >=80)

Aktivitas siswa dalam kondisi baik dan perlu dipertahankan.


@elseif($terakhir->skor >=50)

Aktivitas cukup baik namun perlu peningkatan.


@else

Siswa membutuhkan pendampingan.


@endif


</p>


</div>









{{-- STATISTIK --}}


<div class="grid md:grid-cols-3 gap-4">



<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Konsistensi Belajar

</p>


<p class="text-2xl font-bold text-green-600 mt-2">

{{ $persenBelajar }}%

</p>

</div>




<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Kepatuhan Ibadah

</p>


<p class="text-2xl font-bold text-blue-600 mt-2">

{{ $persenIbadah }}%

</p>

</div>




<div class="bg-white border rounded-xl p-4">

<p class="text-xs text-gray-500">

Hari Terdata

</p>


<p class="text-2xl font-bold text-purple-600 mt-2">

{{ $totalAngket }}

</p>

</div>


</div>









{{-- GRAFIK --}}


<div class="bg-white border rounded-xl p-5">


<h3 class="font-bold mb-4">

Perkembangan Skor

</h3>




@if(count($grafikSkor) > 1)


<div class="h-80">

<canvas id="scoreChart"></canvas>

</div>



@elseif(count($grafikSkor)==1)



<div class="py-8 text-center">


<p class="text-sm text-gray-500">

Skor Terakhir

</p>



<h2 class="text-5xl font-bold text-indigo-600 mt-3">

{{ $grafikSkor[0] }}

<span class="text-xl text-gray-400">

/100

</span>

</h2>




<div class="mt-5 mx-auto max-w-md bg-gray-100 rounded-full h-3">


<div

class="bg-indigo-600 h-3 rounded-full"

style="width:{{ $grafikSkor[0] }}%"

></div>


</div>


<p class="text-xs text-gray-400 mt-3">

Belum cukup data untuk grafik perkembangan

</p>


</div>




@else


<div class="text-center py-10 text-gray-500">

Belum ada data skor.

</div>



@endif




</div>









{{-- RIWAYAT --}}



<div class="bg-white border rounded-xl p-5">


<h3 class="font-bold mb-5">

Riwayat Aktivitas

</h3>



<div class="space-y-4">



@foreach($siswa->angketHarian as $item)



<div class="
border-l-4
border-indigo-300
pl-4
pb-3
">


<div class="flex justify-between">


<p class="font-semibold text-sm">

{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

</p>



<p class="text-xs font-semibold text-indigo-600">

Skor {{ $item->skor ?? 0 }}

</p>


</div>





<div class="grid md:grid-cols-4 gap-3 mt-3">



<div class="bg-gray-50 rounded-lg p-3">

<p class="text-xs text-gray-400">
Ibadah
</p>


<p class="font-semibold">

{{

$item->sholat_subuh+
$item->sholat_dzuhur+
$item->sholat_ashar+
$item->sholat_magrib+
$item->sholat_isya

}}/5

</p>

</div>




<div class="bg-gray-50 rounded-lg p-3">

<p class="text-xs text-gray-400">

Belajar

</p>


<p class="font-semibold">

{{ $item->belajar?'Ya':'Tidak' }}

</p>

</div>




<div class="bg-gray-50 rounded-lg p-3">

<p class="text-xs text-gray-400">

Bangun

</p>


<p class="font-semibold">

{{ $item->bangun_pagi ?? '-' }}

</p>

</div>




<div class="bg-gray-50 rounded-lg p-3">

<p class="text-xs text-gray-400">

Tidur

</p>


<p class="font-semibold">

{{ $item->tidur_malam ?? '-' }}

</p>

</div>


</div>




@if($item->kegiatan_membantu)


<div class="mt-3 bg-gray-50 rounded-lg p-3 text-sm">

{{ $item->kegiatan_membantu }}

</div>


@endif



</div>



@endforeach



</div>


</div>




</div>









@if(count($grafikSkor)>1)

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


new Chart(

document.getElementById('scoreChart'),

{


type:'line',


data:{


labels:@json($grafikTanggal),


datasets:[{


label:'Skor Aktivitas',

data:@json($grafikSkor),

borderWidth:3,

tension:0.4,

pointRadius:5


}]


},



options:{


responsive:true,


maintainAspectRatio:false,


scales:{


y:{


beginAtZero:true,

max:100


}


}


}


}


);



</script>

@endif




@endsection