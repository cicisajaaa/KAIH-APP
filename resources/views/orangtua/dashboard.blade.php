@extends('layouts.orangtua')


@section('title','Dashboard Orang Tua')


@section('page-title')
Dashboard
@endsection



@section('content')


<div class="space-y-6">





{{-- IDENTITAS --}}


<div class="bg-white border rounded-xl p-6">


<div class="flex justify-between items-start">


<div>


<p class="text-sm text-gray-500">

Selamat datang

</p>


<h2 class="text-xl font-semibold text-gray-800 mt-1">

{{ auth()->user()->name }}

</h2>



<p class="text-sm text-gray-500 mt-2">

Berikut informasi aktivitas harian anak

</p>


</div>




<div class="text-right">


<p class="text-xs text-gray-400">

Tanggal

</p>


<p class="font-medium text-gray-700">

{{ now()->format('d M Y') }}

</p>


</div>



</div>


</div>









{{-- DATA ANAK --}}


<div class="bg-white border rounded-xl p-6">



<h3 class="font-semibold text-gray-800 mb-5">

Data Siswa

</h3>




@if($orangTua->siswa)



<div class="grid md:grid-cols-4 gap-5">



<div>

<p class="text-xs text-gray-400">

Nama

</p>

<p class="mt-1 font-medium">

{{ $orangTua->siswa->nama_siswa }}

</p>

</div>





<div>

<p class="text-xs text-gray-400">

NIS

</p>

<p class="mt-1 font-medium">

{{ $orangTua->siswa->nis }}

</p>

</div>





<div>

<p class="text-xs text-gray-400">

Kelas

</p>

<p class="mt-1 font-medium">

{{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}

</p>

</div>





<div>

<p class="text-xs text-gray-400">

Jurusan

</p>

<p class="mt-1 font-medium">

{{ $orangTua->siswa->kelas->jurusan->nama_jurusan ?? '-' }}

</p>

</div>



</div>



@endif



</div>









{{-- STATUS HARI INI --}}


<div class="bg-white border rounded-xl p-6">


<div class="flex justify-between items-center mb-5">


<h3 class="font-semibold text-gray-800">

Aktivitas Hari Ini

</h3>



@if($angketHariIni)

<span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">

Sudah diisi

</span>


@else

<span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

Belum diisi

</span>


@endif



</div>






<div class="grid md:grid-cols-3 gap-5">



<div class="border rounded-lg p-4">


<p class="text-sm text-gray-500">

Ibadah

</p>



<h3 class="text-2xl font-semibold mt-2">


@if($angketHariIni)

{{ 
$angketHariIni->sholat_subuh +
$angketHariIni->sholat_dzuhur +
$angketHariIni->sholat_ashar +
$angketHariIni->sholat_magrib +
$angketHariIni->sholat_isya
}}

/5


@else

0/5


@endif


</h3>


</div>







<div class="border rounded-lg p-4">


<p class="text-sm text-gray-500">

Belajar

</p>



<h3 class="text-2xl font-semibold mt-2">


@if($angketHariIni)

{{

$angketHariIni->belajar
?
'Ya'
:
'Tidak'

}}


@else

-

@endif


</h3>


</div>







<div class="border rounded-lg p-4">


<p class="text-sm text-gray-500">

Tidur

</p>



<h3 class="text-2xl font-semibold mt-2">


@if($angketHariIni)

{{

$angketHariIni->tidur_malam ?? '-'

}}


@else

-

@endif


</h3>


</div>




</div>



</div>









{{-- GRAFIK --}}



<div class="bg-white border rounded-xl p-5">


<div class="flex justify-between items-center mb-4">


<div>


<h3 class="font-semibold text-gray-800">

Aktivitas Mingguan

</h3>


<p class="text-xs text-gray-400 mt-1">

Perkembangan pengisian angket 7 hari terakhir

</p>


</div>



</div>





<div class="h-52">


<canvas id="perkembanganChart"></canvas>


</div>



</div>









{{-- TOMBOL --}}



@if(!$angketHariIni)


<div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5">


<h4 class="font-medium text-indigo-700">

Angket hari ini belum diisi

</h4>


<p class="text-sm text-indigo-600 mt-1">

Silakan isi aktivitas anak untuk memperbarui data monitoring.

</p>



<a href="{{ route('orangtua.angket.create') }}"

class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm">


Isi Angket


</a>


</div>


@endif







</div>








<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


const ctx = document.getElementById('perkembanganChart');



new Chart(ctx,{


type:'line',


data:{


labels:@json($grafikTanggal),


datasets:[


{

label:'Belajar',

data:@json($grafikBelajar),

borderWidth:2,

tension:.3,

pointRadius:3,

fill:false


},



{

label:'Ibadah',

data:@json($grafikIbadah),

borderWidth:2,

tension:.3,

pointRadius:3,

fill:false


}


]


},



options:{


responsive:true,

maintainAspectRatio:false,


plugins:{


legend:{


position:'bottom',

labels:{


font:{


size:11

}


}


}


},



scales:{


y:{


beginAtZero:true,

max:100,

ticks:{


stepSize:20,

font:{


size:10

}

}

},


x:{


ticks:{


font:{


size:10

}

}

}


}


}


});



</script>



@endsection