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

Kelola akun login orang tua berdasarkan data siswa.

</p>


</div>





<div class="flex gap-3">


<a href="{{ route('admin.generate.orangtua') }}"

onclick="return confirm('Generate akun orang tua untuk semua siswa?')"

class="
bg-indigo-600
hover:bg-indigo-700
text-white
px-5
py-3
rounded-xl
font-semibold
text-sm
">

⚡ Generate Akun

</a>




<form 
action="{{ route('admin.akun.orangtua.reset.semua') }}"
method="POST"
>


@csrf


<button

onclick="return confirm('Reset semua password akun orang tua?')"

class="
bg-red-600
hover:bg-red-700
text-white
px-5
py-3
rounded-xl
font-semibold
text-sm
">

🔑 Reset Semua

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


<p class="text-sm text-slate-500">

Total Akun

</p>


<h3 class="
text-4xl
font-bold
text-indigo-600
mt-3
">

{{ $users->total() }}

</h3>


</div>







<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

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


</div>







<div class="
bg-white
rounded-2xl
border
p-6
">


<p class="text-sm text-slate-500">

Password Awal

</p>


<h3 class="
text-xl
font-bold
text-orange-500
mt-4
">

Kaih#NIS

</h3>


</div>


</div>









{{-- FILTER --}}


<div class="
bg-white
rounded-2xl
border
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
text-slate-700
">

Cari Akun

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



<a href="{{ route('admin.akun.orangtua') }}"

class="
bg-gray-100
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
">

Data akun yang terhubung dengan siswa.

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
Orang Tua
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Siswa
</th>
<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
NIS
</th>

<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Kelas
</th>


<th class="px-6 py-4 text-left text-xs uppercase text-slate-500">
Email
</th>


<th class="px-6 py-4 text-center text-xs uppercase text-slate-500">
Status
</th>


<th class="px-6 py-4 text-center text-xs uppercase text-slate-500">
Aksi
</th>


</tr>


</thead>





<tbody class="divide-y">


@forelse($users as $user)


<tr class="hover:bg-slate-50">


<td class="px-6 py-4">

{{ $users->firstItem()+$loop->index }}

</td>



<td class="px-6 py-4">

<p class="font-semibold">

{{ $user->name }}

</p>

</td>




<td class="px-6 py-4">

{{ optional($user->orangTua)->siswa->nama_siswa ?? '-' }}

</td>

<td class="px-6 py-4">

{{ optional($user->orangTua)->siswa->nis ?? '-' }}

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

{{ optional($user->orangTua)->siswa->kelas->nama_kelas ?? '-' }}

</span>

</td>





<td class="px-6 py-4">

{{ $user->email }}

</td>





<td class="px-6 py-4 text-center">


@if($user->must_change_password)


<span class="
px-3
py-1
rounded-full
text-xs
bg-yellow-50
text-yellow-700
font-semibold
">

Belum Ganti Password

</span>


@else


<span class="
px-3
py-1
rounded-full
text-xs
bg-green-50
text-green-700
font-semibold
">

Aktif

</span>


@endif


</td>






<td class="px-6 py-4">


<form

method="POST"

action="{{ route('admin.akun.orangtua.reset',$user->id) }}"

>


@csrf


<button

onclick="return confirm('Reset password akun ini?')"

class="
bg-orange-500
hover:bg-orange-600
text-white
px-4
py-2
rounded-lg
text-sm
">

Reset

</button>


</form>


</td>


</tr>


@empty


<tr>

<td colspan="8"

class="text-center py-12 text-gray-500"
>

Belum ada akun orang tua.

</td>

</tr>


@endforelse


</tbody>


</table>


</div>





<div class="px-7 py-5 border-t">

{{ $users->links() }}

</div>



</div>





</div>


@endsection