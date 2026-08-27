@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')


<div class="space-y-8">



{{-- HEADER --}}

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">


<div>

<h2 class="text-2xl font-bold text-slate-800">
Data Siswa
</h2>


<p class="text-slate-500 mt-1">
Kelola data siswa, kelas, dan akun orang tua.
</p>


</div>





<div class="flex flex-wrap gap-3">



{{-- GENERATE AKUN --}}

<a href="{{ route('admin.generate.orangtua') }}"

onclick="return confirm(
'Generate akun orang tua untuk seluruh siswa?'
)"

class="
inline-flex
items-center
gap-2
bg-purple-600
hover:bg-purple-700
text-white
font-semibold
px-5
py-3
rounded-xl
transition
">


👨‍👩‍👧

Generate Akun Orang Tua


</a>








{{-- EXPORT --}}

<a href="{{ route('siswa.export') }}"

class="
inline-flex
items-center
gap-2
bg-emerald-600
hover:bg-emerald-700
text-white
font-semibold
px-5
py-3
rounded-xl
transition
">


📤

Export Excel


</a>







{{-- TAMBAH --}}

<a href="{{ route('siswa.create') }}"

class="
inline-flex
items-center
gap-2
bg-indigo-600
hover:bg-indigo-700
text-white
font-semibold
px-5
py-3
rounded-xl
transition
">


+

Tambah Siswa


</a>




</div>


</div>









{{-- IMPORT --}}


<div class="
bg-white
rounded-2xl
border
p-6
">


<div class="
flex
flex-col
xl:flex-row
xl:items-center
xl:justify-between
gap-5
">



<div>

<h3 class="font-semibold text-slate-800">

Import Data Siswa

</h3>


<p class="text-sm text-slate-500 mt-1">

Upload file Excel data siswa.

</p>


</div>







<form

action="{{ route('siswa.import') }}"

method="POST"

enctype="multipart/form-data"

class="flex flex-col sm:flex-row gap-3"

>


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
py-2.5
text-sm
"


>





<button

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-2.5
rounded-xl
font-semibold
">


📥 Import Excel


</button>




</form>



</div>


</div>









{{-- TABLE --}}


<div class="
bg-white
rounded-2xl
border
overflow-hidden
">





<div class="px-6 py-5 border-b">


<h3 class="font-bold text-lg">

Daftar Siswa

</h3>


<p class="text-sm text-slate-500">

Total {{ $siswas->count() }} siswa

</p>


</div>








<div class="overflow-x-auto">


<table class="w-full">



<thead class="bg-slate-50">


<tr>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
No
</th>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
NIS
</th>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
Nama
</th>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
JK
</th>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
Kelas
</th>


<th class="px-6 py-4 text-left text-xs text-slate-500 uppercase">
Status Akun
</th>


<th class="px-6 py-4 text-center text-xs text-slate-500 uppercase">
Aksi
</th>


</tr>


</thead>







<tbody class="divide-y">





@forelse($siswas as $siswa)



<tr class="hover:bg-slate-50">





<td class="px-6 py-4">

{{ $loop->iteration }}

</td>





<td class="px-6 py-4 font-medium">

{{ $siswa->nis }}

</td>






<td class="px-6 py-4 font-semibold">


{{ $siswa->nama_siswa }}


</td>






<td class="px-6 py-4">


@if($siswa->jenis_kelamin == 'L')


<span class="
px-3 py-1
rounded-full
text-xs
bg-blue-50
text-blue-700
">

Laki-laki

</span>


@else


<span class="
px-3 py-1
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


@if($siswa->kelas)


<span class="
px-3 py-1
rounded-full
text-xs
bg-indigo-50
text-indigo-700
">

{{ $siswa->kelas->nama_kelas }}

</span>


@else

-

@endif


</td>








{{-- STATUS AKUN --}}

<td class="px-6 py-4">


@if(
$siswa->orangTua->contains(function($ortu){

return $ortu->user;

})
)


<span class="
px-3 py-1
rounded-full
text-xs
font-semibold
bg-emerald-50
text-emerald-700
">

✓ Sudah Ada

</span>


@else


<span class="
px-3 py-1
rounded-full
text-xs
font-semibold
bg-yellow-50
text-yellow-700
">

Belum Ada

</span>


@endif


</td>








<td class="px-6 py-4">


<div class="flex justify-center gap-2">



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

✏️ Edit

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
text-sm
">


🗑 Hapus


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


Belum ada data siswa.


</td>


</tr>



@endforelse




</tbody>


</table>



</div>




</div>





</div>


@endsection