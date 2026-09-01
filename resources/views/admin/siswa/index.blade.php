@extends('admin.layouts.app')


@section('title','Data Siswa')


@section('page-title','Data Siswa')



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

Data Siswa

</h2>


<p class="
text-slate-500
mt-1
">

Kelola data siswa, kelas, dan akun orang tua.

</p>


</div>





<div class="
flex
flex-wrap
gap-3
">


<a href="{{ route('admin.generate.orangtua') }}"

onclick="return confirm('Generate akun orang tua untuk seluruh siswa?')"

class="
bg-purple-600
hover:bg-purple-700
text-white
px-5
py-3
rounded-xl
font-semibold
transition
">


👨‍👩‍👧 Generate Akun


</a>





<a href="{{ route('siswa.export') }}"

class="
bg-emerald-600
hover:bg-emerald-700
text-white
px-5
py-3
rounded-xl
font-semibold
transition
">

📤 Export


</a>





<a href="{{ route('siswa.create') }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
font-semibold
transition
">

+ Tambah Siswa


</a>



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
xl:flex-row
xl:justify-between
xl:items-center
gap-5
">


<div>


<h3 class="
font-semibold
text-slate-800
">

Import Data Siswa

</h3>


<p class="
text-sm
text-slate-500
mt-1
">

Upload file Excel siswa berdasarkan sheet kelas.

</p>


</div>







<form

action="{{ route('siswa.import') }}"

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
"


>



<button

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-2
rounded-xl
font-semibold
">

📥 Import Excel


</button>



</form>


</div>


</div>





{{-- DAFTAR KELAS --}}

<div class="space-y-4">


<div>

<h3 class="
text-lg
font-bold
text-slate-800
">

Daftar Kelas

</h3>


<p class="
text-sm
text-slate-500
">

Pilih kelas untuk melihat data siswa.

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


<a href="{{ route('siswa.kelas',$item->id) }}"

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
text-gray-400
mt-4
">

Jumlah Siswa

</p>



</a>



@endforeach


</div>


</div>



{{-- FILTER --}}


<div class="
bg-white
border
rounded-2xl
p-6
">


<form method="GET" action="{{ route('siswa.index') }}">


<div class="
grid
md:grid-cols-3
gap-4
">





<div>


<label class="
text-sm
font-semibold
text-slate-700
">

Cari Siswa

</label>


<input

type="text"

name="search"

value="{{ request('search') }}"

placeholder="Cari NIS atau nama siswa"

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
"


>


<option value="">

Semua Kelas

</option>



@foreach($kelas as $item)

<option

value="{{ $item->id }}"

{{ request('kelas_id')==$item->id?'selected':'' }}

>

{{ $item->nama_kelas }}

({{ $item->siswas_count }})

</option>


@endforeach


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




<a href="{{ route('siswa.index') }}"

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

Daftar Siswa

</h3>


<p class="
text-sm
text-slate-500
">

Total {{ $siswas->total() }} siswa

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
NIS
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Nama
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
JK
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Kelas
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Status Akun
</th>


<th class="px-6 py-4 text-center text-xs uppercase text-slate-500">
Aksi
</th>


</tr>


</thead>








<tbody class="divide-y">



@forelse($siswas as $siswa)



<tr class="
hover:bg-slate-50
transition
">





<td class="px-6 py-4">


{{ $siswas->firstItem()+$loop->index }}


</td>






<td class="px-6 py-4 font-medium">


{{ $siswa->nis }}


</td>







<td class="px-6 py-4">


<p class="font-semibold">

{{ $siswa->nama_siswa }}

</p>


<p class="text-xs text-gray-400">

{{ $siswa->kelas->nama_kelas ?? '-' }}

</p>


</td>








<td class="px-6 py-4">


@if($siswa->jenis_kelamin=='L')


<span class="
px-3
py-1
rounded-full
text-xs
bg-blue-50
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
bg-pink-50
text-pink-700
">

Perempuan

</span>


@endif


</td>








<td class="px-6 py-4">


<span class="
px-3
py-1
rounded-full
text-xs
bg-indigo-50
text-indigo-700
">


{{ $siswa->kelas->nama_kelas ?? '-' }}


</span>


</td>








<td class="px-6 py-4">


@if($siswa->orangTua->contains(function($ortu){

return $ortu->user;

}))


<span class="
px-3
py-1
rounded-full
text-xs
bg-green-50
text-green-700
font-semibold
">

✓ Aktif

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-yellow-50
text-yellow-700
font-semibold
">

Belum Ada

</span>


@endif


</td>





<td class="px-6 py-4">


<div class="
flex
justify-center
gap-2
flex-wrap
">


<a href="{{ route('siswa.edit',$siswa->id) }}"

class="
bg-yellow-500
hover:bg-yellow-600
text-white
px-3
py-2
rounded-lg
text-xs
font-semibold
">

Edit

</a>





<a href="{{ route('siswa.kelas',$siswa->kelas_id) }}"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-3
py-2
rounded-lg
text-xs
font-semibold
">

Lihat Kelas

</a>







<form

action="{{ route('siswa.destroy',$siswa->id) }}"

method="POST"

onsubmit="return confirm('Hapus siswa ini?')"

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
font-semibold
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
text-gray-500
">


Data siswa belum tersedia.


</td>


</tr>



@endforelse



</tbody>


</table>


</div>







{{-- PAGINATION --}}


<div class="
px-6
py-5
border-t
">


{{ $siswas->links() }}


</div>



</div>




</div>


@endsection