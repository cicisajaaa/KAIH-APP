@extends('layouts.orangtua')


@section('title','Data Anak')


@section('page-title','Data Anak')



@section('content')


<div class="space-y-6">





{{-- HEADER --}}


<div class="
bg-white
border
rounded-2xl
p-6
">


<h2 class="
text-xl
font-bold
text-slate-800
">

Data Anak

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Informasi lengkap data siswa yang terhubung dengan akun orang tua.

</p>


</div>









{{-- PROFIL SISWA --}}



<div class="
bg-white
border
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
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
text-2xl
font-bold
">


{{ strtoupper(substr(
$orangTua->siswa->nama_siswa ?? '-',
0,
1
)) }}


</div>






<div>


<h3 class="
text-xl
font-bold
text-slate-800
">

{{ $orangTua->siswa->nama_siswa ?? '-' }}

</h3>


<p class="
text-sm
text-slate-500
">

NIS :
{{ $orangTua->siswa->nis ?? '-' }}

</p>


</div>





</div>



</div>









{{-- DATA SISWA --}}


<div class="
grid
md:grid-cols-2
gap-5
">





<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-semibold
text-slate-800
mb-4
">

Informasi Siswa

</h3>






<div class="space-y-3">



<div class="
flex
justify-between
text-sm
">

<span class="text-slate-500">

Jenis Kelamin

</span>


<span class="font-medium">

{{ $orangTua->siswa->jenis_kelamin ?? '-' }}

</span>


</div>








<div class="
flex
justify-between
text-sm
">

<span class="text-slate-500">

Kelas

</span>


<span class="font-medium">

{{ 
$orangTua->siswa->kelas->nama_kelas ?? '-'
}}

</span>


</div>








<div class="
flex
justify-between
text-sm
">

<span class="text-slate-500">

Jurusan

</span>


<span class="font-medium">

{{ 
$orangTua->siswa->kelas->jurusan->nama_jurusan ?? '-'
}}

</span>


</div>






</div>


</div>









{{-- DATA ORANG TUA --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<h3 class="
font-semibold
text-slate-800
mb-4
">

Informasi Orang Tua

</h3>






<div class="space-y-3">



<div class="
flex
justify-between
text-sm
">


<span class="text-slate-500">

Nama

</span>


<span class="font-medium">

{{ $orangTua->nama_orang_tua }}

</span>


</div>








<div class="
flex
justify-between
text-sm
">


<span class="text-slate-500">

Hubungan

</span>


<span class="font-medium">

{{ $orangTua->hubungan }}

</span>


</div>








<div class="
flex
justify-between
text-sm
">


<span class="text-slate-500">

No HP

</span>


<span class="font-medium">

{{ $orangTua->no_hp ?? '-' }}

</span>


</div>






<div class="
flex
justify-between
text-sm
">


<span class="text-slate-500">

Pekerjaan

</span>


<span class="font-medium">

{{ $orangTua->pekerjaan ?? '-' }}

</span>


</div>






</div>



</div>





</div>









{{-- RINGKASAN AKTIVITAS --}}



<div class="
bg-white
border
rounded-2xl
p-6
">



<h3 class="
font-semibold
text-slate-800
mb-5
">

Ringkasan Aktivitas

</h3>





<div class="
grid
md:grid-cols-3
gap-4
">





<div class="
bg-indigo-50
rounded-xl
p-4
">


<p class="
text-xs
text-indigo-600
">

Total Angket

</p>


<h3 class="
text-2xl
font-bold
text-indigo-700
mt-2
">


{{
$orangTua->siswa->angketHarian->count()
}}

</h3>


</div>







<div class="
bg-emerald-50
rounded-xl
p-4
">


<p class="
text-xs
text-emerald-600
">

Status

</p>


<h3 class="
text-lg
font-bold
text-emerald-700
mt-2
">

Aktif

</h3>


</div>







<div class="
bg-purple-50
rounded-xl
p-4
">


<p class="
text-xs
text-purple-600
">

Monitoring

</p>


<h3 class="
text-lg
font-bold
text-purple-700
mt-2
">

KAIH

</h3>


</div>





</div>


</div>







</div>


@endsection