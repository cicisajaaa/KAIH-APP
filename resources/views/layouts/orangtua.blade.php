<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title','KAIH')
</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])


</head>


<body class="bg-[#f8fafc] text-slate-800">


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
overflow-hidden
">



{{-- decorative --}}

<div class="
absolute
top-0
right-0
w-40
h-40
bg-indigo-600/20
rounded-full
blur-3xl
">
</div>





{{-- BRAND --}}


<div class="
relative
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
shadow-indigo-600/30
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
mt-1
">

Sistem Monitoring Siswa

</p>


</div>


</div>



</div>









{{-- MENU --}}


<nav class="
relative
flex-1
px-5
py-6
">


<p class="
text-[11px]
uppercase
tracking-[0.2em]
text-slate-500
px-3
mb-4
">

Menu Utama

</p>








<a href="{{ route('orangtua.dashboard') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition-all


{{ request()->routeIs('orangtua.dashboard')

?
'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<svg class="w-5 h-5"
fill="none"
stroke="currentColor"
viewBox="0 0 24 24">

<path stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round"
d="M3 12l9-9 9 9M5 10v10h14V10"/>

</svg>



Dashboard


</a>









<a href="{{ route('orangtua.data-anak') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
mb-2
text-sm
transition-all


{{ request()->routeIs('orangtua.data-anak')

?
'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<svg class="w-5 h-5"
fill="none"
stroke="currentColor"
viewBox="0 0 24 24">


<path stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round"
d="M12 14c3 0 6 1.5 6 4v2H6v-2c0-2.5 3-4 6-4zM12 12a4 4 0 100-8 4 4 0 000 8z"/>


</svg>



Data Anak


</a>









<a href="{{ route('orangtua.angket.index') }}"

class="
flex
items-center
gap-3
px-4
py-3
rounded-xl
text-sm
transition-all


{{ request()->routeIs('orangtua.angket.*')

?
'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'

:
'text-slate-300 hover:bg-white/5 hover:text-white'

}}
">


<svg class="w-5 h-5"
fill="none"
stroke="currentColor"
viewBox="0 0 24 24">


<path stroke-width="2"
stroke-linecap="round"
stroke-linejoin="round"
d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z"/>


</svg>



Angket Harian


</a>





</nav>









{{-- PROFILE --}}


<div class="
relative
border-t
border-white/10
p-6
">





<div class="
bg-white/5
rounded-2xl
p-4
mb-4
">


<div class="
flex
items-center
gap-3
">


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


{{ strtoupper(substr(auth()->user()->name,0,1)) }}


</div>





<div>


<p class="
text-sm
font-semibold
">

{{ auth()->user()->name }}

</p>



<p class="
text-xs
text-slate-400
">

Orang Tua

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









{{-- MAIN --}}


<div class="ml-72 flex-1">







{{-- HEADER --}}


<header

class="
bg-white
border-b
px-10
py-6
">


<div class="
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

@yield(
'page-title',
'Dashboard Orang Tua'
)

</h2>



<p class="
text-sm
text-slate-500
mt-1
">

Monitoring aktivitas dan perkembangan siswa


</p>


</div>







<div class="
flex
items-center
gap-4
">


<div class="text-right">


<p class="
text-sm
font-semibold
">

{{ auth()->user()->name }}

</p>


<p class="
text-xs
text-slate-400
">

{{ now()->translatedFormat('d F Y') }}

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


{{ strtoupper(substr(auth()->user()->name,0,1)) }}


</div>


</div>



</div>


</header>









<main class="
p-10
">





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
mt-14
text-center
text-xs
text-slate-400
">

© {{ date('Y') }} KAIH System

</footer>





</main>






</div>



</div>



</body>


</html>