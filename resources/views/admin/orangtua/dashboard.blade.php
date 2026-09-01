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

Selamat Datang,
{{ auth()->user()->name }}

</h2>


<p class="
text-slate-500
mt-1
">

Monitoring perkembangan anak secara harian.

</p>


</div>




<a href="{{ route('orangtua.angket.create') }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
font-semibold
">

+ Isi Angket

</a>


</div>









{{-- DATA ANAK --}}


<div class="
bg-indigo-50
border
border-indigo-100
rounded-2xl
p-6
">


<div class="
flex
items-center
gap-5
">


<div class="
w-16
h-16
rounded-2xl
bg-indigo-600
text-white
flex
items-center
justify-center
text-2xl
font-bold
">


{{ strtoupper(substr($siswa->nama_siswa,0,1)) }}


</div>





<div>


<h2 class="
text-xl
font-bold
text-indigo-900
">

{{ $siswa->nama_siswa }}

</h2>


<p class="
text-indigo-700
">

NIS:
{{ $siswa->nis }}

</p>


<p class="
text-indigo-700
">

Kelas:
{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


<p class="
text-indigo-700
">

Jurusan:
{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}

</p>


</div>



</div>


</div>









{{-- STATUS HARI INI --}}


<div class="
grid
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

Status Angket Hari Ini

</p>


<h3 class="
font-bold
text-indigo-600
mt-3
">

{{ $statusAngketHariIni }}

</h3>


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-gray-500">

Ibadah Hari Ini

</p>


<h3 class="
text-3xl
font-bold
text-green-600
mt-2
">

{{ $jumlahIbadahHariIni }}/5

</h3>


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-gray-500">

Belajar Hari Ini

</p>


<h3 class="
font-bold
mt-3
{{ $statusBelajarHariIni ? 'text-green-600':'text-red-600' }}
">

{{ $statusBelajarHariIni ? 'Sudah':'Belum' }}

</h3>


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-gray-500">

Kategori Anak

</p>


<h3 class="
font-bold
mt-3
text-indigo-600
">

{{ $kategoriTerakhir }}

</h3>


</div>




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
p-6
">


<p class="text-sm text-gray-500">

Skor Terakhir

</p>


<h3 class="
text-5xl
font-bold
text-indigo-600
mt-3
">

{{ $skorTerakhir }}

<span class="text-xl text-gray-400">
/100
</span>

</h3>


</div>







<div class="
bg-white
border
rounded-2xl
p-6
">


<p class="text-sm text-gray-500">

Konsistensi Belajar

</p>


<h3 class="
text-4xl
font-bold
text-green-600
mt-3
">

{{ $persentaseBelajar }}%

</h3>


</div>







<div class="
bg-white
border
rounded-2xl
p-6
">


<p class="text-sm text-gray-500">

Kepatuhan Ibadah

</p>


<h3 class="
text-4xl
font-bold
text-blue-600
mt-3
">

{{ $persentaseIbadah }}%

</h3>


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
text-lg
mb-5
">

Rincian Aktivitas Terakhir

</h3>




<div class="
grid
md:grid-cols-4
gap-4
">


@foreach($rincianSkor as $nama=>$nilai)


<div class="
bg-gray-50
rounded-xl
p-4
">


<p class="
text-sm
text-gray-500
">

{{ $nama }}

</p>


<p class="
text-2xl
font-bold
text-indigo-600
mt-2
">

{{ $nilai }}

</p>


</div>


@endforeach



</div>


</div>









{{-- CATATAN IBADAH --}}


@if($alasanTidakSholat)


<div class="
bg-red-50
border
border-red-100
rounded-2xl
p-5
">


<h3 class="
font-bold
text-red-700
">

Catatan Ibadah

</h3>


<p class="
text-red-600
mt-2
">

{{ $alasanTidakSholat }}

</p>


</div>


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
mb-5
">

Perkembangan 7 Hari

</h3>



<div class="h-80">


<canvas id="chart"></canvas>


</div>


</div>









{{-- RIWAYAT --}}


<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-bold
mb-5
">

Riwayat Terakhir

</h3>



<div class="space-y-4">


@forelse($riwayatTerbaru as $item)


<div class="
border
rounded-xl
p-4
">


<div class="
flex
justify-between
">


<b>

{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}

</b>



<span class="
text-indigo-600
font-bold
">

Skor {{ $item->skor }}

</span>


</div>





<p class="text-sm mt-2">

Kategori:

{{ $item->kategori }}

</p>


<p class="text-sm">

Belajar:

{{ $item->belajar ? 'Ya':'Tidak' }}

</p>


</div>



@empty


<p class="text-gray-500">

Belum ada riwayat.

</p>


@endforelse



</div>



</div>







</div>








<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


new Chart(
document.getElementById('chart'),
{

type:'line',

data:{


labels:@json($grafikTanggal),


datasets:[

{

label:'Skor',

data:@json($grafikSkor),

borderWidth:3,

tension:.4

},


{

label:'Ibadah (%)',

data:@json($grafikIbadah),

borderWidth:3,

tension:.4

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


}

);



</script>



@endsection