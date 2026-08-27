@extends('orangtua.layouts.app')


@section('title','Ganti Password')



@section('content')


<div class="max-w-xl mx-auto">



<div class="
bg-white
rounded-2xl
border
shadow-sm
p-8
">



<h2 class="
text-2xl
font-bold
text-slate-800
mb-2
">

Ganti Password

</h2>




<p class="
text-sm
text-slate-500
mb-6
">

Untuk keamanan akun, silakan buat password baru.

</p>







{{-- SUCCESS --}}

@if(session('success'))

<div class="
bg-emerald-50
border
border-emerald-200
text-emerald-700
px-4
py-3
rounded-xl
mb-5
">

{{ session('success') }}

</div>

@endif







{{-- ERROR SESSION --}}

@if(session('error'))

<div class="
bg-red-50
border
border-red-200
text-red-700
px-4
py-3
rounded-xl
mb-5
">

{{ session('error') }}

</div>

@endif







{{-- VALIDATION ERROR --}}

@if($errors->any())

<div class="
bg-red-50
border
border-red-200
text-red-700
px-4
py-3
rounded-xl
mb-5
">


<ul class="list-disc ml-5">

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach


</ul>


</div>

@endif








<form method="POST"
action="{{ route('orangtua.password.update') }}">


@csrf






<div class="mb-5">


<label class="
block
text-sm
font-semibold
text-slate-700
mb-2
">

Password Baru

</label>



<input

type="password"

name="password"

class="
w-full
border
border-slate-300
rounded-xl
px-4
py-3
focus:outline-none
focus:ring-2
focus:ring-indigo-500
"

placeholder="Masukkan password baru"

required

>



</div>










<div class="mb-6">


<label class="
block
text-sm
font-semibold
text-slate-700
mb-2
">

Konfirmasi Password

</label>



<input

type="password"

name="password_confirmation"

class="
w-full
border
border-slate-300
rounded-xl
px-4
py-3
focus:outline-none
focus:ring-2
focus:ring-indigo-500
"

placeholder="Ulangi password baru"

required

>



</div>









<button

type="submit"

class="
w-full
bg-indigo-600
hover:bg-indigo-700
text-white
font-semibold
py-3
rounded-xl
transition
shadow-sm
"

>


Simpan Password


</button>







</form>





</div>


</div>


@endsection