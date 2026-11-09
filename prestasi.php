<?php

include __DIR__ . "/koneksi.php";


$query = mysqli_query(
    $koneksi,
    "SELECT *
     FROM prestasi
     ORDER BY tanggal DESC, id DESC"
);


if(!$query){

    die(
        "Query gagal: "
        . mysqli_error($koneksi)
    );

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
    Capaian Siswa - SMK Tunas Harapan
</title>


<!-- BOOTSTRAP -->

<link
    href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">


<!-- FONT AWESOME -->

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>

/* ==================================================
   GLOBAL
================================================== */

html{
    scroll-behavior:smooth;
}

*{
    box-sizing:border-box;
}

body{

    margin:0;

    padding-top:60px;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    background:#f5f8fc;

    color:#334155;

    overflow-x:hidden;

}


/* ==================================================
   NAVBAR
   SAMA SEPERTI INDEX.PHP
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
        0 4px 18px rgba(0,0,0,.18);

}


.navbar-brand{

    color:white!important;

    font-size:17px;

    font-weight:700;

    transition:.3s;

}


.navbar-brand:hover{

    color:#f4b942!important;

}


.navbar-brand span{

    margin-right:7px;

}


.navbar-nav>li>a{

    color:white!important;

    font-weight:600;

    transition:.25s;

}


.navbar-nav>li>a:hover{

    background:
        rgba(255,255,255,.10)!important;

    color:#f4b942!important;

}


.navbar-nav>.active>a,
.navbar-nav>.active>a:hover,
.navbar-nav>.active>a:focus{

    background:
        rgba(0,0,0,.18)!important;

    color:#f4b942!important;

}


/* ==================================================
   MOBILE NAVBAR
================================================== */

.navbar-toggle{

    border:none;

    background:transparent!important;

    margin-top:8px;

}


.navbar-toggle:hover,
.navbar-toggle:focus{

    background:
        rgba(255,255,255,.1)!important;

}


.navbar-toggle .icon-bar{

    background:white;

    width:23px;

}


.navbar-collapse{

    border:none;

}


@media(max-width:767px){

    .navbar-nav{

        margin-top:0;

        background:#0b6b57;

        border-radius:0 0 10px 10px;

        padding:5px 0 10px;

    }


    .navbar-nav>li>a{

        padding:
            13px 20px;

    }


    .navbar-nav>li>a:hover{

        background:
            rgba(255,255,255,.10)!important;

        transform:none;

    }


    .navbar-brand{

        font-size:15px;

    }

}


/* ==================================================
   HERO
================================================== */

.hero{

    position:relative;

    overflow:hidden;

    padding:
        70px 20px;

    text-align:center;

    color:white;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c,
            #1976d2
        );

}


.hero:before{

    content:"";

    position:absolute;

    width:280px;

    height:280px;

    right:-90px;

    top:-140px;

    border-radius:50%;

    background:
        rgba(255,255,255,.07);

}


.hero:after{

    content:"";

    position:absolute;

    width:200px;

    height:200px;

    left:-90px;

    bottom:-120px;

    border-radius:50%;

    background:
        rgba(255,255,255,.07);

}


.hero-content{

    position:relative;

    z-index:2;

}


.hero-icon{

    width:75px;

    height:75px;

    margin:
        0 auto 20px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:20px;

    background:
        rgba(255,255,255,.15);

    border:
        1px solid rgba(255,255,255,.20);

    font-size:32px;

    box-shadow:
        0 8px 25px rgba(0,0,0,.12);

}


.hero h1{

    margin:
        0 0 12px;

    font-size:34px;

    font-weight:800;

    text-shadow:
        2px 3px 10px rgba(0,0,0,.18);

}


.hero p{

    margin:0;

    color:
        rgba(255,255,255,.88);

    font-size:15px;

    line-height:1.7;

}


/* ==================================================
   SECTION
================================================== */

.section{

    padding:
        55px 0;

}


.section-title{

    text-align:center;

    margin-bottom:35px;

}


.section-title h2{

    margin:0;

    color:#0b6b57;

    font-size:28px;

    font-weight:800;

}


.section-title h2:after{

    content:"";

    display:block;

    width:60px;

    height:4px;

    background:#f4b942;

    margin:
        12px auto 0;

    border-radius:10px;

}


.section-title p{

    margin-top:16px;

    color:#64748b;

    font-size:14px;

}


/* ==================================================
   PRESTASI CARD
================================================== */

.prestasi-card{

    margin-bottom:30px;

    background:white;

    border-radius:18px;

    overflow:hidden;

    border:
        1px solid #edf1f7;

    box-shadow:
        0 7px 25px rgba(15,23,42,.07);

    transition:
        transform .3s ease,
        box-shadow .3s ease;

}


.prestasi-card:hover{

    transform:
        translateY(-7px);

    box-shadow:
        0 17px 38px rgba(13,71,161,.15);

}


/* ==================================================
   FOTO PRESTASI
================================================== */

.prestasi-image{

    height:225px;

    overflow:hidden;

    background:#eef2f7;

    position:relative;

}


.prestasi-image img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:
        transform .5s ease;

}


.prestasi-card:hover
.prestasi-image img{

    transform:
        scale(1.07);

}


.prestasi-badge{

    position:absolute;

    top:15px;

    left:15px;

    padding:
        7px 13px;

    border-radius:20px;

    background:#f4b942;

    color:#0b6b57;

    font-size:11px;

    font-weight:800;

    box-shadow:
        0 4px 10px rgba(0,0,0,.18);

}


/* ==================================================
   CONTENT
================================================== */

.prestasi-content{

    padding:22px;

}


.prestasi-content h3{

    margin:
        0 0 11px;

    color:#0b6b57;

    font-size:19px;

    font-weight:700;

    line-height:1.45;

}


.prestasi-content p{

    color:#64748b;

    font-size:13px;

    line-height:1.8;

    margin-bottom:17px;

}


.prestasi-date{

    display:inline-flex;

    align-items:center;

    gap:7px;

    padding:
        8px 12px;

    border-radius:20px;

    background:#e5f5f1;

    color:#124e8c;

    font-size:11px;

    font-weight:700;

}


/* ==================================================
   EMPTY
================================================== */

.empty{

    text-align:center;

    padding:65px 20px;

    background:white;

    border-radius:18px;

    border:
        1px solid #edf1f7;

    box-shadow:
        0 6px 20px rgba(15,23,42,.06);

}


.empty i{

    font-size:48px;

    color:#cbd5e1;

    margin-bottom:18px;

}


.empty h4{

    color:#64748b;

    font-weight:700;

    margin-bottom:8px;

}


.empty p{

    color:#94a3b8;

    font-size:13px;

}


/* ==================================================
   FOOTER
================================================== */

footer{

    margin-top:30px;

    padding:
        40px 15px;

    color:white;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #073b31
        );

    text-align:center;

}


.footer-title{

    font-size:18px;

    font-weight:700;

    margin-bottom:12px;

}


footer p{

    margin:7px 0;

    color:
        rgba(255,255,255,.78);

    font-size:12px;

}


/* ==================================================
   SCROLL TOP
================================================== */

#scrollTop{

    position:fixed;

    right:22px;

    bottom:22px;

    width:45px;

    height:45px;

    border:none;

    border-radius:50%;

    background:#f4b942;

    color:#0b6b57;

    font-size:20px;

    font-weight:bold;

    display:none;

    z-index:999;

    box-shadow:
        0 5px 15px rgba(0,0,0,.25);

    transition:.3s;

}


#scrollTop:hover{

    transform:
        translateY(-4px);

}


/* ==================================================
   MOBILE
================================================== */

@media(max-width:767px){

    body{

        padding-top:50px;

    }


    .hero{

        padding:
            50px 15px;

    }


    .hero-icon{

        width:65px;

        height:65px;

        font-size:27px;

        border-radius:17px;

    }


    .hero h1{

        font-size:27px;

        line-height:1.25;

    }


    .hero p{

        font-size:13px;

    }


    .section{

        padding:
            45px 0;

    }


    .section-title{

        margin-bottom:28px;

    }


    .section-title h2{

        font-size:23px;

    }


    .section-title p{

        font-size:13px;

        line-height:1.6;

    }


    .prestasi-card{

        margin-bottom:22px;

        border-radius:17px;

    }


    .prestasi-image{

        height:210px;

    }


    .prestasi-content{

        padding:18px;

    }


    .prestasi-content h3{

        font-size:18px;

    }


    .prestasi-content p{

        font-size:13px;

        line-height:1.7;

    }


    .empty{

        padding:
            50px 18px;

    }


    #scrollTop{

        width:42px;

        height:42px;

        right:15px;

        bottom:15px;

    }

}


/* ==================================================
   EXTRA SMALL PHONE
================================================== */

@media(max-width:400px){

    .navbar-brand{

        font-size:14px;

    }


    .hero h1{

        font-size:24px;

    }


    .hero p{

        font-size:12px;

    }


    .prestasi-image{

        height:190px;

    }

}

</style>

    <link rel="stylesheet" href="assets/css/site.css">

</head>


<body class="site-page">


<!-- ==================================================
     NAVBAR
================================================== -->

<?php include __DIR__ . '/includes/navbar.php'; ?>


<!-- ==================================================
     HERO
================================================== -->

<section class="hero">

<div class="hero-content">


<div class="hero-icon">

<i class="fa-solid fa-trophy"></i>

</div>


<h1>

Capaian Siswa SMK Tunas Harapan

</h1>


<p>

Berbagai prestasi dan pencapaian
siswa-siswi SMK Tunas Harapan Batang Serangan

</p>


</div>

</section>


<!-- ==================================================
     DATA PRESTASI
================================================== -->

<section class="section">

<div class="container">


<div class="section-title">

<h2>

Capaian Siswa Siswa-Siswi

</h2>


<p>

Kumpulan pencapaian dan kebanggaan
SMK Tunas Harapan

</p>

</div>


<div class="row">


<?php

if(mysqli_num_rows($query) > 0){

    while(
        $data =
        mysqli_fetch_assoc($query)
    ){

?>


<div class="col-md-4 col-sm-6">


<div class="prestasi-card">


<!-- FOTO -->

<div class="prestasi-image">


<?php

if(
    !empty($data['foto']) &&
    file_exists(
        __DIR__ .
        "/uploads/prestasi/" .
        $data['foto']
    )
){

?>


<img
    src="uploads/prestasi/<?= htmlspecialchars(
        $data['foto']
    ); ?>"
    alt="<?= htmlspecialchars(
        $data['judul']
    ); ?>">


<div class="prestasi-badge">

    <i class="fa-solid fa-trophy"></i>

    PRESTASI

</div>


<?php

}else{

?>


<img
    src="images/piala.jpg"
    alt="Dokumentasi capaian siswa"
    loading="lazy">


<?php

}

?>


</div>


<!-- CONTENT -->

<div class="prestasi-content">


<h3>

<?= htmlspecialchars(
    $data['judul']
); ?>

</h3>


<p>

<?= nl2br(
    htmlspecialchars(
        $data['deskripsi']
    )
); ?>

</p>


<div class="prestasi-date">

<i class="fa-regular fa-calendar"></i>

<?= date(
    'd F Y',
    strtotime(
        $data['tanggal']
    )
); ?>

</div>


</div>

</div>


</div>


<?php

    }

}else{

?>


<div class="col-md-12">


<div class="empty">


<i class="fa-solid fa-trophy"></i>


<h4>

Belum Ada Data Capaian Siswa

</h4>


<p>

Data prestasi sekolah akan ditampilkan
di halaman ini.

</p>


</div>


</div>


<?php

}

?>


</div>

</div>

</section>


<!-- ==================================================
     FOOTER
================================================== -->

<?php include __DIR__ . '/includes/footer.php'; ?>


<!-- ==================================================
     SCROLL TOP
================================================== -->

<button
    id="scrollTop">

    ↑

</button>


<!-- ==================================================
     JAVASCRIPT
================================================== -->

<script
    src="bootstrap/js/jquery.min.js">
</script>


<script
    src="bootstrap/js/bootstrap.min.js">
</script>


<script>

/* ==================================================
   SCROLL TOP
================================================== */

window.addEventListener(
    "scroll",
    function(){

        const button =
            document.getElementById(
                "scrollTop"
            );


        if(window.scrollY > 350){

            button.style.display =
                "block";

        }else{

            button.style.display =
                "none";

        }

    }
);


document
    .getElementById("scrollTop")
    .addEventListener(
        "click",
        function(){

            window.scrollTo({

                top:0,

                behavior:"smooth"

            });

        }
    );

</script>


</body>

</html>