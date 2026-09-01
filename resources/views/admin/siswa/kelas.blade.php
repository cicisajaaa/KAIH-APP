@extends('admin.layouts.app')


@section('title','Data Siswa Kelas '.$kelas->nama_kelas)


@section('page-title','Data Siswa')



@section('content')


<div class="space-y-6">



{{-- HEADER --}}

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
gap-4
">


<div>


<h2 class="
text-2xl
font-bold
text-slate-800
">

{{ $kelas->nama_kelas }}

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

{{ $kelas->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}

</p>


</div>





<a href="{{ route('siswa.index') }}"

class="
bg-gray-100
hover:bg-gray-200
text-gray-700
px-5
py-2.5
rounded-xl
font-semibold
text-sm
">

← Kembali

</a>



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
p-5
">


<p class="
text-sm
text-gray-500
">

Total Siswa

</p>


<h3 class="
text-3xl
font-bold
text-indigo-600
mt-2
">

{{ $siswas->total() }}

</h3>


</div>




<div class="
bg-blue-50
border
border-blue-100
rounded-2xl
p-5
">


<p class="
text-sm
text-blue-700
">

Jurusan

</p>


<h3 class="
text-xl
font-bold
text-blue-700
mt-2
">

{{ $kelas->jurusan->nama_jurusan ?? '-' }}

</h3>


</div>





<div class="
bg-green-50
border
border-green-100
rounded-2xl
p-5
">


<p class="
text-sm
text-green-700
">

Status

</p>


<h3 class="
text-xl
font-bold
text-green-700
mt-2
">

Aktif

</h3>


</div>



</div>









{{-- TABLE --}}


<div class="
bg-white
border
rounded-2xl
overflow-hidden
">


<div class="
px-6
py-5
border-b
">


<div class="
flex
justify-between
items-center
">


<div>

<h3 class="
font-bold
text-lg
">

Daftar Siswa

</h3>


<p class="
text-sm
text-gray-500
">

Kelas {{ $kelas->nama_kelas }}

</p>


</div>



</div>


</div>







<div class="overflow-x-auto">


<table class="w-full">


<thead class="bg-slate-50">


<tr>


<th class="
px-6
py-4
text-left
text-xs
uppercase
text-gray-500
">

No

</th>


<th class="
px-6
py-4
text-left
text-xs
uppercase
text-gray-500
">

NIS

</th>


<th class="
px-6
py-4
text-left
text-xs
uppercase
text-gray-500
">

Nama Siswa

</th>



<th class="
px-6
py-4
text-left
text-xs
uppercase
text-gray-500
">

JK

</th>



<th class="
px-6
py-4
text-left
text-xs
uppercase
text-gray-500
">

Orang Tua

</th>



<th class="
px-6
py-4
text-center
text-xs
uppercase
text-gray-500
">

Aksi

</th>


</tr>


</thead>







<tbody class="divide-y">



@forelse($siswas as $siswa)


<tr class="
hover:bg-gray-50
">


<td class="px-6 py-4">

{{ $loop->iteration }}

</td>



<td class="px-6 py-4">

{{ $siswa->nis }}

</td>



<td class="px-6 py-4">


<p class="font-semibold">

{{ $siswa->nama_siswa }}

</p>


</td>




<td class="px-6 py-4">


@if($siswa->jenis_kelamin=='L')


<span class="
px-3
py-1
rounded-full
text-xs
bg-blue-100
text-blue-700
">

Laki-laki

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-pink-100
text-pink-700
">

Perempuan

</span>


@endif


</td>






<td class="px-6 py-4">


@if($siswa->orangTua->count())


{{ $siswa->orangTua->first()->nama_orang_tua }}


@else

-

@endif


</td>







<td class="
px-6
py-4
text-center
">


<a href="{{ route('siswa.edit',$siswa->id) }}"

class="
bg-yellow-500
hover:bg-yellow-600
text-white
px-3
py-2
rounded-lg
text-sm
">

Edit

</a>


</td>


</tr>


@empty


<tr>

<td colspan="6"

class="
text-center
py-10
text-gray-500
">

Belum ada data siswa.

</td>

</tr>


@endforelse



</tbody>


</table>


</div>



<div class="px-6 py-4">


{{ $siswas->links() }}


</div>



</div>





</div>


@endsection