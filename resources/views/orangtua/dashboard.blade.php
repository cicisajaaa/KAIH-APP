@extends('layouts.orangtua')


@section('title','Dashboard Orang Tua')


@section('page-title','Dashboard Orang Tua')



@section('content')



<div class="space-y-6">





{{-- HEADER --}}


<div class="
bg-white
rounded-2xl
border
p-6
">


<div class="flex justify-between items-center">


<div>


<h1 class="
text-xl
font-bold
text-slate-800
">

Dashboard Orang Tua

</h1>


<p class="
text-sm
text-slate-500
mt-1
">

Selamat datang,
{{ auth()->user()->name }}

</p>


</div>




</div>


</div>









{{-- DATA ANAK --}}


<div class="
bg-white
rounded-2xl
border
p-6
">


<div class="
flex
items-center
gap-4
">



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


<h2 class="
font-bold
text-lg
">

{{ $siswa->nama_siswa }}

</h2>


<p class="
text-sm
text-slate-500
">

NIS : {{ $siswa->nis }}

</p>


<p class="
text-sm
text-slate-500
">

Kelas :
{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


</div>



</div>



</div>









{{-- STATUS HARI INI --}}


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

Status Angket Hari Ini

</p>




@if($angketHariIni)


<span class="
inline-block
mt-3
px-3
py-1
rounded-full
text-xs
font-semibold
bg-emerald-100
text-emerald-700
">

✓ Sudah Diisi

</span>


@else


<span class="
inline-block
mt-3
px-3
py-1
rounded-full
text-xs
font-semibold
bg-yellow-100
text-yellow-700
">

Belum Diisi

</span>


@endif



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

Skor Anak

</p>


<h2 class="
text-3xl
font-bold
text-indigo-600
mt-3
">

{{ $skorTerakhir ?? 0 }}

</h2>


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

Kategori

</p>


<h2 class="
font-bold
mt-3
">


@if(($kategoriTerakhir ?? '') == 'Baik')


<span class="text-emerald-600">

🟢 Baik

</span>


@elseif(($kategoriTerakhir ?? '') == 'Perlu Perhatian')


<span class="text-yellow-600">

🟡 Perlu Perhatian

</span>


@else


<span class="text-slate-600">

{{ $kategoriTerakhir ?? '-' }}

</span>


@endif



</h2>


</div>




</div>




{{-- RINCIAN SKOR --}}

<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-slate-800
mb-4
">

Rincian Penilaian Terakhir

</h3>



<div class="space-y-3">


@foreach($rincianSkor as $nama=>$nilai)


<div class="
flex
justify-between
items-center
bg-slate-50
rounded-xl
px-4
py-3
">


<span class="text-sm text-slate-700">

{{ $nama }}

</span>


@if($nilai > 0)

<span class="
text-emerald-600
font-semibold
">

✓ +{{ $nilai }}

</span>


@else


<span class="
text-slate-400
font-semibold
">

- 0

</span>


@endif


</div>


@endforeach



</div>


</div>




{{-- PERKEMBANGAN --}}


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


<h2 class="
text-2xl
font-bold
text-emerald-600
mt-2
">

{{ $persentaseBelajar ?? 0 }}%

</h2>


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


<h2 class="
text-2xl
font-bold
text-blue-600
mt-2
">

{{ $persentaseIbadah ?? 0 }}%

</h2>


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

Hari Terpantau

</p>


<h2 class="
text-2xl
font-bold
text-purple-600
mt-2
">

{{ $siswa->angketHarian->count() }}

</h2>


</div>



</div>









{{-- BUTTON ANGKET --}}



@if(!$angketHariIni)


<a href="{{ route('orangtua.angket.create') }}"

class="
block
text-center
bg-indigo-600
hover:bg-indigo-700
text-white
rounded-xl
py-3
font-semibold
">


+ Isi Angket Hari Ini


</a>



@endif









{{-- GRAFIK --}}


<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-slate-800
mb-5
">

Perkembangan Skor Aktivitas 7 Hari

</h3>



<canvas id="perkembanganChart"></canvas>



</div>









{{-- RIWAYAT TERBARU --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
text-slate-800
mb-5
">

Aktivitas Terbaru

</h3>





<div class="space-y-4">



@forelse($riwayatTerbaru as $item)



<div class="
border-l-4
border-indigo-400
pl-4
">


<div class="
flex
justify-between
">


<p class="
font-semibold
text-sm
">

{{

\Carbon\Carbon::parse($item->tanggal)
->format('d M Y')

}}

</p>



<p class="
text-xs
text-slate-500
">

{{ $item->belajar ? 'Belajar' : 'Tidak belajar' }}

</p>


</div>





<p class="
text-sm
text-slate-500
mt-2
">

Ibadah :

{{

$item->sholat_subuh +
$item->sholat_dzuhur +
$item->sholat_ashar +
$item->sholat_magrib +
$item->sholat_isya

}} / 5

</p>



</div>



@empty


<p class="
text-sm
text-slate-500
">

Belum ada aktivitas.

</p>


@endforelse



</div>


</div>






</div>





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


const chart = document.getElementById(
    'perkembanganChart'
);


if(chart)
{


    new Chart(chart, {


        type:'line',


        data:{


            labels:@json($grafikTanggal ?? []),



            datasets:[


                {


                    label:'Skor Aktivitas',


                    data:@json($grafikSkor ?? []),


                    borderWidth:3,


                    tension:0.3



                },



                {


                 
                    label:'Ibadah (%)',

                    data:@json($grafikIbadah ?? []),

                    borderWidth:1,

                    borderDash:[5,5],

                    tension:0.3
                



                }



            ]



        },



        options:{


            responsive:true,


            plugins:{


                legend:{


                    position:'top'


                }


            },


            scales:{


                y:{


                    beginAtZero:true,


                    max:100


                }


            }



        }



    });


}



</script>



@endsection