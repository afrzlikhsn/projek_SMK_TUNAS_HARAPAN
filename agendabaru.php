<?php

include __DIR__ . "/koneksi.php";


/* ==================================================
   AMBIL DATA AGENDA
================================================== */

$query_agenda = mysqli_query(
    $koneksi,
    "SELECT *
     FROM agenda
     ORDER BY tanggal DESC, id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="utf-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Kalender Kegiatan - SMK Tunas Harapan</title>


<link
    href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">


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
        0 3px 15px rgba(0,0,0,.20);

    min-height:60px;
}


.navbar-header{

    min-height:60px;
}


.navbar-brand{

    color:white!important;

    font-size:17px;

    font-weight:bold;

    line-height:30px;

    transition:.3s;
}


.navbar-brand:hover{

    color:#f4b942!important;
}


.navbar-brand .glyphicon{

    margin-right:7px;
}


/* MENU */

.navbar-nav>li>a{

    color:white!important;

    font-weight:bold;

    padding-top:20px;

    padding-bottom:20px;

    transition:.3s;
}


/* HOVER */

.navbar-nav>li>a:hover{

    background:#0b3d91!important;

    color:#f4b942!important;

    transform:translateY(-2px);
}


/* ACTIVE */

.navbar-nav>.active>a,
.navbar-nav>.active>a:hover,
.navbar-nav>.active>a:focus{

    background:#0b3d91!important;

    color:#f4b942!important;
}


/* ICON */

.navbar-nav>li>a .glyphicon{

    margin-right:5px;
}


/* TOGGLE */

.navbar-toggle{

    border:none;

    margin-top:13px;
}


.navbar-toggle:hover,
.navbar-toggle:focus{

    background:#0b3d91!important;
}


.navbar-toggle .icon-bar{

    background:white;
}


/* ==================================================
   HEADER AGENDA
================================================== */

.agenda-header{

    position:relative;

    padding:75px 20px;

    text-align:center;

    color:white;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c
        );

    overflow:hidden;
}


/* BULATAN DEKORASI */

.agenda-header:before{

    content:"";

    position:absolute;

    width:300px;

    height:300px;

    border-radius:50%;

    background:
        rgba(255,255,255,.06);

    top:-150px;

    right:-80px;
}


.agenda-header:after{

    content:"";

    position:absolute;

    width:220px;

    height:220px;

    border-radius:50%;

    background:
        rgba(255,213,79,.08);

    bottom:-120px;

    left:-60px;
}


/* HEADER CONTENT */

.agenda-header-content{

    position:relative;

    z-index:2;

    animation:
        fadeUp .8s ease;
}


@keyframes fadeUp{

    from{

        opacity:0;

        transform:
            translateY(25px);
    }

    to{

        opacity:1;

        transform:
            translateY(0);
    }

}


/* ICON */

.header-icon{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    width:75px;

    height:75px;

    margin-bottom:18px;

    border-radius:50%;

    background:#f4b942;

    color:#0b6b57;

    font-size:30px;

    box-shadow:
        0 8px 25px rgba(0,0,0,.20);

}


/* TITLE */

.agenda-header h1{

    margin:0;

    font-size:38px;

    font-weight:800;

    letter-spacing:.5px;
}


.agenda-header p{

    margin-top:12px;

    margin-bottom:0;

    font-size:16px;

    opacity:.92;
}


/* ==================================================
   AGENDA SECTION
================================================== */

.agenda-section{

    max-width:1200px;

    margin:
        50px auto;

    padding:
        0 15px;
}


/* GRID */

.agenda-grid{

    display:grid;

    grid-template-columns:
        repeat(3,minmax(0,1fr));

    gap:30px;
}


/* ==================================================
   AGENDA CARD
================================================== */

.agenda-card{

    background:white;

    border-radius:20px;

    overflow:hidden;

    box-shadow:
        0 7px 25px rgba(15,23,42,.08);

    transition:
        transform .3s ease,
        box-shadow .3s ease;

    height:100%;

    display:flex;

    flex-direction:column;

    border:
        1px solid #edf1f7;

    animation:
        cardFade .7s ease;
}


@keyframes cardFade{

    from{

        opacity:0;

        transform:
            translateY(20px);
    }

    to{

        opacity:1;

        transform:
            translateY(0);
    }

}


.agenda-card:hover{

    transform:
        translateY(-8px);

    box-shadow:
        0 18px 40px rgba(13,71,161,.16);
}


/* ==================================================
   FOTO
================================================== */

.agenda-image{

    height:220px;

    position:relative;

    overflow:hidden;

    background:#e2e8f0;
}


.agenda-image img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.5s;
}


.agenda-card:hover
.agenda-image img{

    transform:
        scale(1.06);
}


/* ==================================================
   LABEL
================================================== */

.agenda-label{

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
        0 4px 10px rgba(0,0,0,.12);
}


/* ==================================================
   CONTENT
================================================== */

.agenda-content{

    padding:22px;

    flex:1;

    display:flex;

    flex-direction:column;
}


/* DATE */

.agenda-date{

    color:#94a3b8;

    font-size:12px;

    margin-bottom:10px;
}


.agenda-date .glyphicon{

    margin-right:5px;

    color:#124e8c;
}


/* TITLE */

.agenda-content h3{

    margin:
        0 0 12px;

    color:#0b6b57;

    font-size:20px;

    font-weight:800;

    line-height:1.4;
}


/* DESCRIPTION */

.agenda-content p{

    color:#64748b;

    font-size:13px;

    line-height:1.8;

    margin:0;
}


/* ==================================================
   EMPTY
================================================== */

.empty-agenda{

    grid-column:
        1 / -1;

    background:white;

    padding:65px 20px;

    border-radius:20px;

    text-align:center;

    box-shadow:
        0 7px 25px rgba(15,23,42,.07);

    border:
        1px solid #edf1f7;
}


.empty-agenda .glyphicon{

    font-size:55px;

    color:#cbd5e1;

    margin-bottom:15px;
}


.empty-agenda h3{

    color:#64748b;

    font-weight:700;

    margin-bottom:10px;
}


.empty-agenda p{

    color:#94a3b8;

    font-size:13px;
}


/* ==================================================
   QUOTE
================================================== */

.quote{

    max-width:1000px;

    margin:
        20px auto 60px;

    padding:40px;

    background:
        linear-gradient(
            135deg,
            #0b6b57,
            #124e8c
        );

    border-radius:22px;

    text-align:center;

    color:white;

    box-shadow:
        0 10px 30px rgba(13,71,161,.20);

    position:relative;

    overflow:hidden;
}


.quote:before{

    content:"";

    position:absolute;

    width:180px;

    height:180px;

    border-radius:50%;

    background:
        rgba(255,255,255,.06);

    top:-90px;

    right:-50px;
}


.quote h3{

    position:relative;

    z-index:2;

    margin:0;

    font-size:21px;

    font-weight:500;

    line-height:1.7;
}


.quote span{

    position:relative;

    z-index:2;

    display:block;

    margin-top:15px;

    color:#f4b942;

    font-weight:700;
}


/* ==================================================
   FOOTER
================================================== */

footer{

    padding:
        40px 15px;

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


footer strong{

    color:white;
}


/* ==================================================
   RESPONSIVE TABLET
================================================== */

@media(max-width:991px){

    .agenda-grid{

        grid-template-columns:
            repeat(2,minmax(0,1fr));

        gap:22px;
    }

}


/* ==================================================
   RESPONSIVE HP
================================================== */

@media(max-width:767px){

    body{

        padding-top:50px;
    }


    .navbar{

        min-height:50px;
    }


    .navbar-header{

        min-height:50px;
    }


    .navbar-brand{

        font-size:15px;

        line-height:20px;

        padding-top:15px;
    }


    .navbar-toggle{

        margin-top:8px;
    }


    .navbar-collapse{

        border:none;
    }


    .navbar-nav{

        margin-top:0;

        margin-bottom:0;

        background:#0b6b57;
    }


    .navbar-nav>li>a{

        padding:
            13px 20px!important;

        transform:none!important;
    }


    .navbar-nav>li>a:hover{

        transform:none!important;

        background:#0b3d91!important;
    }


    .agenda-header{

        padding:
            55px 15px;
    }


    .agenda-header h1{

        font-size:28px;
    }


    .agenda-header p{

        font-size:14px;

        line-height:1.6;
    }


    .header-icon{

        width:60px;

        height:60px;

        font-size:25px;
    }


    .agenda-section{

        margin:
            35px auto;

        padding:
            0 12px;
    }


    .agenda-grid{

        grid-template-columns:1fr;

        gap:22px;
    }


    .agenda-card{

        border-radius:17px;
    }


    .agenda-image{

        height:210px;
    }


    .agenda-content{

        padding:18px;
    }


    .agenda-content h3{

        font-size:18px;
    }


    .agenda-content p{

        font-size:13px;

        line-height:1.7;
    }


    .quote{

        margin:
            30px 12px 45px;

        padding:
            30px 20px;

        border-radius:18px;
    }


    .quote h3{

        font-size:17px;

        line-height:1.7;
    }


    footer{

        padding:
            30px 15px;
    }


    footer p{

        font-size:12px;

        line-height:1.7;
    }

}


/* ==================================================
   HP KECIL
================================================== */

@media(max-width:400px){

    .agenda-header h1{

        font-size:24px;
    }


    .agenda-image{

        height:190px;
    }


    .agenda-content h3{

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

<section class="agenda-header">

<div class="agenda-header-content">


<div class="header-icon">

<span class="glyphicon glyphicon-calendar"></span>

</div>


<h1>
    AGENDA SEKOLAH
</h1>


<p>
    Kegiatan dan agenda terbaru SMK Tunas Harapan Batang Serangan
</p>


</div>

</section>


<!-- ==================================================
     AGENDA
================================================== -->

<section class="agenda-section">


<div class="agenda-grid">


<?php

if(
    $query_agenda &&
    mysqli_num_rows($query_agenda) > 0
){

    while(
        $agenda =
        mysqli_fetch_assoc($query_agenda)
    ){

        $foto = "images/gerbang.jpg";
        if (!empty($agenda['foto'])) {
            $candidate = "images/" . basename($agenda['foto']);
            if (file_exists(__DIR__ . "/" . $candidate)) {
                $foto = $candidate;
            }
        }

?>


<div class="agenda-card">


<div class="agenda-image">


<img
    src="<?= htmlspecialchars($foto); ?>"
    alt="<?= htmlspecialchars($agenda['judul']); ?>">


<div class="agenda-label">

    AGENDA

</div>


</div>


<div class="agenda-content">


<div class="agenda-date">

<span class="glyphicon glyphicon-calendar"></span>

<?= date(
    'd F Y',
    strtotime(
        $agenda['tanggal']
    )
); ?>


</div>


<h3>

<?= htmlspecialchars(
    $agenda['judul']
); ?>

</h3>


<p>

<?= nl2br(
    htmlspecialchars(
        $agenda['deskripsi']
    )
); ?>

</p>


</div>

</div>


<?php

    }

}else{

?>


<div class="empty-agenda">


<span class="glyphicon glyphicon-calendar"></span>


<h3>

    Belum Ada Kalender Kegiatan

</h3>


<p>

    Kalender Kegiatan kegiatan sekolah belum ditambahkan
    oleh administrator.

</p>


</div>


<?php

}

?>


</div>

</section>


<!-- ==================================================
     QUOTE
================================================== -->

<div class="container">


<div class="quote">


<h3>

"Kesuksesan bukan hanya tentang hasil,
tetapi juga tentang proses belajar
di setiap langkah."

</h3>


<span>

    SMK Tunas Harapan Batang Serangan

</span>


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