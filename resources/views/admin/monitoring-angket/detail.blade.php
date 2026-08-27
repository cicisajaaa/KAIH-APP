@extends('admin.layouts.app')


@section('title','Detail Monitoring Angket')


@section('page-title','Detail Aktivitas Siswa')



@section('content')


<div class="space-y-6">





{{-- HEADER SISWA --}}


<div class="bg-white border rounded-2xl shadow-sm p-6">


<div class="flex justify-between items-start">


<div class="flex items-center gap-5">



<div class="
w-16
h-16
rounded-2xl
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
text-2xl
font-bold
">


{{ strtoupper(substr($siswa->nama_siswa,0,1)) }}


</div>





<div>


<h2 class="text-2xl font-bold text-gray-800">

{{ $siswa->nama_siswa }}

</h2>


<p class="text-gray-500">

NIS : {{ $siswa->nis }}

</p>


<p class="text-gray-500">

Kelas :

{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


</div>



</div>







<a href="{{ route('monitoring.angket') }}"

class="
bg-gray-600
hover:bg-gray-700
text-white
px-5
py-3
rounded-xl
text-sm
">


← Kembali


</a>



</div>




</div>









{{-- DATA ORANG TUA --}}


<div class="grid md:grid-cols-3 gap-5">



<div class="bg-white border rounded-2xl p-5">


<p class="text-sm text-gray-500">

Orang Tua

</p>


<h3 class="font-bold text-gray-800 mt-2">


{{

$siswa->orangTua->first()->nama_orang_tua ?? '-'

}}


</h3>


</div>







<div class="bg-white border rounded-2xl p-5">


<p class="text-sm text-gray-500">

Total Pengisian

</p>


<h3 class="text-3xl font-bold text-indigo-600 mt-2">


{{

$siswa->angketHarian->count()

}}


</h3>


</div>







<div class="bg-white border rounded-2xl p-5">


<p class="text-sm text-gray-500">

Status Monitoring

</p>


<h3 class="text-xl font-bold text-green-600 mt-2">

Aktif

</h3>


</div>



</div>









{{-- RINGKASAN --}}


@php


$totalAngket = $siswa->angketHarian->count();


$totalBelajar = $siswa->angketHarian
    ->where('belajar',true)
    ->count();



$rataIbadah = 0;



if($totalAngket > 0)
{

    $jumlah = 0;


    foreach($siswa->angketHarian as $item)
    {


        $jumlah +=

        $item->sholat_subuh +

        $item->sholat_dzuhur +

        $item->sholat_ashar +

        $item->sholat_magrib +

        $item->sholat_isya;


    }


    $rataIbadah = round(
        ($jumlah / ($totalAngket * 5)) * 100
    );

}



@endphp







<div class="grid md:grid-cols-3 gap-5">



<div class="
bg-green-50
border
border-green-100
rounded-2xl
p-5
">


<p class="text-sm text-green-700">

Konsistensi Belajar

</p>


<h3 class="text-3xl font-bold text-green-700 mt-2">

{{ $totalAngket > 0 ? round(($totalBelajar/$totalAngket)*100):0 }}%

</h3>


</div>







<div class="
bg-blue-50
border
border-blue-100
rounded-2xl
p-5
">


<p class="text-sm text-blue-700">

Kepatuhan Ibadah

</p>


<h3 class="text-3xl font-bold text-blue-700 mt-2">

{{ $rataIbadah }}%

</h3>


</div>







<div class="
bg-purple-50
border
border-purple-100
rounded-2xl
p-5
">


<p class="text-sm text-purple-700">

Total Hari Terdata

</p>


<h3 class="text-3xl font-bold text-purple-700 mt-2">

{{ $totalAngket }}

</h3>


</div>



</div>









{{-- TIMELINE --}}


<div class="bg-white border rounded-2xl p-6">


<h3 class="text-xl font-bold text-gray-800 mb-6">

Riwayat Aktivitas

</h3>





@if($siswa->angketHarian->count())



<div class="space-y-5">





@foreach($siswa->angketHarian as $item)



@php


$ibadah =

$item->sholat_subuh +

$item->sholat_dzuhur +

$item->sholat_ashar +

$item->sholat_magrib +

$item->sholat_isya;


@endphp





<div class="
border
rounded-2xl
p-5
hover:shadow-md
transition
">





<div class="flex justify-between">


<div>


<h4 class="font-bold text-gray-800">


{{

\Carbon\Carbon::parse(
$item->tanggal
)->format('d F Y')

}}


</h4>


<p class="text-xs text-gray-400">

Diisi:

{{

\Carbon\Carbon::parse(
$item->tanggal_pengisian
)->format('d-m-Y H:i')

}}

</p>


</div>






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

⚠ Telat

</span>


@endif



</div>







<div class="grid md:grid-cols-4 gap-4 mt-5">



<div class="bg-gray-50 rounded-xl p-4">

<p class="text-xs text-gray-500">

Ibadah

</p>


<p class="text-xl font-bold">

{{ $ibadah }}/5

</p>

</div>






<div class="bg-gray-50 rounded-xl p-4">

<p class="text-xs text-gray-500">

Belajar

</p>


<p class="text-xl font-bold">

{{ $item->belajar?'Ya':'Tidak' }}

</p>

</div>






<div class="bg-gray-50 rounded-xl p-4">

<p class="text-xs text-gray-500">

Bangun

</p>


<p class="text-xl font-bold">

{{ $item->bangun_pagi ?? '-' }}

</p>

</div>






<div class="bg-gray-50 rounded-xl p-4">

<p class="text-xs text-gray-500">

Tidur

</p>


<p class="text-xl font-bold">

{{ $item->tidur_malam ?? '-' }}

</p>

</div>



</div>









@if($item->kegiatan_membantu)


<div class="mt-5">


<p class="text-sm text-gray-500">

Kegiatan Membantu

</p>


<div class="
mt-2
bg-indigo-50
text-indigo-700
rounded-xl
p-4
">


{{ $item->kegiatan_membantu }}


</div>



</div>


@endif





</div>




@endforeach



</div>




@else


<div class="text-center py-10 text-gray-500">

Belum ada data aktivitas.

</div>


@endif



</div>






</div>



@endsection