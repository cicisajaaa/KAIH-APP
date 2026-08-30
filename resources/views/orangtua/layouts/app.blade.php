<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title','KAIH Orang Tua')
</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])


</head>



<body class="bg-slate-100 text-slate-800">



<div class="min-h-screen flex">






{{-- SIDEBAR --}}


<aside class="
hidden
md:flex
w-64
bg-white
border-r
flex-col
">



<div class="
px-6
py-5
border-b
">


<h1 class="
text-xl
font-bold
text-indigo-600
">

KAIH

</h1>


<p class="
text-sm
text-slate-500
">

Portal Orang Tua

</p>


</div>









<nav class="
flex-1
p-4
space-y-2
">



<a href="{{ route('orangtua.dashboard') }}"

class="
block
px-4
py-3
rounded-xl
text-sm
font-medium
hover:bg-indigo-50
hover:text-indigo-600
">

Dashboard

</a>






<a href="{{ route('orangtua.data-anak') }}"

class="
block
px-4
py-3
rounded-xl
text-sm
font-medium
hover:bg-indigo-50
hover:text-indigo-600
">

Data Anak

</a>







<a href="{{ route('orangtua.angket.index') }}"

class="
block
px-4
py-3
rounded-xl
text-sm
font-medium
hover:bg-indigo-50
hover:text-indigo-600
">

Angket Harian

</a>







<a href="{{ route('orangtua.riwayat') }}"

class="
block
px-4
py-3
rounded-xl
text-sm
font-medium
hover:bg-indigo-50
hover:text-indigo-600
">

Riwayat Angket

</a>





</nav>









<div class="
p-4
border-t
">



<p class="
text-xs
text-slate-400
mb-3
">

Login sebagai

</p>



<p class="
text-sm
font-semibold
mb-4
">

{{ auth()->user()->name }}

</p>




<form method="POST" action="{{ route('logout') }}">

@csrf


<button

class="
w-full
bg-red-50
text-red-600
py-2
rounded-lg
text-sm
font-semibold
hover:bg-red-100
">

Logout

</button>


</form>


</div>







</aside>









{{-- CONTENT AREA --}}



<div class="
flex-1
">



<header class="
bg-white
border-b
px-8
py-5
flex
justify-between
items-center
">



<div>


<h2 class="
font-bold
text-lg
">

@yield('page-title','Dashboard')

</h2>


</div>




<div class="
text-sm
text-slate-500
">

{{ auth()->user()->name }}

</div>




</header>









<main class="p-8">



@if(session('success'))


<div class="
mb-5
bg-emerald-50
border
border-emerald-200
text-emerald-700
px-5
py-3
rounded-xl
">


{{ session('success') }}


</div>


@endif






@if(session('error'))


<div class="
mb-5
bg-red-50
border
border-red-200
text-red-700
px-5
py-3
rounded-xl
">


{{ session('error') }}


</div>


@endif







@yield('content')





</main>




</div>





</div>



</body>

</html>