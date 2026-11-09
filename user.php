<?php

include "koneksi.php";

$total_query = mysqli_query(
    $koneksi,
    "SELECT * FROM dataguru"
);

$total = mysqli_num_rows($total_query);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Tenaga Pendidik | SMK Tunas Harapan</title>


<!-- BOOTSTRAP -->

<link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<style>

/* ==================================================
   GLOBAL
================================================== */

*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{

    margin:0;

    padding-top:70px;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    background:#f5f8fc;

    color:#334155;

}


/* ==================================================
   NAVBAR
   SAMA SEPERTI INDEX
================================================== */

.navbar{

    background:
        linear-gradient(
            90deg,
            #0b6b57,
            #124e8c
        );

    border:none;

    border-radius:0;

    box-shadow:
        0 3px 15px rgba(0,0,0,.20);

}


.navbar-brand{

    color:white!important;

    font-size:17px;

    font-weight:bold;

    transition:.3s;

}


.navbar-brand:hover{

    color:#f4b942!important;

}


.navbar-brand .glyphicon{

    margin-right:7px;

}


.navbar-nav>li>a{

    color:white!important;

    font-weight:bold;

    transition:.3s;

}


.navbar-nav>li>a:hover{

    background:
        #0b3d91!important;

    color:#f4b942!important;

    transform:
        translateY(-2px);

}


.navbar-nav>.active>a,
.navbar-nav>.active>a:hover,
.navbar-nav>.active>a:focus{

    background:
        #0b3d91!important;

    color:#f4b942!important;

}


/* ==================================================
   MOBILE NAVBAR
================================================== */

.navbar-toggle{

    border:
        1px solid rgba(255,255,255,.5);

}


.navbar-toggle .icon-bar{

    background:white;

}


.navbar-toggle:hover{

    background:
        rgba(255,255,255,.1);

}


@media(max-width:767px){

    .navbar-collapse{

        border-top:
            1px solid rgba(255,255,255,.15);

        background:#0b6b57;

    }


    .navbar-nav{

        margin-top:0;

        margin-bottom:0;

    }


    .navbar-nav>li>a{

        padding:
            13px 20px;

        transform:none!important;

    }


    .navbar-nav>li>a:hover{

        transform:none!important;

        background:
            #0b3d91!important;

    }

}


/* ==================================================
   BANNER
================================================== */

.banner{

    position:relative;

    overflow:hidden;

    margin-top:30px;

    margin-bottom:28px;

    padding:38px 35px;

    border-radius:18px;

    color:white;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c,
            #1e88e5
        );

    box-shadow:
        0 8px 25px rgba(13,71,161,.18);

}


.banner:before{

    content:"";

    position:absolute;

    width:220px;

    height:220px;

    border-radius:50%;

    background:
        rgba(255,255,255,.07);

    right:-70px;

    top:-100px;

}


.banner:after{

    content:"";

    position:absolute;

    width:150px;

    height:150px;

    border-radius:50%;

    background:
        rgba(255,213,79,.08);

    left:-60px;

    bottom:-90px;

}


.banner-content{

    position:relative;

    z-index:2;

}


.banner-icon{

    width:58px;

    height:58px;

    display:flex;

    align-items:center;

    justify-content:center;

    margin-bottom:15px;

    border-radius:15px;

    background:
        rgba(255,255,255,.15);

    font-size:25px;

}


.banner h2{

    margin:0 0 10px;

    font-size:28px;

    font-weight:800;

}


.banner p{

    margin:5px 0;

    font-size:14px;

    color:
        rgba(255,255,255,.9);

}


.total-guru{

    display:inline-flex;

    align-items:center;

    gap:8px;

    margin-top:13px;

    padding:9px 15px;

    border-radius:30px;

    background:
        rgba(255,255,255,.14);

    border:
        1px solid rgba(255,255,255,.18);

    font-size:13px;

    font-weight:600;

}


.total-guru strong{

    color:#f4b942;

    font-size:18px;

}


/* ==================================================
   PANEL DATA GURU
================================================== */

.panel-guru{

    border:none;

    border-radius:18px;

    overflow:hidden;

    background:white;

    box-shadow:
        0 7px 25px rgba(15,23,42,.08);

    margin-bottom:40px;

}


.panel-heading-guru{

    padding:20px 22px;

    color:white;

    background:
        linear-gradient(
            90deg,
            #0b6b57,
            #124e8c
        );

}


.panel-heading-guru h4{

    margin:0;

    font-size:17px;

    font-weight:700;

}


.panel-heading-guru .glyphicon{

    margin-right:8px;

}


.panel-body-guru{

    padding:22px;

}


/* ==================================================
   TABLE
================================================== */

.table{

    margin-bottom:0;

}


.table thead{

    background:#124e8c;

    color:white;

}


.table thead th{

    padding:14px 12px!important;

    border-color:
        #124e8c!important;

    font-size:13px;

    font-weight:700;

    vertical-align:middle!important;

}


.table tbody td{

    padding:13px 12px!important;

    vertical-align:middle!important;

    color:#475569;

    font-size:13px;

}


.table tbody tr{

    transition:.2s;

}


.table tbody tr:hover{

    background:#f0f6ff!important;

}


.table-striped>tbody>tr:nth-of-type(odd){

    background:#fafcff;

}


/* NOMOR */

.table tbody td:first-child{

    text-align:center;

    font-weight:700;

    color:#124e8c;

}


/* NAMA */

.table tbody td:nth-child(2){

    font-weight:600;

    color:#1e293b;

}


/* ==================================================
   EMPTY DATA
================================================== */

.empty-data{

    text-align:center;

    padding:60px 20px;

}


.empty-data .glyphicon{

    font-size:48px;

    color:#cbd5e1;

    margin-bottom:15px;

}


.empty-data h4{

    margin-top:10px;

    color:#64748b;

    font-size:18px;

    font-weight:700;

}


.empty-data p{

    color:#94a3b8;

    font-size:13px;

}


/* ==================================================
   FOOTER
================================================== */

.footer{

    margin-top:20px;

    padding:35px 15px;

    text-align:center;

    color:white;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #073b31
        );

}


.footer-title{

    margin-bottom:8px;

    font-size:17px;

    font-weight:700;

}


.footer p{

    margin:6px 0;

    color:
        rgba(255,255,255,.78);

    font-size:12px;

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:767px){

    body{

        padding-top:50px;

    }


    .banner{

        margin-top:25px;

        padding:28px 22px;

        border-radius:16px;

    }


    .banner h2{

        font-size:23px;

        line-height:1.35;

    }


    .banner p{

        font-size:13px;

        line-height:1.6;

    }


    .panel-guru{

        border-radius:15px;

    }


    .panel-body-guru{

        padding:12px;

    }


    .table thead th{

        font-size:12px;

        padding:11px 9px!important;

        white-space:nowrap;

    }


    .table tbody td{

        font-size:12px;

        padding:11px 9px!important;

        white-space:nowrap;

    }


    .table-responsive{

        border:none;

        margin-bottom:0;

    }


    .footer{

        padding:30px 15px;

    }

}


/* ==================================================
   HP KECIL
================================================== */

@media(max-width:400px){

    .banner h2{

        font-size:21px;

    }


    .banner-icon{

        width:52px;

        height:52px;

        font-size:22px;

    }


    .total-guru{

        font-size:12px;

    }

}

</style>

    <link rel="stylesheet" href="assets/css/site.css">

</head>


<body>


<!-- ==================================================
     NAVBAR
     SAMA SEPERTI INDEX
================================================== -->

<?php include __DIR__ . '/includes/navbar.php'; ?>


<!-- ==================================================
     CONTENT
================================================== -->

<div class="container">


<!-- BANNER -->

<div class="banner">


<div class="banner-content">


<div class="banner-icon">

<span class="glyphicon glyphicon-user"></span>

</div>


<h2>

Tenaga Pendidik SMK Tunas Harapan

</h2>


<p>

Daftar tenaga pendidik yang mengajar
di SMK Tunas Harapan Batang Serangan.

</p>


<div class="total-guru">

<span class="glyphicon glyphicon-education"></span>

Jumlah Guru:

<strong>

<?= $total ?>

</strong>

Orang

</div>


</div>

</div>


<!-- ==================================================
     PANEL DATA
================================================== -->

<div class="panel-guru">


<div class="panel-heading-guru">


<h4>

<span class="glyphicon glyphicon-list-alt"></span>

Data Tenaga Pendidik

</h4>


</div>


<div class="panel-body-guru">


<div class="table-responsive">


<table class="table table-bordered table-hover table-striped">


<thead>
<tr>
<th width="60">No</th>
<th>Nama Guru</th>
<th>Kurikulum</th>
</tr>
</thead>


<tbody>


<?php

$no = 1;


$data = mysqli_query(
    $koneksi,
    "SELECT *
     FROM dataguru
     ORDER BY nama ASC"
);


if(
    $data &&
    mysqli_num_rows($data) > 0
){

    while(
        $d = mysqli_fetch_assoc($data)
    ){

?>


<tr>


<td>

<?= $no++; ?>

</td>


<td>

<?= htmlspecialchars(
    $d['nama'] ?? '-'
); ?>

</td>


<td>
<?= htmlspecialchars($d['mapel'] ?? '-') ?>
</td>


</tr>


<?php

    }

}else{

?>


<tr>

<td
    colspan="3"
    style="padding:0!important;">

<div class="empty-data">


<span class="glyphicon glyphicon-user"></span>


<h4>

Belum Ada Tenaga Pendidik

</h4>


<p>

Data tenaga pendidik belum tersedia.

</p>


</div>

</td>

</tr>


<?php

}

?>


</tbody>

</table>


</div>

</div>

</div>

</div>


<!-- ==================================================
     FOOTER
================================================== -->

<?php include __DIR__ . '/includes/footer.php'; ?>


<!-- ==================================================
     JAVASCRIPT
================================================== -->

<script
src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
</script>


<script
src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
</script>


<script>

$(function(){

    $(".banner")
        .hide()
        .slideDown(600);


    $(".panel-guru")
        .hide()
        .fadeIn(800);

});

</script>


</body>

</html>