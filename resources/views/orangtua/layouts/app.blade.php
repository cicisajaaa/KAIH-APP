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


<div class="min-h-screen">



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

<h1 class="
text-xl
font-bold
text-slate-800
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




<div class="text-sm font-semibold">

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



@yield('content')


</main>



</div>


</body>

</html>