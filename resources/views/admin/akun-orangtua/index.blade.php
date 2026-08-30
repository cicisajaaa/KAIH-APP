@extends('admin.layouts.app')


@section('title','Akun Orang Tua')

@section('page-title','Akun Orang Tua')



@section('content')


<div class="space-y-8">





{{-- HEADER --}}


<div class="
bg-white
rounded-2xl
border
p-7
flex
flex-col
lg:flex-row
lg:items-center
lg:justify-between
gap-5
">



<div>


<h2 class="
text-2xl
font-bold
text-slate-800
">

Manajemen Akun Orang Tua

</h2>



<p class="
text-slate-500
mt-2
">

Kelola akun login orang tua berdasarkan data siswa yang telah diinput.

</p>


</div>




<div class="flex gap-3">


<a href="{{ route('admin.generate.orangtua') }}"

onclick="
return confirm(
'Generate akun orang tua untuk semua siswa?'
)
"


class="
inline-flex
items-center
gap-2
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
font-semibold
text-sm
transition
">


⚡ Generate Akun


</a>





<form action="{{ route('admin.akun.orangtua.reset.semua') }}"
method="POST">


@csrf


<button

onclick="
return confirm(
'Reset password SEMUA akun orang tua?'
)
"

class="
inline-flex
items-center
gap-2
bg-red-600
hover:bg-red-700
text-white
px-5
py-3
rounded-xl
font-semibold
text-sm
transition
">

🔑 Reset Semua Password

</button>


</form>



</div>




</div>









{{-- SUMMARY --}}


<div class="
grid
grid-cols-1
md:grid-cols-3
gap-5
">





<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="
text-sm
text-slate-500
">

Total Akun Orang Tua

</p>


<h3 class="
text-4xl
font-bold
text-indigo-600
mt-3
">

{{ $users->count() }}

</h3>


<p class="
text-xs
text-slate-400
mt-2
">

Akun login tersedia

</p>


</div>







<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="
text-sm
text-slate-500
">

Role

</p>


<h3 class="
text-3xl
font-bold
text-emerald-600
mt-3
">

Orang Tua

</h3>


<p class="
text-xs
text-slate-400
mt-2
">

Hak akses monitoring siswa

</p>


</div>







<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="
text-sm
text-slate-500
">

Password Awal

</p>


<h3 class="
text-xl
font-bold
text-orange-500
mt-4
">

NIS Siswa

</h3>


<p class="
text-xs
text-slate-400
mt-2
">

Dapat direset oleh admin

</p>


</div>




</div>









{{-- TABLE --}}



<div class="
bg-white
rounded-2xl
border
overflow-hidden
">





<div class="
px-7
py-5
border-b
">


<h3 class="
text-lg
font-semibold
text-slate-800
">

Daftar Login Orang Tua

</h3>


<p class="
text-sm
text-slate-500
mt-1
">

Data akun yang terhubung dengan siswa.

</p>


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
tracking-wider
text-slate-500
">

No

</th>



<th class="
px-6
py-4
text-left
text-xs
uppercase
tracking-wider
text-slate-500
">

Orang Tua

</th>




<th class="
px-6
py-4
text-left
text-xs
uppercase
tracking-wider
text-slate-500
">

Siswa

</th>





<th class="
px-6
py-4
text-left
text-xs
uppercase
tracking-wider
text-slate-500
">

Kelas

</th>





<th class="
px-6
py-4
text-left
text-xs
uppercase
tracking-wider
text-slate-500
">

Email Login

</th>





<th class="
px-6
py-4
text-center
text-xs
uppercase
tracking-wider
text-slate-500
">

Status

</th>




<th class="
px-6
py-4
text-center
text-xs
uppercase
tracking-wider
text-slate-500
">

Aksi

</th>



</tr>


</thead>








<tbody class="divide-y">



@forelse($users as $user)



<tr class="
hover:bg-slate-50
transition
">





<td class="
px-6
py-4
text-sm
text-slate-500
">

{{ $loop->iteration }}

</td>







<td class="
px-6
py-4
">


<p class="
font-semibold
text-slate-800
">

{{ $user->name }}

</p>


<p class="
text-xs
text-slate-400
">

Orang Tua

</p>


</td>








<td class="
px-6
py-4
">


{{ 
$user->orangTua->siswa->nama_siswa ?? '-'
}}


</td>








<td class="
px-6
py-4
">


<span class="
px-3
py-1
rounded-full
text-xs
font-semibold
bg-indigo-50
text-indigo-700
">


{{ 
$user->orangTua->siswa->kelas->nama_kelas ?? '-'
}}


</span>


</td>









<td class="
px-6
py-4
">


<span class="
text-sm
text-slate-700
">

{{ $user->email }}

</span>


</td>









<td class="
px-6
py-4
text-center
">


<span class="
inline-flex
px-3
py-1
rounded-full
text-xs
font-semibold
bg-emerald-50
text-emerald-700
">


Aktif


</span>


</td>









<td class="
px-6
py-4
">


<div class="
flex
justify-center
">



<form

method="POST"

action="{{ route(
'admin.akun.orangtua.reset',
$user->id
) }}"

>


@csrf



<button

onclick="
return confirm(
'Reset password akun ini?'
)
"


class="
bg-orange-500
hover:bg-orange-600
text-white
px-4
py-2
rounded-lg
text-sm
font-semibold
transition
">


Reset Password


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
py-14
text-slate-500
">


Belum ada akun orang tua.

</td>


</tr>




@endforelse




</tbody>



</table>


</div>


</div>







</div>



@endsection