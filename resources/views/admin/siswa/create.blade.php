@extends('admin.layouts.app')

@section('title','Tambah Siswa')


@section('content')


<div class="max-w-4xl mx-auto">


<div class="bg-white border border-slate-200 rounded-xl shadow-sm">



{{-- HEADER --}}

<div class="
px-6
py-5
border-b
border-slate-200
flex
justify-between
items-center
">


<div>

<h2 class="
text-xl
font-bold
text-slate-800
">

Tambah Data Siswa

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Form penginputan data peserta didik baru.

</p>


</div>




<a href="{{ route('siswa.index') }}"

class="
px-4
py-2
text-sm
font-medium
bg-slate-100
hover:bg-slate-200
text-slate-700
rounded-lg
transition
">

Kembali

</a>


</div>







<div class="p-6">



@if($errors->any())


<div class="
mb-5
p-4
rounded-lg
bg-red-50
border
border-red-200
">


<p class="
font-semibold
text-red-700
mb-2
text-sm
">

Periksa kembali data yang dimasukkan.

</p>


<ul class="
text-sm
text-red-600
list-disc
ml-5
">


@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach


</ul>


</div>


@endif








<form action="{{ route('siswa.store') }}"
method="POST">

@csrf




<div class="grid md:grid-cols-2 gap-5">





{{-- NIS --}}

<div>

<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

NIS

</label>


<input

type="text"

name="nis"

value="{{ old('nis') }}"

placeholder="Masukkan NIS"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
focus:outline-none
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
"


>

</div>









{{-- Nama --}}

<div>

<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Nama Siswa

</label>


<input

type="text"

name="nama_siswa"

value="{{ old('nama_siswa') }}"

placeholder="Masukkan nama siswa"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
focus:outline-none
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
"


>

</div>









{{-- JK --}}

<div>

<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Jenis Kelamin

</label>


<select

name="jenis_kelamin"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
focus:outline-none
focus:ring-2
focus:ring-indigo-500
"


>


<option value="">
-- Pilih Jenis Kelamin --
</option>


<option value="L"
{{ old('jenis_kelamin')=='L'?'selected':'' }}
>

Laki-laki

</option>


<option value="P"
{{ old('jenis_kelamin')=='P'?'selected':'' }}
>

Perempuan

</option>


</select>


</div>









{{-- Kelas --}}

<div>

<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Kelas

</label>


<select

name="kelas_id"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
focus:outline-none
focus:ring-2
focus:ring-indigo-500
"


>


<option value="">
-- Pilih Kelas --
</option>



@foreach($kelas as $item)


<option

value="{{ $item->id }}"

{{ old('kelas_id')==$item->id?'selected':'' }}

>


{{ $item->nama_kelas }}


</option>


@endforeach


</select>


</div>




</div>








<div class="
flex
justify-end
gap-3
mt-8
pt-5
border-t
border-slate-200
">



<a href="{{ route('siswa.index') }}"

class="
px-5
py-2.5
rounded-lg
text-sm
font-medium
bg-slate-100
hover:bg-slate-200
text-slate-700
">

Batal

</a>





<button

type="submit"

class="
px-6
py-2.5
rounded-lg
text-sm
font-medium
bg-indigo-600
hover:bg-indigo-700
text-white
transition
">

Simpan Data

</button>



</div>





</form>



</div>


</div>


</div>



@endsection