<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title','KAIH Admin')
</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])


</head>




<body class="bg-slate-100 text-slate-800">



<div class="flex min-h-screen">







{{-- SIDEBAR --}}


<aside

class="
fixed
left-0
top-0
w-72
h-screen
bg-[#0f172a]
text-white
flex
flex-col
shadow-2xl
overflow-y-auto
">







{{-- BRAND --}}


<div class="
px-7
py-7
border-b
border-white/10
">


<div class="flex items-center gap-4">


<div

class="
w-12
h-12
rounded-2xl
bg-indigo-600
flex
items-center
justify-center
font-bold
text-xl
shadow-lg
">

K

</div>




<div>


<h1 class="
text-xl
font-bold
tracking-wide
">

KAIH

</h1>


<p class="
text-xs
text-slate-400
">

Administrator Panel

</p>


</div>



</div>


</div>









{{-- MENU --}}


<nav class="
flex-1
px-5
py-6
">





<p class="
text-xs
uppercase
tracking-widest
text-slate-500
px-3
mb-4
">

Menu Utama

</p>







{{-- DASHBOARD --}}

<a href="{{ route('admin.dashboard') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('admin.dashboard')

?
'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
⌂
</span>


Dashboard


</a>









<p class="
text-xs
uppercase
tracking-widest
text-slate-500
px-3
mt-6
mb-3
">

Master Data

</p>







<a href="{{ route('jurusan.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('jurusan.*')

?
'bg-indigo-600 text-white'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
▣
</span>


Jurusan


</a>







<a href="{{ route('kelas.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('kelas.*')

?
'bg-indigo-600 text-white'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
▤
</span>


Kelas


</a>








<a href="{{ route('siswa.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('siswa.*')

?
'bg-indigo-600 text-white'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
◉
</span>


Siswa


</a>








<a href="{{ route('orangtua.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('orangtua.*')

?
'bg-indigo-600 text-white'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
◎
</span>


Orang Tua


</a>










<p class="
text-xs
uppercase
tracking-widest
text-slate-500
px-3
mt-6
mb-3
">

Manajemen Akun

</p>







<a href="{{ route('admin.akun.orangtua') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition

{{ request()->routeIs('admin.akun.orangtua')

?
'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
🔑
</span>


Akun Orang Tua


</a>







<p class="

text-xs

uppercase

tracking-widest

text-slate-500

px-3

mt-6

mb-3

">

Monitoring

</p>

<a href="{{ route('angket.index') }}"

class="

flex

items-center

gap-3

px-4

py-3

rounded-xl

mb-2

text-sm

transition

{{ request()->routeIs('angket.*')

?

'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:

'text-slate-300 hover:bg-white/5 hover:text-white'

}}

">

<span class="w-5">

📋

</span>

Angket Harian

</a>






<a href="{{ route('laporan.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
text-sm
transition

{{ request()->routeIs('laporan.*')

?
'bg-indigo-600 text-white'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<span class="w-5">
▥
</span>


Laporan


</a>





</nav>









{{-- PROFILE ADMIN --}}



<div class="
border-t
border-white/10
p-6
">



<div class="
bg-white/5
rounded-2xl
p-4
mb-5
">


<div class="flex items-center gap-3">



<div

class="
w-11
h-11
rounded-full
bg-indigo-500
flex
items-center
justify-center
font-bold
">

{{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}


</div>




<div>


<p class="text-sm font-semibold">

{{ Auth::user()->name ?? 'Admin' }}

</p>


<p class="text-xs text-slate-400">

Administrator

</p>


</div>


</div>


</div>






<form method="POST"

action="{{ route('logout') }}">

@csrf


<button

class="
w-full
py-3
rounded-xl
border
border-white/20
text-slate-300
text-sm
hover:bg-red-500
hover:text-white
hover:border-red-500
transition
">


Keluar


</button>


</form>



</div>






</aside>









{{-- CONTENT --}}



<div class="ml-72 flex-1">






{{-- HEADER --}}


<header

class="
bg-white
border-b
px-10
py-6
">


<div class="flex justify-between items-center">



<div>


<h1 class="
text-xl
font-bold
text-slate-800
">


@yield(
'page-title',
'Dashboard Admin'
)


</h1>


<p class="
text-sm
text-slate-500
mt-1
">

Sistem Informasi Akademik KAIH

</p>


</div>







<div class="flex items-center gap-3">


<div class="text-right">


<p class="text-sm font-semibold">

{{ Auth::user()->name ?? 'Admin' }}

</p>


<p class="text-xs text-slate-400">

Administrator

</p>


</div>




<div

class="
w-11
h-11
rounded-full
bg-indigo-100
text-indigo-700
flex
items-center
justify-center
font-bold
">

{{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}


</div>



</div>


</div>


</header>









<main class="p-10">






@if(session('success'))

<div

class="
mb-6
rounded-xl
bg-emerald-50
border
border-emerald-200
px-5
py-4
text-sm
text-emerald-700
">

{{ session('success') }}

</div>

@endif






@if(session('error'))

<div

class="
mb-6
rounded-xl
bg-red-50
border
border-red-200
px-5
py-4
text-sm
text-red-700
">

{{ session('error') }}

</div>

@endif






@yield('content')






<footer

class="
mt-12
text-center
text-xs
text-slate-400
">

© {{ date('Y') }} KAIH Administrator System

</footer>




</main>






</div>



</div>



</body>


</html>