<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="utf-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
    PPDB Online - SMK Tunas Harapan
</title>

<link
    href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">

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

    min-height:60px;

    box-shadow:
        0 4px 18px rgba(0,0,0,.18);

}


.navbar-brand{

    color:white!important;

    font-size:17px;

    font-weight:700;

    line-height:20px;

    padding-top:20px;

    padding-bottom:20px;

}


.navbar-brand span{

    margin-right:7px;

}


.navbar-brand:hover{

    color:#f4b942!important;

}


.navbar-toggle{

    border:none;

    background:transparent!important;

    margin-top:13px;

}


.navbar-toggle:hover,
.navbar-toggle:focus{

    background:
        rgba(255,255,255,.10)!important;

}


.navbar-toggle .icon-bar{

    background:white;

    width:23px;

    height:2px;

}


.navbar-nav>li>a{

    color:white!important;

    font-weight:600;

    padding-top:20px;

    padding-bottom:20px;

    transition:.25s;

}


.navbar-nav>li>a:hover{

    background:
        rgba(255,255,255,.10)!important;

    color:#f4b942!important;

}


.navbar-nav>.active>a{

    background:
        rgba(0,0,0,.18)!important;

    color:#f4b942!important;

}


/* ==================================================
   HERO PPDB
================================================== */

.ppdb-hero{

    position:relative;

    min-height:500px;

    display:flex;

    align-items:center;

    overflow:hidden;

    background:

        linear-gradient(
            135deg,
            rgba(7,45,95,.95),
            rgba(13,71,161,.90)
        ),

        url("images/gerbang.jpg")
        center/cover no-repeat;

}


.ppdb-hero:before{

    content:"";

    position:absolute;

    width:450px;

    height:450px;

    border-radius:50%;

    background:
        rgba(255,213,79,.08);

    right:-180px;

    top:-180px;

}


.ppdb-hero:after{

    content:"";

    position:absolute;

    width:300px;

    height:300px;

    border-radius:50%;

    background:
        rgba(255,255,255,.05);

    left:-160px;

    bottom:-160px;

}


.ppdb-content{

    position:relative;

    z-index:2;

    color:white;

    max-width:850px;

    padding:
        60px 15px;

}


.ppdb-badge{

    display:inline-flex;

    align-items:center;

    gap:7px;

    padding:
        8px 15px;

    border-radius:30px;

    background:
        rgba(255,255,255,.12);

    border:
        1px solid
        rgba(255,255,255,.25);

    font-size:12px;

    font-weight:700;

    margin-bottom:18px;

}


.ppdb-content h1{

    font-size:48px;

    line-height:1.15;

    font-weight:800;

    margin:
        0 0 15px;

    text-shadow:
        2px 4px 12px rgba(0,0,0,.25);

}


.ppdb-content h1 span{

    display:block;

    color:#f4b942;

}


.ppdb-content p{

    max-width:690px;

    font-size:17px;

    line-height:1.8;

    color:
        rgba(255,255,255,.92);

    margin-bottom:0;

}


/* ==================================================
   HERO BUTTON
================================================== */

.ppdb-buttons{

    display:flex;

    flex-wrap:wrap;

    gap:12px;

    margin-top:27px;

}


.btn-daftar{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    padding:
        13px 22px;

    min-height:48px;

    background:#f4b942;

    color:#0b6b57!important;

    border-radius:30px;

    text-decoration:none!important;

    font-size:13px;

    font-weight:800;

    box-shadow:
        0 7px 20px
        rgba(0,0,0,.15);

    transition:.3s;

}


.btn-daftar:hover{

    background:white;

    transform:
        translateY(-3px);

}


.btn-cek{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    padding:
        12px 22px;

    min-height:48px;

    border:
        2px solid
        rgba(255,255,255,.8);

    color:white!important;

    border-radius:30px;

    text-decoration:none!important;

    font-size:13px;

    font-weight:700;

    transition:.3s;

}


.btn-cek:hover{

    background:white;

    color:#0b6b57!important;

}


/* ==================================================
   QUICK INFO
================================================== */

.quick-info{

    position:relative;

    margin-top:-55px;

    z-index:5;

}


.quick-card{

    background:white;

    border-radius:18px;

    padding:
        22px 15px;

    box-shadow:
        0 12px 35px
        rgba(15,23,42,.12);

    border:
        1px solid #eef2f7;

}


.quick-item{

    text-align:center;

    padding:8px;

}


.quick-icon{

    width:52px;

    height:52px;

    margin:0 auto 10px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#e5f5f1;

    color:#0b6b57;

    font-size:21px;

}


.quick-item strong{

    display:block;

    color:#0b6b57;

    font-size:14px;

    margin-bottom:4px;

}


.quick-item span{

    display:block;

    color:#64748b;

    font-size:11px;

}


/* ==================================================
   SECTION
================================================== */

.section{

    max-width:1100px;

    margin:
        65px auto;

    padding:
        0 15px;

}


.section-title{

    text-align:center;

    margin-bottom:35px;

}


.section-title h2{

    margin:0;

    color:#0b6b57;

    font-size:30px;

    font-weight:800;

}


.section-title h2:after{

    content:"";

    display:block;

    width:65px;

    height:4px;

    background:#f4b942;

    border-radius:10px;

    margin:
        12px auto 0;

}


.section-title p{

    margin-top:14px;

    color:#64748b;

    font-size:14px;

}


/* ==================================================
   INFORMATION CARDS
================================================== */

.info-grid{

    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:22px;

}


.info-card{

    background:white;

    border-radius:18px;

    padding:25px;

    height:100%;

    border:
        1px solid #edf2f7;

    box-shadow:
        0 7px 25px
        rgba(15,23,42,.06);

    transition:.3s;

}


.info-card:hover{

    transform:
        translateY(-6px);

    box-shadow:
        0 15px 35px
        rgba(13,71,161,.12);

}


.info-icon{

    width:58px;

    height:58px;

    border-radius:16px;

    background:#e5f5f1;

    color:#0b6b57;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:25px;

    margin-bottom:18px;

}


.info-card h3{

    margin:
        0 0 10px;

    font-size:19px;

    color:#0b6b57;

    font-weight:750;

}


.info-card p{

    margin:0;

    color:#64748b;

    font-size:13px;

    line-height:1.8;

}


/* ==================================================
   ALUR PENDAFTARAN
================================================== */

.process-section{

    background:white;

    padding:
        65px 15px;

}


.process-grid{

    max-width:1050px;

    margin:auto;

    display:grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:20px;

}


.process-card{

    text-align:center;

    position:relative;

    padding:20px 12px;

}


.process-number{

    width:55px;

    height:55px;

    margin:
        0 auto 15px;

    border-radius:50%;

    background:#0b6b57;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    font-weight:800;

    box-shadow:
        0 5px 15px
        rgba(13,71,161,.2);

}


.process-card h4{

    margin:
        0 0 8px;

    font-size:16px;

    color:#0b6b57;

    font-weight:700;

}


.process-card p{

    color:#64748b;

    font-size:12px;

    line-height:1.6;

    margin:0;

}


/* ==================================================
   PERSYARATAN
================================================== */

.requirement-box{

    max-width:850px;

    margin:auto;

    background:white;

    border-radius:20px;

    padding:25px;

    box-shadow:
        0 7px 25px
        rgba(15,23,42,.06);

}


.requirement-item{

    display:flex;

    align-items:center;

    gap:13px;

    padding:14px;

    margin-bottom:10px;

    background:#f7f9fc;

    border-radius:12px;

    border:
        1px solid #edf1f5;

    color:#475569;

    font-size:13px;

}


.requirement-item:last-child{

    margin-bottom:0;

}


.check{

    width:34px;

    height:34px;

    min-width:34px;

    border-radius:50%;

    background:#0b6b57;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

}


/* ==================================================
   CTA
================================================== */

.cta{

    max-width:1100px;

    margin:
        65px auto;

    padding:
        0 15px;

}


.cta-box{

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c
        );

    border-radius:22px;

    padding:
        45px 25px;

    text-align:center;

    color:white;

    box-shadow:
        0 12px 35px
        rgba(13,71,161,.2);

}


.cta-box:before{

    content:"";

    position:absolute;

    width:220px;

    height:220px;

    border-radius:50%;

    background:
        rgba(255,255,255,.06);

    right:-100px;

    top:-100px;

}


.cta-box h2{

    position:relative;

    z-index:2;

    margin:
        0 0 10px;

    font-size:27px;

    font-weight:800;

}


.cta-box p{

    position:relative;

    z-index:2;

    color:
        rgba(255,255,255,.85);

    margin-bottom:22px;

    font-size:14px;

}


/* ==================================================
   FOOTER
================================================== */

footer{

    margin-top:70px;

    padding:
        35px 15px;

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

}


footer strong{

    color:white;

}


/* ==================================================
   MOBILE
================================================== */

@media(max-width:767px){

    body{

        padding-top:50px;

    }


    .navbar{

        min-height:50px;

    }


    .navbar-brand{

        font-size:15px;

        padding-top:15px;

        padding-bottom:15px;

    }


    .navbar-toggle{

        margin-top:8px;

    }


    .navbar-collapse{

        background:#0b6b57;

        border:none;

        box-shadow:
            0 10px 20px
            rgba(0,0,0,.15);

    }


    .navbar-nav{

        margin:0;

    }


    .navbar-nav>li>a{

        padding:
            13px 20px!important;

    }


    .ppdb-hero{

        min-height:570px;

        text-align:center;

    }


    .ppdb-content{

        padding:
            55px 18px;

        width:100%;

    }


    .ppdb-badge{

        font-size:10px;

        padding:
            8px 12px;

    }


    .ppdb-content h1{

        font-size:34px;

        line-height:1.2;

    }


    .ppdb-content p{

        font-size:14px;

        line-height:1.75;

    }


    .ppdb-buttons{

        flex-direction:column;

        width:100%;

    }


    .btn-daftar,
    .btn-cek{

        width:100%;

    }


    .quick-info{

        margin-top:-35px;

        padding:
            0 12px;

    }


    .quick-card{

        padding:10px 5px;

    }


    .quick-item{

        padding:
            13px 5px;

    }


    .quick-icon{

        width:45px;

        height:45px;

        font-size:18px;

    }


    .quick-item strong{

        font-size:12px;

    }


    .quick-item span{

        font-size:9px;

    }


    .section{

        margin:
            48px auto;

        padding:
            0 12px;

    }


    .section-title{

        margin-bottom:28px;

    }


    .section-title h2{

        font-size:24px;

    }


    .section-title p{

        font-size:12px;

    }


    .info-grid{

        grid-template-columns:1fr;

        gap:16px;

    }


    .info-card{

        padding:21px;

    }


    .process-section{

        padding:
            48px 12px;

    }


    .process-grid{

        grid-template-columns:
            repeat(2,1fr);

        gap:8px;

    }


    .process-card{

        padding:18px 8px;

    }


    .process-number{

        width:48px;

        height:48px;

        font-size:17px;

    }


    .process-card h4{

        font-size:14px;

    }


    .process-card p{

        font-size:11px;

    }


    .requirement-box{

        padding:18px;

        border-radius:17px;

    }


    .requirement-item{

        align-items:flex-start;

        font-size:12px;

        line-height:1.6;

    }


    .cta{

        margin:
            45px auto;

        padding:
            0 12px;

    }


    .cta-box{

        padding:
            35px 18px;

        border-radius:18px;

    }


    .cta-box h2{

        font-size:23px;

        line-height:1.3;

    }


    .cta-box p{

        font-size:13px;

        line-height:1.7;

    }


    .cta-box .btn-daftar{

        width:100%;

    }


    footer{

        margin-top:45px;

        padding:
            28px 15px;

        font-size:12px;

    }

}


/* ==================================================
   SMALL PHONE
================================================== */

@media(max-width:400px){

    .ppdb-content h1{

        font-size:30px;

    }


    .ppdb-content p{

        font-size:13px;

    }


    .process-grid{

        grid-template-columns:1fr 1fr;

    }


    .quick-item span{

        display:none;

    }

}

</style>

    <link rel="stylesheet" href="assets/css/site.css">

</head>


<body>


<!-- ==================================================
     NAVBAR
     SAMA DENGAN INDEX.PHP
================================================== -->

<?php include __DIR__ . '/includes/navbar.php'; ?>


<!-- ==================================================
     HERO
================================================== -->

<section class="ppdb-hero">

<div class="container">

<div class="ppdb-content">


<div class="ppdb-badge">

<span class="glyphicon glyphicon-bullhorn"></span>

PENERIMAAN PESERTA DIDIK BARU

</div>


<h1>

PPDB Online

<span>2026 / 2027</span>

</h1>


<p>

Daftarkan putra-putri Anda menjadi bagian
dari keluarga besar SMK Tunas Harapan Batang Serangan.
Proses pendaftaran sekarang lebih mudah,
cepat, dan dapat dilakukan langsung melalui HP
tanpa harus datang ke sekolah.

</p>


<div class="ppdb-buttons">


<a
    href="daftar_ppdb.php"
    class="btn-daftar">

    <span class="glyphicon glyphicon-user"></span>

    Daftar Sekarang

</a>


<a
    href="cek_ppdb.php"
    class="btn-cek">

    <span class="glyphicon glyphicon-search"></span>

    Cek Status Pendaftaran

</a>

<a
    href="login_ppdb.php"
    class="btn-cek">

    <span class="glyphicon glyphicon-log-in"></span>

    Login Akun Peserta

</a>


</div>

</div>

</div>

</section>


<!-- ==================================================
     QUICK INFO
================================================== -->

<div class="quick-info">

<div class="container">

<div class="quick-card">

<div class="row">


<div class="col-xs-4">

<div class="quick-item">

<div class="quick-icon">

<span class="glyphicon glyphicon-phone"></span>

</div>

<strong>
Lewat HP
</strong>

<span>
Tanpa antre
</span>

</div>

</div>


<div class="col-xs-4">

<div class="quick-item">

<div class="quick-icon">

<span class="glyphicon glyphicon-flash"></span>

</div>

<strong>
Cepat
</strong>

<span>
Proses praktis
</span>

</div>

</div>


<div class="col-xs-4">

<div class="quick-item">

<div class="quick-icon">

<span class="glyphicon glyphicon-lock"></span>

</div>

<strong>
Aman
</strong>

<span>
Data tersimpan
</span>

</div>

</div>


</div>

</div>

</div>

</div>


<!-- ==================================================
     INFORMASI
================================================== -->

<section class="section">

<div class="section-title">

<h2>

Mengapa PPDB Online?

</h2>

<p>

Pendaftaran dibuat sederhana agar orang tua
lebih mudah mendaftarkan putra-putrinya.

</p>

</div>


<div class="info-grid">


<div class="info-card">

<div class="info-icon">

<span class="glyphicon glyphicon-phone"></span>

</div>

<h3>

Daftar dari HP

</h3>

<p>

Orang tua dapat mengisi formulir pendaftaran
langsung melalui smartphone kapan saja
tanpa harus datang ke sekolah.

</p>

</div>


<div class="info-card">

<div class="info-icon">

<span class="glyphicon glyphicon-time"></span>

</div>

<h3>

Hemat Waktu

</h3>

<p>

Data calon siswa langsung masuk ke sistem
sehingga proses administrasi menjadi
lebih cepat dan terorganisir.

</p>

</div>


<div class="info-card">

<div class="info-icon">

<span class="glyphicon glyphicon-check"></span>

</div>

<h3>

Mudah Dipantau

</h3>

<p>

Orang tua dapat mengecek status pendaftaran
menggunakan nomor pendaftaran yang diberikan
setelah proses pengisian formulir.

</p>

</div>


</div>

</section>


<!-- ==================================================
     ALUR PENDAFTARAN
================================================== -->

<section class="process-section">

<div class="section-title">

<h2>

Alur Pendaftaran

</h2>

<p>

Ikuti langkah sederhana berikut.

</p>

</div>


<div class="process-grid">


<div class="process-card">

<div class="process-number">
1
</div>

<h4>
Isi Formulir
</h4>

<p>
Lengkapi data calon peserta didik.
</p>

</div>


<div class="process-card">

<div class="process-number">
2
</div>

<h4>
Upload Dokumen
</h4>

<p>
Masukkan dokumen persyaratan.
</p>

</div>


<div class="process-card">

<div class="process-number">
3
</div>

<h4>
Kirim Data
</h4>

<p>
Periksa kembali lalu kirim.
</p>

</div>


<div class="process-card">

<div class="process-number">
4
</div>

<h4>
Cek Status
</h4>

<p>
Pantau proses pendaftaran.
</p>

</div>


</div>

</section>


<!-- ==================================================
     PERSYARATAN
================================================== -->

<section class="section">

    <div class="section-title">

        <h2>
            Persyaratan Pendaftaran
        </h2>

        <p>
            TINGKAT SMK — Siapkan dokumen berikut sebelum melakukan pendaftaran.
        </p>

    </div>


    <div class="requirement-box">

        <!-- 1 -->
        <div class="requirement-item">

            <div class="check">
                <span class="glyphicon glyphicon-ok"></span>
            </div>

            <div>
                <strong>
                    1. Mengisi Formulir Pendaftaran
                </strong>

                <br>

                Lengkapi formulir pendaftaran peserta didik dengan data yang benar dan lengkap.

            </div>

        </div>


        <!-- 2 -->
        <div class="requirement-item">

            <div class="check">
                <span class="glyphicon glyphicon-ok"></span>
            </div>

            <div>
                <strong>
                    2. Foto Copy Akte Kelahiran
                </strong>

                <br>

                2 lembar jika ada.

            </div>

        </div>


        <!-- 3 -->
        <div class="requirement-item">

            <div class="check">
                <span class="glyphicon glyphicon-ok"></span>
            </div>

            <div>
                <strong>
                    3. Foto Copy Kartu Keluarga
                </strong>

                <br>

                2 lembar.

            </div>

        </div>


        <!-- 4 -->
        <div class="requirement-item">

            <div class="check">
                <span class="glyphicon glyphicon-ok"></span>
            </div>

            <div>
                <strong>
                    4. Foto Copy KTP Ayah dan Ibu
                </strong>

                <br>

                2 lembar.

            </div>

        </div>
        <!-- 5 -->
        <div class="requirement-item"><div class="check"><span class="glyphicon glyphicon-ok"></span></div><div><strong>5. Surat Keterangan Lulus / Ijazah</strong><br>Siapkan dokumen kelulusan dari sekolah asal.</div></div>

        <!-- 6 -->
        <div class="requirement-item">

            <div class="check">
                <span class="glyphicon glyphicon-ok"></span>
            </div>

            <div>
                <strong>
                    6. Pas Foto 3x4
                </strong>

                <br>

                2 lembar dengan latar belakang merah.

            </div>

        </div>
        <!-- 7 -->
        <div class="requirement-item"><div class="check"><span class="glyphicon glyphicon-ok"></span></div><div><strong>7. Memilih Kompetensi Keahlian</strong><br>Pilih kompetensi keahlian yang sesuai dengan minat dan rencana pendidikan.</div></div>

    </div>

</section>



<!-- ==================================================
     CTA
================================================== -->

<section class="cta">

<div class="cta-box">


<h2>

Sudah Siap Mendaftarkan Putra-Putri Anda?

</h2>


<p>

Yuk, lakukan pendaftaran sekarang.
Mudah, cepat, dan bisa dilakukan dari HP.

</p>


<a
    href="daftar_ppdb.php"
    class="btn-daftar">

    <span class="glyphicon glyphicon-arrow-right"></span>

    Mulai Pendaftaran

</a>


</div>

</section>


<!-- ==================================================
     FOOTER
================================================== -->

<?php include __DIR__ . '/includes/footer.php'; ?>


<script
    src="bootstrap/js/jquery.min.js">
</script>


<script
    src="bootstrap/js/bootstrap.min.js">
</script>


</body>

</html>