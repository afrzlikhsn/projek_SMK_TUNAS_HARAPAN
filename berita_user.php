<?php

include __DIR__ . "/koneksi.php";

/* ==================================================
   AMBIL SEMUA BERITA
================================================== */

$query_berita = mysqli_query(
    $koneksi,
    "SELECT * FROM berita
     ORDER BY tanggal DESC, id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
Publikasi Sekolah - SMK Tunas Harapan
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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

    background:#f5f8fc;

    color:#334155;

}


/* ==================================================
   NAVBAR
================================================== */

.navbar-custom{

    background:
        linear-gradient(
            90deg,
            #0b6b57,
            #124e8c
        );

    border:none;

    border-radius:0;

    margin:0;

    min-height:65px;

    box-shadow:
        0 4px 18px rgba(0,0,0,.15);

}


.navbar-brand{

    color:white!important;

    font-size:17px;

    font-weight:700;

    line-height:65px;

    padding:0 20px;

}


.navbar-brand i{

    margin-right:8px;

    color:#f4b942;

}


.navbar-nav>li>a{

    color:white!important;

    font-weight:600;

    line-height:65px;

    padding-top:0;

    padding-bottom:0;

    transition:.25s;

}


.navbar-nav>li>a:hover{

    background:
        rgba(255,255,255,.10)!important;

    color:#f4b942!important;

}


/* ==================================================
   PAGE HEADER
================================================== */

.page-header-custom{

    margin-top:65px;

    padding:65px 20px;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c
        );

    color:white;

    text-align:center;

}


.page-header-custom h1{

    margin:0;

    font-size:38px;

    font-weight:800;

    text-shadow:
        1px 3px 8px rgba(0,0,0,.2);

}


.page-header-custom p{

    margin-top:12px;

    font-size:15px;

    color:
        rgba(255,255,255,.85);

}


/* ==================================================
   CONTAINER
================================================== */

.news-container{

    max-width:1200px;

    margin:45px auto;

    padding:0 15px;

}


/* ==================================================
   SECTION TITLE
================================================== */

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

    border-radius:10px;

    margin:12px auto 0;

}


.section-title p{

    margin-top:12px;

    color:#64748b;

    font-size:13px;

}


/* ==================================================
   NEWS CARD
================================================== */

.news-card{

    background:white;

    border-radius:18px;

    overflow:hidden;

    margin-bottom:30px;

    border:
        1px solid #edf1f7;

    box-shadow:
        0 6px 22px rgba(15,23,42,.07);

    transition:.35s;

}


.news-card:hover{

    transform:
        translateY(-7px);

    box-shadow:
        0 15px 35px rgba(13,71,161,.15);

}


/* ==================================================
   NEWS IMAGE
================================================== */

.news-image{

    height:220px;

    position:relative;

    overflow:hidden;

    background:#f1f5f9;

}


.news-image img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.5s;

}


.news-card:hover
.news-image img{

    transform:scale(1.07);

}


/* ==================================================
   LABEL
================================================== */

.news-label{

    position:absolute;

    top:15px;

    left:15px;

    padding:6px 12px;

    background:#e53935;

    color:white;

    border-radius:20px;

    font-size:10px;

    font-weight:700;

    box-shadow:
        0 3px 8px rgba(0,0,0,.20);

}


/* ==================================================
   CONTENT
================================================== */

.news-content{

    padding:22px;

}


.news-content h3{

    margin:0 0 10px;

    color:#0b6b57;

    font-size:19px;

    font-weight:700;

    line-height:1.4;

}


.news-date{

    color:#94a3b8;

    font-size:12px;

    margin-bottom:13px;

}


.news-date i{

    color:#0b6b57;

    margin-right:5px;

}


.news-content p{

    color:#64748b;

    font-size:13px;

    line-height:1.7;

    min-height:66px;

    margin-bottom:10px;

}


/* ==================================================
   BUTTON
================================================== */

.news-button{

    display:inline-flex;

    align-items:center;

    gap:8px;

    margin-top:8px;

    padding:10px 18px;

    border-radius:25px;

    background:#0b6b57;

    color:white!important;

    text-decoration:none!important;

    font-size:12px;

    font-weight:700;

    transition:.3s;

}


.news-button:hover{

    background:#f4b942;

    color:#0b6b57!important;

    transform:
        translateX(3px);

}


/* ==================================================
   EMPTY
================================================== */

.empty-box{

    background:white;

    border-radius:18px;

    padding:65px 20px;

    text-align:center;

    box-shadow:
        0 6px 22px rgba(15,23,42,.06);

}


.empty-icon{

    width:75px;

    height:75px;

    margin:0 auto 18px;

    border-radius:50%;

    background:#eff6ff;

    color:#93c5fd;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:30px;

}


.empty-box h3{

    margin:0 0 8px;

    color:#475569;

    font-weight:700;

}


.empty-box p{

    margin:0;

    color:#94a3b8;

    font-size:13px;

}


/* ==================================================
   BACK BUTTON
================================================== */

.back-area{

    text-align:center;

    margin-top:15px;

    margin-bottom:55px;

}


.btn-back{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:11px 20px;

    border-radius:25px;

    background:white;

    border:2px solid #0b6b57;

    color:#0b6b57!important;

    text-decoration:none!important;

    font-size:12px;

    font-weight:700;

    transition:.3s;

}


.btn-back:hover{

    background:#0b6b57;

    color:white!important;

    transform:
        translateY(-2px);

}


/* ==================================================
   FOOTER
================================================== */

footer{

    padding:40px 15px;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #073b31
        );

    color:white;

    text-align:center;

}


footer p{

    margin:7px;

    color:
        rgba(255,255,255,.85);

    font-size:13px;

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px){

    .navbar-brand{

        font-size:15px;

    }

    .navbar-nav{

        background:#0b6b57;

    }

    .navbar-nav>li>a{

        line-height:45px;

    }

    .page-header-custom{

        padding:45px 15px;

    }

    .page-header-custom h1{

        font-size:29px;

    }

    .page-header-custom p{

        font-size:13px;

    }

    .news-container{

        margin-top:30px;

    }

}


@media(max-width:480px){

    .news-image{

        height:200px;

    }

    .news-content{

        padding:18px;

    }

    .news-content h3{

        font-size:17px;

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
     HEADER
================================================== -->

<section class="page-header-custom">


<h1>

<i class="fa-solid fa-newspaper"></i>

Publikasi Sekolah

</h1>


<p>

Informasi, kegiatan, dan berita terbaru
SMK Tunas Harapan Batang Serangan

</p>


</section>



<!-- ==================================================
     BERITA
================================================== -->

<div class="news-container">


<div class="section-title">


<h2>

Berita Terbaru

</h2>


<p>

Ikuti berbagai informasi dan kegiatan
terbaru dari SMK Tunas Harapan.

</p>


</div>



<div class="row">


<?php

if(
    $query_berita &&
    mysqli_num_rows($query_berita) > 0
){

    while(
        $berita =
        mysqli_fetch_assoc($query_berita)
    ){

        $foto_berita =
            !empty($berita['foto'])
            ? "images/" . $berita['foto']
            : "images/default-berita.jpg";


        $isi_berita =
            strip_tags(
                $berita['isi'] ?? ''
            );


        $ringkasan =
            mb_substr(
                $isi_berita,
                0,
                150
            );


        if(
            mb_strlen($isi_berita) > 150
        ){

            $ringkasan .= "...";

        }

?>


<div class="col-md-4 col-sm-6">


<div class="news-card">


<!-- FOTO -->

<div class="news-image">


<img
src="<?= htmlspecialchars($foto_berita); ?>"
alt="<?= htmlspecialchars($berita['judul']); ?>">


<div class="news-label">

BERITA

</div>


</div>



<!-- ISI -->

<div class="news-content">


<h3>

<?= htmlspecialchars(
    $berita['judul']
); ?>

</h3>


<div class="news-date">

<i class="fa-regular fa-calendar"></i>

<?php

if(!empty($berita['tanggal'])){

    echo date(
        'd F Y',
        strtotime(
            $berita['tanggal']
        )
    );

}else{

    echo "Tanggal tidak tersedia";

}

?>

</div>


<p>

<?= htmlspecialchars(
    $ringkasan
); ?>

</p>


<a
href="detail_berita.php?id=<?= (int)$berita['id']; ?>"
class="news-button">

Baca Selengkapnya

<i class="fa-solid fa-arrow-right"></i>

</a>


</div>

</div>


</div>


<?php

    }

}else{

?>


<div class="col-md-12">


<div class="empty-box">


<div class="empty-icon">

<i class="fa-regular fa-newspaper"></i>

</div>


<h3>

Belum Ada Berita

</h3>


<p>

Belum ada berita sekolah yang
dipublikasikan.

</p>


</div>


</div>


<?php

}

?>


</div>



<!-- ==================================================
     KEMBALI
================================================== -->

<div class="back-area">


<a
href="index.php"
class="btn-back">

<i class="fa-solid fa-arrow-left"></i>

Kembali ke Beranda

</a>


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
src="bootstrap/js/jquery.min.js">
</script>


<script
src="bootstrap/js/bootstrap.min.js">
</script>


</body>

</html>