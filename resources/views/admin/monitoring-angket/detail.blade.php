@extends('admin.layouts.app')


@section('title','Detail Monitoring Siswa')


@section('page-title','Detail Monitoring Siswa')



@section('content')


<div class="space-y-6">


@php


$terakhir = $riwayat->first();



$grafikData = $riwayat
    ->whereNotNull('skor')
    ->sortBy([
        ['tanggal','asc'],
        ['id','asc']
    ])
    ->values();



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







{{-- PROFIL SISWA --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<div class="
flex
flex-col
md:flex-row
md:justify-between
md:items-center
gap-5
">


<div class="
flex
items-center
gap-4
">



<div class="
w-16
h-16
rounded-2xl
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
font-bold
text-2xl
">


{{ strtoupper(substr($siswa->nama_siswa,0,1)) }}


</div>





<div>


<h2 class="
text-2xl
font-bold
text-slate-800
">

{{ $siswa->nama_siswa }}

</h2>




<p class="
text-sm
text-slate-500
">

NIS :
{{ $siswa->nis }}

</p>




<p class="
text-sm
text-slate-500
">

Kelas :
{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>




<p class="
text-sm
text-slate-500
">

Orang Tua :
{{ optional($siswa->orangTua->first())->nama_orang_tua ?? '-' }}

</p>



</div>



</div>







<a href="{{ route('monitoring.angket') }}"

class="
bg-slate-100
hover:bg-slate-200
px-5
py-3
rounded-xl
text-sm
font-semibold
">

← Kembali

</a>



</div>


</div>









{{-- EVALUASI TERAKHIR --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-lg
mb-5
">

Evaluasi Terakhir

</h3>





@if($terakhir)



<div class="
grid
md:grid-cols-3
gap-5
">





<div class="
bg-indigo-50
rounded-xl
p-5
">


<p class="
text-sm
text-slate-500
">

Skor

</p>


<p class="
text-4xl
font-bold
text-indigo-600
mt-2
">

{{ $skorTerakhir ?? 0 }}

<span class="
text-lg
text-slate-400
">

/100

</span>


</p>


</div>







<div class="
bg-slate-50
rounded-xl
p-5
">


<p class="
text-sm
text-slate-500
">

Kategori

</p>



@if($kategoriTerakhir == 'Baik')


<span class="
inline-block
mt-3
px-3
py-1
rounded-full
text-xs
bg-green-100
text-green-700
font-semibold
">

🟢 Baik

</span>



@elseif($kategoriTerakhir == 'Perlu Perhatian')


<span class="
inline-block
mt-3
px-3
py-1
rounded-full
text-xs
bg-yellow-100
text-yellow-700
font-semibold
">

🟡 Perlu Perhatian

</span>



@else


<span class="
inline-block
mt-3
px-3
py-1
rounded-full
text-xs
bg-red-100
text-red-700
font-semibold
">

🔴 Perlu Pendampingan

</span>



@endif



</div>







<div class="
bg-slate-50
rounded-xl
p-5
">


<p class="
text-sm
text-slate-500
">

Tanggal

</p>



<p class="
font-bold
mt-3
">

{{ \Carbon\Carbon::parse($terakhir->tanggal)->format('d M Y') }}

</p>



</div>




</div>






@if($terakhir->alasan_tidak_sholat)


<div class="
mt-5
bg-red-50
border
border-red-100
rounded-xl
p-4
">


<h4 class="
font-semibold
text-red-700
">

Keterangan Tidak Sholat

</h4>



<p class="
text-sm
text-red-600
mt-2
">

{{ $terakhir->alasan_tidak_sholat }}

</p>


</div>



@endif






@else


<p class="
text-slate-500
">

Belum ada data angket.

</p>



@endif



</div>

{{-- CATATAN MONITORING --}}


<div class="
bg-indigo-50
border
border-indigo-100
rounded-2xl
p-6
">


<h3 class="
font-bold
text-indigo-800
">

Catatan Monitoring

</h3>




<p class="
text-sm
text-indigo-700
mt-3
">


@if(!$terakhir)


Belum terdapat aktivitas yang dilaporkan.



@elseif(($terakhir->skor ?? 0) >= 80)


Aktivitas siswa dalam kondisi baik dan perlu dipertahankan.



@elseif(($terakhir->skor ?? 0) >= 50)


Aktivitas siswa cukup baik namun masih perlu peningkatan.



@else


Siswa membutuhkan pendampingan lebih lanjut.



@endif



</p>



</div>









{{-- STATISTIK --}}



<div class="
grid
md:grid-cols-3
gap-5
">





<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="
text-sm
text-slate-500
">

Konsistensi Belajar

</p>



<h3 class="
text-3xl
font-bold
text-green-600
mt-2
">

{{ $persentaseBelajar ?? 0 }}%

</h3>



</div>








<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="
text-sm
text-slate-500
">

Kepatuhan Ibadah

</p>



<h3 class="
text-3xl
font-bold
text-blue-600
mt-2
">

{{ $persentaseIbadah ?? 0 }}%

</h3>



</div>








<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="
text-sm
text-slate-500
">

Jumlah Pengisian

</p>



<h3 class="
text-3xl
font-bold
text-purple-600
mt-2
">

{{ $totalAngket ?? 0 }}

Hari

</h3>



</div>





</div>









{{-- GRAFIK --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-lg
mb-5
">

Perkembangan Skor

</h3>





@if($grafikSkor->count() > 1)



<div class="h-80">

<canvas id="scoreChart"></canvas>

</div>




@elseif($grafikSkor->count() == 1)



<div class="
text-center
py-10
">


<p class="
text-sm
text-slate-500
">

Skor Terakhir

</p>



<h2 class="
text-5xl
font-bold
text-indigo-600
mt-3
">

{{ $grafikSkor[0] }}

<span class="
text-xl
text-slate-400
">

/100

</span>


</h2>




<div class="
mt-5
max-w-md
mx-auto
bg-slate-200
rounded-full
h-3
">


<div

class="
bg-indigo-600
h-3
rounded-full
"

style="width: {{ $grafikSkor[0] }}%"

></div>



</div>



</div>




@else


<div class="
text-center
py-10
text-slate-500
">

Belum ada data skor.

</div>



@endif



</div>









{{-- RIWAYAT AKTIVITAS --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-lg
mb-5
">

Riwayat Aktivitas

</h3>





@if($riwayat->count())



<div class="
space-y-5
">



@foreach($riwayat as $item)



<div class="
border
rounded-xl
p-5
">



<div class="
flex
justify-between
items-start
">


<div>


<p class="
font-semibold
">

{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

</p>



<p class="
text-xs
text-slate-400
mt-1
">

Diisi:

{{

$item->tanggal_pengisian

?

\Carbon\Carbon::parse($item->tanggal_pengisian)
->format('d-m-Y H:i')

:

'-'

}}

</p>



</div>




<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-indigo-100
text-indigo-700
">

Skor {{ $item->skor ?? 0 }}

</span>



</div>









<div class="
grid
md:grid-cols-4
gap-4
mt-5
">



<div class="
bg-slate-50
rounded-xl
p-4
">


<p class="
text-xs
text-slate-400
">

Ibadah

</p>


<p class="
font-bold
">


{{

($item->sholat_subuh ?? 0)+
($item->sholat_dzuhur ?? 0)+
($item->sholat_ashar ?? 0)+
($item->sholat_magrib ?? 0)+
($item->sholat_isya ?? 0)

}} / 5


</p>


</div>






<div class="
bg-slate-50
rounded-xl
p-4
">


<p class="
text-xs
text-slate-400
">

Belajar

</p>


<p class="
font-bold
">

{{ $item->belajar ? 'Ya':'Tidak' }}

</p>


</div>







<div class="
bg-slate-50
rounded-xl
p-4
">


<p class="
text-xs
text-slate-400
">

Bangun

</p>


<p class="
font-bold
">

{{ $item->bangun_pagi ?? '-' }}

</p>


</div>







<div class="
bg-slate-50
rounded-xl
p-4
">


<p class="
text-xs
text-slate-400
">

Tidur

</p>


<p class="
font-bold
">

{{ $item->tidur_malam ?? '-' }}

</p>


</div>




</div>








@if($item->kegiatan_membantu)


<div class="
mt-4
bg-slate-50
rounded-xl
p-4
text-sm
">


<b>

Kegiatan Membantu:

</b>


{{ $item->kegiatan_membantu }}


</div>



@endif







@if($item->alasan_tidak_sholat)



<div class="
mt-3
bg-red-50
text-red-700
rounded-xl
p-4
text-sm
">


<b>

Alasan Tidak Sholat:

</b>


{{ $item->alasan_tidak_sholat }}


</div>



@endif




</div>



@endforeach



</div>





@else


<p class="
text-center
text-slate-500
py-8
">

Belum ada riwayat aktivitas.

</p>



@endif



</div>







</div>








@if($grafikSkor->count()>1)


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


document.addEventListener('DOMContentLoaded',function(){


const canvas = document.getElementById('scoreChart');


if(canvas){


new Chart(canvas,{


type:'line',


data:{


labels:@json($grafikTanggal),


datasets:[

{

label:'Skor Aktivitas',

data:@json($grafikSkor),

borderWidth:3,

tension:.4,

pointRadius:5

}

]


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


});


}


});


</script>


@endif





@endsection