@extends('admin.layouts.app')

@section('title','Tambah Kelas')


@section('content')


<div class="max-w-3xl mx-auto">


<div class="
bg-white
border
border-slate-200
rounded-xl
shadow-sm
overflow-hidden
">



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

Tambah Data Kelas

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Masukkan informasi kelas baru pada sistem akademik.

</p>


</div>




<a href="{{ route('kelas.index') }}"

class="
px-4
py-2
text-sm
font-medium
bg-slate-100
hover:bg-slate-200
rounded-lg
text-slate-700
transition
">

Kembali

</a>


</div>







<div class="p-6">



<form action="{{ route('kelas.store') }}"
method="POST">


@csrf






{{-- NAMA KELAS --}}


<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Nama Kelas

</label>



<input

type="text"

name="nama_kelas"

value="{{ old('nama_kelas') }}"

placeholder="Contoh: XI RPL 1"

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




@error('nama_kelas')

<p class="
text-red-600
text-sm
mt-2
">

{{ $message }}

</p>


@enderror



</div>









{{-- JURUSAN --}}


<div class="mb-6">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Jurusan

</label>




<select

name="jurusan_id"


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


<option value="">

-- Tanpa Jurusan --

</option>



@foreach($jurusans as $jurusan)


<option

value="{{ $jurusan->id }}"

{{ old('jurusan_id') == $jurusan->id ? 'selected':'' }}

>


{{ $jurusan->nama_jurusan }}


</option>


@endforeach



</select>





@error('jurusan_id')

<p class="
text-red-600
text-sm
mt-2
">

{{ $message }}

</p>


@enderror



</div>









{{-- BUTTON --}}


<div class="
flex
justify-end
gap-3
pt-5
border-t
border-slate-200
">



<a href="{{ route('kelas.index') }}"

class="
px-5
py-2.5
rounded-lg
bg-slate-100
hover:bg-slate-200
text-slate-700
text-sm
font-medium
transition
">

Batal

</a>






<button

type="submit"


class="
px-6
py-2.5
rounded-lg
bg-indigo-600
hover:bg-indigo-700
text-white
text-sm
font-medium
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