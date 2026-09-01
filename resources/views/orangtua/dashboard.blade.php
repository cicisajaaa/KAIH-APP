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

<h1 class="
text-2xl
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



<a href="{{ route('orangtua.angket.index') }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
text-sm
font-semibold
">

Riwayat Angket

</a>


</div>









{{-- PROFIL SISWA --}}


<div class="
bg-white
rounded-2xl
border
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


<h2 class="
text-xl
font-bold
">

{{ $siswa->nama_siswa }}

</h2>


<p class="text-sm text-slate-500">

NIS :
{{ $siswa->nis }}

</p>


<p class="text-sm text-slate-500">

Kelas :
{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


<p class="text-sm text-slate-500">

Jurusan :
{{ $siswa->kelas->jurusan->nama_jurusan ?? '-' }}

</p>


</div>


</div>


</div>









{{-- STATISTIK UTAMA --}}


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

<p class="text-sm text-slate-500">

Skor Terakhir

</p>


<h2 class="
text-4xl
font-bold
text-indigo-600
mt-3
">

{{ $skorTerakhir }}

<span class="text-lg text-slate-400">
/100
</span>

</h2>


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-slate-500">

Kategori

</p>



@if($kategoriTerakhir == 'Baik')

<span class="
inline-block
mt-3
px-3
py-1
rounded-full
bg-green-100
text-green-700
text-sm
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
bg-yellow-100
text-yellow-700
text-sm
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
bg-red-100
text-red-700
text-sm
font-semibold
">

🔴 Perlu Pendampingan

</span>


@endif


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-slate-500">

Ibadah Hari Ini

</p>


<h2 class="
text-3xl
font-bold
text-blue-600
mt-3
">

{{ $jumlahIbadahHariIni }}/5

</h2>


</div>







<div class="
bg-white
border
rounded-2xl
p-5
">


<p class="text-sm text-slate-500">

Belajar Hari Ini

</p>


<h2 class="
text-3xl
font-bold
text-emerald-600
mt-3
">

{{ $statusBelajarHariIni ? 'Ya':'Tidak' }}

</h2>


</div>



</div>









{{-- STATUS ANGKET --}}


@if(!$angketHariIni)


<div class="
bg-yellow-50
border
border-yellow-200
rounded-2xl
p-5
">


<p class="
font-semibold
text-yellow-700
">

⚠️ Angket hari ini belum diisi.

</p>


<a href="{{ route('orangtua.angket.create') }}"

class="
inline-block
mt-3
bg-indigo-600
text-white
px-5
py-2
rounded-lg
text-sm
">

Isi Angket Sekarang

</a>


</div>


@else


<div class="
bg-green-50
border
border-green-200
rounded-2xl
p-5
">


<p class="
font-semibold
text-green-700
">

✓ Angket hari ini sudah diisi.

</p>


<p class="
text-sm
text-green-600
mt-1
">

Skor hari ini:
{{ $angketHariIni->skor }}/100

</p>


</div>


@endif







{{-- KETERANGAN TIDAK SHOLAT --}}


@if($alasanTidakSholat)


<div class="
bg-red-50
border
border-red-200
rounded-2xl
p-5
">


<h3 class="
font-bold
text-red-700
">

Keterangan Tidak Sholat

</h3>


<p class="
text-sm
text-red-600
mt-2
">

{{ $alasanTidakSholat }}

</p>


</div>


@endif









{{-- RINCIAN SKOR --}}


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

Rincian Penilaian Terakhir

</h3>



<div class="
grid
md:grid-cols-4
gap-4
">


@foreach($rincianSkor as $nama=>$nilai)


<div class="
bg-slate-50
rounded-xl
p-4
">


<p class="
text-xs
text-slate-500
">

{{ $nama }}

</p>


<p class="
text-xl
font-bold
mt-2
{{ $nilai >0 ? 'text-indigo-600':'text-slate-400' }}
">

{{ $nilai }}

</p>


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

<p class="text-sm text-slate-500">
Konsistensi Belajar
</p>


<h2 class="
text-3xl
font-bold
text-green-600
mt-2
">

{{ $persentaseBelajar }}%

</h2>

</div>






<div class="
bg-white
border
rounded-2xl
p-5
">

<p class="text-sm text-slate-500">
Kepatuhan Ibadah
</p>


<h2 class="
text-3xl
font-bold
text-blue-600
mt-2
">

{{ $persentaseIbadah }}%

</h2>

</div>






<div class="
bg-white
border
rounded-2xl
p-5
">

<p class="text-sm text-slate-500">
Total Pengisian
</p>


<h2 class="
text-3xl
font-bold
text-purple-600
mt-2
">

{{ $siswa->angketHarian->count() }}

Hari

</h2>

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
mb-5
">

Grafik Perkembangan 7 Hari

</h3>


<canvas id="perkembanganChart"></canvas>


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

Aktivitas Terakhir

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
font-semibold
">

{{ $item->skor }}/100

</span>


</div>




<p class="text-sm mt-2">

Ibadah:

{{

$item->sholat_subuh+
$item->sholat_dzuhur+
$item->sholat_ashar+
$item->sholat_magrib+
$item->sholat_isya

}}/5

</p>




<p class="text-sm">

Belajar:

{{ $item->belajar ? 'Ya':'Tidak' }}

</p>




<p class="text-sm">

Tidur:

{{ $item->tidur_malam ?? '-' }}

</p>





@if($item->alasan_tidak_sholat)


<p class="
text-sm
text-red-600
mt-2
">

Keterangan:

{{ $item->alasan_tidak_sholat }}

</p>


@endif



</div>




@empty


<p class="text-sm text-slate-500">

Belum ada aktivitas.

</p>


@endforelse



</div>



</div>





</div>







<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


new Chart(
document.getElementById('perkembanganChart'),
{

type:'line',

data:{


labels:@json($grafikTanggal),


datasets:[

{

label:'Skor',

data:@json($grafikSkor),

borderWidth:3,

tension:.3

},


{

label:'Ibadah %',

data:@json($grafikIbadah),

borderWidth:2,

borderDash:[5,5],

tension:.3

}

]


},


options:{

responsive:true,


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