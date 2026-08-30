<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
KAIH | Administrator Login
</title>


@vite([
'resources/css/app.css',
'resources/js/app.js'
])


</head>



<body class="min-h-screen bg-slate-100">





<div class="
min-h-screen
flex
">







{{-- LEFT SIDE --}}


<div class="
hidden
lg:flex
lg:w-1/2
bg-[#0f172a]
relative
overflow-hidden
items-center
justify-center
">





{{-- BACKGROUND SHAPE --}}


<div class="
absolute
w-[500px]
h-[500px]
rounded-full
bg-indigo-600/20
blur-3xl
-top-40
-left-40
">
</div>


<div class="
absolute
w-[400px]
h-[400px]
rounded-full
bg-blue-500/10
blur-3xl
bottom-0
right-0
">
</div>







<div class="
relative
z-10
px-16
max-w-xl
">







{{-- LOGO --}}


<div class="
w-28
h-28
rounded-3xl
bg-white
flex
items-center
justify-center
shadow-xl
">


{{-- GANTI DENGAN LOGO SEKOLAH --}}

<span class="
text-6xl
font-black
text-[#0f172a]
">

K

</span>


</div>








<h1 class="
mt-8
text-5xl
font-bold
text-white
tracking-wide
">

KAIH

</h1>




<p class="
mt-3
text-xl
text-slate-300
">

Sistem Informasi Akademik Sekolah

</p>



<p class="
mt-5
text-sm
text-slate-400
leading-relaxed
max-w-md
">

Platform digital untuk mengelola data siswa,
monitoring perkembangan peserta didik,
serta administrasi akademik sekolah secara terpadu.

</p>









{{-- FEATURE --}}


<div class="
mt-10
space-y-4
">





<div class="
flex
items-center
gap-4
">


<div class="
w-11
h-11
rounded-xl
bg-white/10
flex
items-center
justify-center
text-indigo-300
font-bold
">

01

</div>



<div>

<p class="
text-white
font-semibold
">

Manajemen Data Sekolah

</p>


<p class="
text-xs
text-slate-400
">

Siswa, kelas, jurusan dan orang tua

</p>


</div>


</div>







<div class="
flex
items-center
gap-4
">


<div class="
w-11
h-11
rounded-xl
bg-white/10
flex
items-center
justify-center
text-indigo-300
font-bold
">

02

</div>



<div>

<p class="
text-white
font-semibold
">

Monitoring Siswa

</p>


<p class="
text-xs
text-slate-400
">

Pemantauan aktivitas dan perkembangan

</p>


</div>


</div>








<div class="
flex
items-center
gap-4
">


<div class="
w-11
h-11
rounded-xl
bg-white/10
flex
items-center
justify-center
text-indigo-300
font-bold
">

03

</div>



<div>

<p class="
text-white
font-semibold
">

Laporan Akademik

</p>


<p class="
text-xs
text-slate-400
">

Rekap data sekolah secara cepat

</p>


</div>


</div>



</div>










<p class="
mt-14
text-xs
text-slate-500
">

© {{date('Y')}} KAIH Academic System

</p>





</div>




</div>









{{-- RIGHT SIDE --}}


<div class="
w-full
lg:w-1/2
flex
items-center
justify-center
px-6
">






<div class="
w-full
max-w-md
">







{{-- MOBILE LOGO --}}


<div class="
lg:hidden
text-center
mb-8
">


<div class="
mx-auto
w-20
h-20
rounded-2xl
bg-[#0f172a]
flex
items-center
justify-center
text-white
text-4xl
font-bold
">

K

</div>


<h1 class="
mt-4
text-3xl
font-bold
text-slate-800
">

KAIH

</h1>


</div>










<div class="
bg-white
rounded-3xl
border
border-slate-200
shadow-xl
p-9
">







<div class="mb-8">





<div class="
inline-flex
items-center
px-4
py-2
rounded-full
bg-indigo-50
text-indigo-600
text-xs
font-semibold
mb-5
">


Administrator Portal


</div>






<h2 class="
text-3xl
font-bold
text-slate-800
">

Selamat Datang

</h2>



<p class="
text-sm
text-slate-500
mt-2
">

Masuk untuk mengakses dashboard KAIH

</p>



</div>









@if($errors->any())


<div class="
mb-6
rounded-xl
bg-red-50
border
border-red-200
px-4
py-3
text-sm
text-red-700
">


Email atau password tidak valid.


</div>


@endif







@if(session('status'))


<div class="
mb-6
rounded-xl
bg-green-50
border
border-green-200
px-4
py-3
text-sm
text-green-700
">

{{session('status')}}

</div>


@endif










<form method="POST" action="{{route('login')}}">


@csrf







{{-- EMAIL --}}


<div class="mb-5">


<label class="
block
text-sm
font-semibold
text-slate-700
mb-2
">

Email Administrator

</label>



<input

type="email"

name="email"

value="{{old('email')}}"

required

placeholder="Masukkan email"

class="
w-full
px-4
py-3.5
rounded-xl
border
border-slate-300
bg-slate-50
focus:bg-white
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
outline-none
transition
"

>



</div>









{{-- PASSWORD --}}


<div class="mb-6">


<label class="
block
text-sm
font-semibold
text-slate-700
mb-2
">

Password

</label>



<input

type="password"

name="password"

required

placeholder="Masukkan password"

class="
w-full
px-4
py-3.5
rounded-xl
border
border-slate-300
bg-slate-50
focus:bg-white
focus:ring-2
focus:ring-indigo-500
focus:border-indigo-500
outline-none
transition
"

>



</div>









<div class="
flex
items-center
mb-7
">


<input

type="checkbox"

name="remember"

class="
rounded
border-slate-300
text-indigo-600
focus:ring-indigo-500
"


>


<label class="
ml-2
text-sm
text-slate-600
">

Ingat saya

</label>


</div>









<button

type="submit"

class="
w-full
py-3.5
rounded-xl
bg-indigo-600
hover:bg-indigo-700
text-white
font-semibold
shadow-lg
shadow-indigo-600/20
transition
duration-300
"


>


Masuk Dashboard


</button>






</form>









<div class="
mt-8
pt-6
border-t
border-slate-100
text-center
">


<p class="
text-xs
text-slate-400
">

Secure Academic Access

</p>


<p class="
text-xs
text-slate-400
mt-1
">

KAIH Administrator System

</p>



</div>








</div>







</div>







</div>








</div>





</body>


</html>