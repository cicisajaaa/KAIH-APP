@extends('admin.layouts.app')

@section('title','Tambah Orang Tua')


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

Tambah Data Orang Tua

</h2>


<p class="
text-sm
text-slate-500
mt-1
">

Form pengisian data orang tua atau wali siswa.

</p>


</div>




<a href="{{ route('orangtua.index') }}"

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



{{-- ERROR --}}

@if($errors->any())


<div class="
mb-6
bg-red-50
border
border-red-200
rounded-lg
px-4
py-3
">


<p class="
text-sm
font-semibold
text-red-700
mb-2
">

Data belum dapat disimpan.

</p>


<ul class="
list-disc
ml-5
text-sm
text-red-600
">


@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach


</ul>


</div>


@endif







<form action="{{ route('orangtua.store') }}"
method="POST">


@csrf





{{-- SISWA --}}

<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Siswa

</label>


<select

id="siswa_id"

name="siswa_id"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
bg-white
focus:outline-none
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
"


>


<option value="">

-- Pilih Siswa --

</option>



@foreach($siswas as $siswa)


<option

value="{{ $siswa->id }}"

{{ old('siswa_id')==$siswa->id?'selected':'' }}

>

{{ $siswa->nis }}
-
{{ $siswa->nama_siswa }}
-
{{ $siswa->kelas?->nama_kelas ?? 'Tanpa Kelas' }}

</option>


@endforeach


</select>


</div>









{{-- NAMA ORANG TUA --}}


<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Nama Orang Tua / Wali

</label>



<input

type="text"

id="nama_orang_tua"

name="nama_orang_tua"

value="{{ old('nama_orang_tua') }}"

placeholder="Masukkan nama orang tua atau wali"


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









{{-- HUBUNGAN --}}


<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Hubungan

</label>


<select

id="hubungan"

name="hubungan"

required


class="
w-full
border
border-slate-300
rounded-lg
px-4
py-2.5
text-sm
bg-white
focus:outline-none
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
"


>


<option value="">

-- Pilih Hubungan --

</option>


<option value="Ayah"
{{ old('hubungan')=='Ayah'?'selected':'' }}
>

Ayah

</option>


<option value="Ibu"
{{ old('hubungan')=='Ibu'?'selected':'' }}
>

Ibu

</option>


<option value="Wali"
{{ old('hubungan')=='Wali'?'selected':'' }}
>

Wali

</option>


</select>


</div>









{{-- NO HP --}}


<div class="mb-5">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Nomor HP

</label>


<input

type="text"

id="no_hp"

name="no_hp"

value="{{ old('no_hp') }}"

placeholder="Contoh: 081234567890"


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









{{-- PEKERJAAN --}}


<div class="mb-6">


<label class="
block
text-sm
font-medium
text-slate-700
mb-2
">

Pekerjaan

</label>


<input

type="text"

id="pekerjaan"

name="pekerjaan"

value="{{ old('pekerjaan') }}"

placeholder="Contoh: Wiraswasta"


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



<a href="{{ route('orangtua.index') }}"

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