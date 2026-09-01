@extends('admin.layouts.app')


@section('title','Data Orang Tua '.$kelas->nama_kelas)


@section('page-title','Data Orang Tua')



@section('content')


<div class="space-y-8">



{{-- HEADER --}}

<div class="
flex
flex-col
md:flex-row
md:justify-between
md:items-center
gap-5
">


<div>

<h2 class="
text-2xl
font-bold
text-slate-800
">

Data Orang Tua {{ $kelas->nama_kelas }}

</h2>


<p class="
text-slate-500
mt-1
">

Kelola data orang tua siswa kelas {{ $kelas->nama_kelas }}

</p>


</div>




<div class="flex gap-3">


<a href="{{ route('orangtua.index') }}"

class="
bg-gray-100
hover:bg-gray-200
text-gray-700
px-5
py-3
rounded-xl
font-semibold
">

← Kembali

</a>


</div>



</div>









{{-- INFO KELAS --}}


<div class="
bg-white
border
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
text-gray-500
">

Kelas

</p>


<h3 class="
text-xl
font-bold
text-slate-800
">

{{ $kelas->nama_kelas }}

</h3>


<p class="
text-sm
text-gray-500
">

{{ $kelas->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}

</p>


</div>





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


{{ $orangTuas->total() }}


</div>


</div>


</div>









{{-- SEARCH --}}


<div class="
bg-white
border
rounded-2xl
p-6
">


<form method="GET">


<div class="
grid
md:grid-cols-3
gap-4
">





<div>


<label class="
text-sm
font-semibold
text-gray-700
">

Cari Data

</label>


<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Cari nama siswa / orang tua / NIS"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
focus:ring-2
focus:ring-indigo-500
"


>


</div>








<div>


<label class="
text-sm
font-semibold
text-gray-700
">

Hubungan

</label>


<select

name="hubungan"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
"


>


<option value="">

Semua

</option>


<option value="Ayah"

{{ request('hubungan')=='Ayah'?'selected':'' }}

>

Ayah

</option>


<option value="Ibu"

{{ request('hubungan')=='Ibu'?'selected':'' }}

>

Ibu

</option>


<option value="Wali"

{{ request('hubungan')=='Wali'?'selected':'' }}

>

Wali

</option>


</select>


</div>








<div class="
flex
items-end
gap-3
">


<button

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-6
py-3
rounded-xl
font-semibold
">

🔍 Cari

</button>




<a href="{{ route('orangtua.kelas',$kelas->id) }}"

class="
bg-gray-100
hover:bg-gray-200
px-6
py-3
rounded-xl
">

Reset

</a>



</div>


</div>


</form>


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


<h3 class="
font-bold
text-lg
">

Daftar Orang Tua

</h3>


<p class="
text-sm
text-gray-500
">

Total {{ $orangTuas->total() }} data

</p>


</div>









<div class="overflow-x-auto">


<table class="w-full">


<thead class="bg-slate-50">


<tr>


<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

No

</th>



<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Nama Orang Tua

</th>




<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Siswa

</th>




<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

Hubungan

</th>




<th class="px-6 py-4 text-left text-xs uppercase text-gray-500">

No HP

</th>




<th class="px-6 py-4 text-center text-xs uppercase text-gray-500">

Aksi

</th>


</tr>


</thead>









<tbody class="divide-y">



@forelse($orangTuas as $ortu)



<tr class="
hover:bg-gray-50
transition
">



<td class="px-6 py-4">

{{ $orangTuas->firstItem()+$loop->index }}

</td>








<td class="
px-6
py-4
font-semibold
">


{{ $ortu->nama_orang_tua }}


</td>








<td class="px-6 py-4">


<div class="font-medium">

{{ $ortu->siswa->nama_siswa ?? '-' }}

</div>


<div class="text-xs text-gray-400">

NIS {{ $ortu->siswa->nis ?? '-' }}

</div>


</td>








<td class="px-6 py-4">


@if($ortu->hubungan == 'Ayah')


<span class="
px-3
py-1
rounded-full
text-xs
bg-blue-50
text-blue-700
font-semibold
">

Ayah

</span>


@elseif($ortu->hubungan == 'Ibu')


<span class="
px-3
py-1
rounded-full
text-xs
bg-pink-50
text-pink-700
font-semibold
">

Ibu

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-indigo-50
text-indigo-700
font-semibold
">

Wali

</span>


@endif


</td>








<td class="px-6 py-4">


{{ $ortu->no_hp ?? '-' }}


</td>








<td class="px-6 py-4">


<div class="flex justify-center gap-2">


<a href="{{ route('orangtua.edit',$ortu->id) }}"

class="
bg-yellow-500
hover:bg-yellow-600
text-white
px-3
py-2
rounded-lg
text-xs
">

Edit

</a>





<form

action="{{ route('orangtua.destroy',$ortu->id) }}"

method="POST"

onsubmit="return confirm('Hapus data ini?')"

>


@csrf

@method('DELETE')


<button

class="
bg-red-500
hover:bg-red-600
text-white
px-3
py-2
rounded-lg
text-xs
">

Hapus

</button>


</form>


</div>


</td>



</tr>





@empty


<tr>


<td colspan="6"

class="
text-center
py-12
text-gray-500
">


Belum ada data orang tua pada kelas ini.


</td>


</tr>


@endforelse



</tbody>


</table>


</div>








<div class="
px-6
py-5
border-t
">


{{ $orangTuas->links() }}


</div>




</div>






</div>


@endsection