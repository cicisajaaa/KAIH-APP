@extends('admin.layouts.app')


@section('title','Data Orang Tua')


@section('page-title','Data Orang Tua')



@section('content')


<div class="space-y-8">



{{-- HEADER --}}

<div class="
flex
flex-col
lg:flex-row
lg:justify-between
lg:items-center
gap-5
">


<div>

<h2 class="
text-2xl
font-bold
text-slate-800
">

Data Orang Tua

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Kelola informasi orang tua dan wali siswa.

</p>


</div>





<a href="{{ route('orangtua.create') }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
font-semibold
transition
shadow-sm
">

+ Tambah Orang Tua

</a>


</div>








{{-- KELAS --}}


<div>


<div class="mb-4">

<h3 class="
text-lg
font-bold
text-slate-800
">

Data Berdasarkan Kelas

</h3>


<p class="
text-sm
text-slate-500
">

Pilih kelas untuk melihat daftar orang tua siswa.

</p>


</div>







<div class="
grid
grid-cols-1
sm:grid-cols-2
lg:grid-cols-4
gap-4
">


@foreach($kelas as $item)


<a href="{{ route('orangtua.kelas',$item->id) }}"

class="
bg-white
border
rounded-2xl
p-5
hover:border-indigo-500
hover:shadow-md
transition
">


<div class="
flex
justify-between
items-center
">


<div>


<h4 class="
font-bold
text-slate-800
">

{{ $item->nama_kelas }}

</h4>



<p class="
text-sm
text-slate-500
mt-1
">

{{ $item->jurusan->nama_jurusan ?? 'Tanpa Jurusan' }}

</p>


</div>





<div class="
w-12
h-12
rounded-xl
bg-indigo-50
text-indigo-600
flex
items-center
justify-center
font-bold
">

{{ $item->siswas_count }}

</div>



</div>




<p class="
text-xs
text-slate-400
mt-4
">

Jumlah Siswa

</p>



</a>



@endforeach



</div>


</div>









{{-- IMPORT --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<div class="
flex
flex-col
lg:flex-row
lg:justify-between
lg:items-center
gap-5
">


<div>


<h3 class="
font-bold
text-slate-800
">

Import Data Orang Tua

</h3>


<p class="
text-sm
text-slate-500
mt-1
">

Upload file Excel data orang tua.

</p>


</div>







<form

action="{{ route('orangtua.import') }}"

method="POST"

enctype="multipart/form-data"

class="
flex
flex-col
sm:flex-row
gap-3
">


@csrf



<input

type="file"

name="file"

accept=".xlsx,.xls"

required

class="
border
rounded-xl
px-4
py-2
text-sm
bg-white
"

>



<button

class="
bg-emerald-600
hover:bg-emerald-700
text-white
px-5
py-2
rounded-xl
font-semibold
">

Import Excel

</button>



</form>


</div>


</div>










{{-- FILTER --}}



<div class="
bg-white
border
rounded-2xl
p-6
">


<form method="GET">


<div class="
grid
md:grid-cols-4
gap-4
">



<div>


<label class="
text-sm
font-semibold
text-slate-700
">

Pencarian

</label>


<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Nama orang tua / siswa / NIS"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
"

>


</div>







<div>


<label class="
text-sm
font-semibold
text-slate-700
">

Kelas

</label>


<select

name="kelas_id"

class="
w-full
mt-2
border
rounded-xl
px-4
py-3
">


<option value="">

Semua Kelas

</option>


@foreach($kelas as $item)


<option

value="{{ $item->id }}"

{{ request('kelas_id')==$item->id?'selected':'' }}

>

{{ $item->nama_kelas }}

</option>


@endforeach


</select>


</div>







<div>


<label class="
text-sm
font-semibold
text-slate-700
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
">


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

Cari

</button>




<a href="{{ route('orangtua.index') }}"

class="
bg-slate-100
hover:bg-slate-200
text-slate-700
px-6
py-3
rounded-xl
font-semibold
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
text-slate-800
">

Daftar Orang Tua

</h3>


<p class="
text-sm
text-slate-500
mt-1
">

Total {{ $orangTuas->total() }} data

</p>


</div>







<div class="overflow-x-auto">


<table class="w-full">



<thead class="bg-slate-50">


<tr>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
No
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Nama Orang Tua
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Siswa
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Kelas
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Hubungan
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
No HP
</th>


<th class="px-6 py-4 text-center text-xs uppercase text-slate-500">
Aksi
</th>


</tr>


</thead>







<tbody class="divide-y">


@forelse($orangTuas as $ortu)


<tr class="hover:bg-slate-50">


<td class="px-6 py-4">

{{ $orangTuas->firstItem()+$loop->index }}

</td>



<td class="px-6 py-4">


<p class="font-semibold text-slate-800">

{{ $ortu->nama_orang_tua }}

</p>


</td>




<td class="px-6 py-4">


<p class="font-medium">

{{ $ortu->siswa->nama_siswa ?? '-' }}

</p>


<span class="text-xs text-slate-400">

NIS {{ $ortu->siswa->nis ?? '-' }}

</span>


</td>




<td class="px-6 py-4">

{{ $ortu->siswa->kelas->nama_kelas ?? '-' }}

</td>





<td class="px-6 py-4">


<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-indigo-50
text-indigo-700
">

{{ $ortu->hubungan }}

</span>


</td>





<td class="px-6 py-4">

{{ $ortu->no_hp ?? '-' }}

</td>






<td class="px-6 py-4">


<div class="
flex
justify-center
gap-2
">


<a href="{{ route('orangtua.edit',$ortu->id) }}"

class="
bg-amber-500
hover:bg-amber-600
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

<td colspan="7"

class="
text-center
py-12
text-slate-500
">

Belum ada data orang tua.

</td>


</tr>


@endforelse


</tbody>


</table>


</div>







<div class="px-6 py-5 border-t">


{{ $orangTuas->links() }}


</div>




</div>





</div>


@endsection