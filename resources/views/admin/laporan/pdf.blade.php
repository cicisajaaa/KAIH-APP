<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>
Laporan Monitoring Angket Siswa
</title>


<style>

body{

    font-family: Arial, sans-serif;
    font-size: 12px;
    color:#333;

}


.header{

    text-align:center;
    margin-bottom:20px;

}


.header h1{

    font-size:18px;
    margin:0;
    font-weight:bold;

}


.header h2{

    font-size:15px;
    margin:5px 0;

}


.header p{

    margin:3px 0;
    font-size:12px;

}




.info-table{

    width:100%;
    border-collapse:collapse;
    margin-bottom:15px;

}


.info-table td{

    border:1px solid #ccc;
    padding:8px;

}






.stat{

    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;

}


.stat td{

    border:1px solid #ccc;
    padding:10px;
    text-align:center;

}


.stat-title{

    font-size:11px;
    color:#666;

}


.stat-value{

    font-size:16px;
    font-weight:bold;

}





table.data{

    width:100%;
    border-collapse:collapse;

}



table.data th{

    background:#eeeeee;
    font-weight:bold;
    text-align:center;

}



table.data th,
table.data td{

    border:1px solid #444;
    padding:7px;

}



.center{

    text-align:center;

}





.badge{

    padding:4px 8px;
    font-size:11px;

}



.baik{

    background:#dcfce7;
    color:#166534;

}



.perhatian{

    background:#fef9c3;
    color:#854d0e;

}



.pendampingan{

    background:#fee2e2;
    color:#991b1b;

}





.footer{

    margin-top:40px;
    text-align:right;
    font-size:11px;

}



</style>


</head>


<body>



<div class="header">


<h1>
KAIH
</h1>


<h2>
LAPORAN MONITORING ANGKET SISWA
</h2>


<p>
Sistem Monitoring Aktivitas Harian Siswa
</p>


</div>







<table class="info-table">


<tr>

<td width="25%">
Periode
</td>


<td>


@if($tanggalMulai && $tanggalAkhir)

{{ $tanggalMulai }}

s/d

{{ $tanggalAkhir }}


@elseif($tanggalMulai)

Mulai {{ $tanggalMulai }}


@elseif($tanggalAkhir)

Sampai {{ $tanggalAkhir }}


@else

Semua Data


@endif


</td>


</tr>





<tr>

<td>
Tanggal Cetak
</td>


<td>

{{ date('d-m-Y') }}

</td>


</tr>


</table>









@php


$total = $angket->count();


$rata = round(
    $angket->avg('skor') ?? 0
);



$baik = $angket
    ->where('kategori','Baik')
    ->count();



$perhatian = $angket
    ->where('kategori','Perlu Perhatian')
    ->count();



$pendampingan = $angket
    ->where('kategori','Perlu Pendampingan')
    ->count();



@endphp







<table class="stat">

<tr>



<td>

<div class="stat-title">
Total Angket
</div>

<div class="stat-value">
{{ $total }}
</div>


</td>





<td>

<div class="stat-title">
Rata-rata Skor
</div>

<div class="stat-value">
{{ $rata }}
</div>


</td>





<td>

<div class="stat-title">
Kategori Baik
</div>

<div class="stat-value">
{{ $baik }}
</div>


</td>





<td>

<div class="stat-title">
Perhatian
</div>

<div class="stat-value">
{{ $perhatian }}
</div>


</td>





<td>

<div class="stat-title">
Pendampingan
</div>

<div class="stat-value">
{{ $pendampingan }}
</div>


</td>



</tr>

</table>









<table class="data">


<thead>

<tr>


<th width="5%">
No
</th>


<th>
Siswa
</th>


<th>
Kelas
</th>


<th>
Orang Tua
</th>


<th>
Tanggal
</th>


<th>
Skor
</th>


<th>
Kategori
</th>


</tr>

</thead>





<tbody>


@foreach($angket as $item)


<tr>


<td class="center">

{{ $loop->iteration }}

</td>





<td>

{{ optional($item->siswa)->nama_siswa ?? '-' }}

<br>

<small>

NIS:
{{ optional($item->siswa)->nis ?? '-' }}

</small>


</td>





<td class="center">


{{ optional(optional($item->siswa)->kelas)->nama_kelas ?? '-' }}


</td>





<td>


{{ optional($item->orangTua)->nama_orang_tua ?? '-' }}


</td>





<td class="center">


{{

\Carbon\Carbon::parse(
$item->tanggal
)->format('d-m-Y')

}}


</td>





<td class="center">


{{ $item->skor ?? 0 }}


</td>





<td class="center">



@if($item->kategori == 'Baik')


<span class="badge baik">

Baik

</span>



@elseif($item->kategori == 'Perlu Perhatian')


<span class="badge perhatian">

Perhatian

</span>



@elseif($item->kategori == 'Perlu Pendampingan')


<span class="badge pendampingan">

Pendampingan

</span>



@else


-


@endif



</td>




</tr>


@endforeach



</tbody>


</table>








<div class="footer">


Dicetak oleh Admin KAIH

<br>

{{ date('d F Y') }}


</div>





</body>

</html>