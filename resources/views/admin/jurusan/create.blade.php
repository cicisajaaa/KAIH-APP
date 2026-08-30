@extends('admin.layouts.app')

@section('title','Tambah Jurusan')


@section('content')


<div class="max-w-3xl mx-auto">



<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">



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

Tambah Data Jurusan

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Masukkan informasi jurusan baru pada sistem akademik.

</p>


</div>





<a href="{{ route('jurusan.index') }}"

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







{{-- FORM --}}


<div class="p-6">


<form action="{{ route('jurusan.store') }}"
method="POST">


@csrf






{{-- KODE --}}


<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Kode Jurusan

</label>


<input

type="text"

name="kode_jurusan"

value="{{ old('kode_jurusan') }}"

placeholder="Contoh: RPL"

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








{{-- NAMA --}}


<div class="mb-6">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Nama Jurusan

</label>


<input

type="text"

name="nama_jurusan"

value="{{ old('nama_jurusan') }}"

placeholder="Contoh: Rekayasa Perangkat Lunak"

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








{{-- BUTTON --}}


<div class="
flex
justify-end
gap-3
pt-5
border-t
border-slate-200
">


<a href="{{ route('jurusan.index') }}"

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