<?php

include __DIR__ . "/koneksi.php";

/* ==================================================
   CEK ID BERITA
================================================== */

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];


/* ==================================================
   AMBIL DATA BERITA
================================================== */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM berita WHERE id = $id LIMIT 1"
);


/* ==================================================
   CEK DATA
================================================== */

if (!$query || mysqli_num_rows($query) == 0) {

    header("Location: index.php");
    exit;

}

$berita = mysqli_fetch_assoc($query);


/* ==================================================
   DATA
================================================== */

$judul = $berita['judul'] ?? '';
$isi = $berita['isi'] ?? '';
$tanggal = $berita['tanggal'] ?? '';
$foto = $berita['foto'] ?? '';

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
<?= htmlspecialchars($judul); ?> - SMK Tunas Harapan
</title>


<!-- BOOTSTRAP -->

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<!-- FONT AWESOME -->

<link rel="stylesheet"
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

body{

    font-family:'Segoe UI',Arial,sans-serif;

    background:#f4f7fb;

    color:#1f2937;

}


/* ==================================================
   NAVBAR
================================================== */

.navbar-custom{

    background:linear-gradient(
        135deg,
        #173b91,
        #102a6b
    );

    border:0;

    border-radius:0;

    margin:0;

    min-height:70px;

    box-shadow:
        0 4px 18px rgba(0,0,0,.12);

}


.navbar-brand{

    color:white!important;

    font-weight:700;

    font-size:18px;

    line-height:70px;

    padding:0 20px;

}


.navbar-brand i{

    margin-right:8px;

}


.navbar-nav>li>a{

    color:rgba(255,255,255,.85)!important;

    line-height:70px;

    padding-top:0;

    padding-bottom:0;

    font-size:13px;

}


.navbar-nav>li>a:hover{

    background:rgba(255,255,255,.10)!important;

    color:white!important;

}


/* ==================================================
   CONTAINER
================================================== */

.detail-container{

    max-width:950px;

    margin:35px auto;

    padding:0 15px;

}


/* ==================================================
   DETAIL CARD
================================================== */

.detail-card{

    background:white;

    border-radius:18px;

    border:1px solid #edf1f7;

    box-shadow:
        0 8px 30px rgba(15,23,42,.07);

    overflow:hidden;

}


/* ==================================================
   FOTO
================================================== */

.detail-image{

    width:100%;

    max-height:500px;

    object-fit:cover;

    display:block;

}


.no-image{

    width:100%;

    height:300px;

    display:flex;

    align-items:center;

    justify-content:center;

    flex-direction:column;

    gap:10px;

    background:#f8fafc;

    color:#cbd5e1;

}


.no-image i{

    font-size:55px;

}


.no-image span{

    font-size:13px;

    color:#94a3b8;

}


/* ==================================================
   CONTENT
================================================== */

.detail-content{

    padding:35px 40px 40px;

}


.detail-category{

    display:inline-flex;

    align-items:center;

    gap:7px;

    padding:7px 12px;

    border-radius:50px;

    background:#eff6ff;

    color:#0b6b57;

    font-size:11px;

    font-weight:600;

    margin-bottom:15px;

}


.detail-title{

    margin:0 0 15px;

    color:#172033;

    font-size:32px;

    font-weight:750;

    line-height:1.3;

}


.detail-date{

    display:flex;

    align-items:center;

    gap:7px;

    color:#94a3b8;

    font-size:12px;

    padding-bottom:22px;

    border-bottom:1px solid #edf1f7;

}


.detail-date i{

    color:#0b6b57;

}


/* ==================================================
   ISI BERITA
================================================== */

.detail-text{

    margin-top:25px;

    color:#475569;

    font-size:15px;

    line-height:1.9;

    word-wrap:break-word;

}


/*
   Jika admin menggunakan Enter,
   paragraf tetap terlihat rapi.
*/

.detail-text p{

    margin-bottom:18px;

}


.detail-text img{

    max-width:100%;

    height:auto;

}


/* ==================================================
   FOOTER
================================================== */

.footer{

    margin-top:40px;

    padding:25px 15px;

    text-align:center;

    color:#94a3b8;

    font-size:12px;

}


.footer hr{

    border:0;

    border-top:1px solid #e2e8f0;

    margin-bottom:18px;

}


/* ==================================================
   BUTTON KEMBALI
================================================== */

.btn-kembali{

    display:inline-flex;

    align-items:center;

    gap:8px;

    margin-top:25px;

    padding:11px 17px;

    border-radius:10px;

    background:#f1f5f9;

    color:#475569;

    text-decoration:none;

    font-size:12px;

    font-weight:600;

    transition:.2s;

}


.btn-kembali:hover{

    background:#0b6b57;

    color:white;

    text-decoration:none;

    transform:translateX(-3px);

}


/* ==================================================
   RESPONSIVE
================================================== */

@media(max-width:768px){

    .navbar-brand{

        font-size:15px;

    }

    .navbar-nav>li>a{

        line-height:45px;

    }

    .detail-container{

        margin-top:20px;

    }

    .detail-content{

        padding:25px 22px 30px;

    }

    .detail-title{

        font-size:25px;

    }

    .detail-text{

        font-size:14px;

        line-height:1.8;

    }

}


@media(max-width:480px){

    .detail-image{

        max-height:300px;

    }

    .detail-content{

        padding:22px 18px 25px;

    }

    .detail-title{

        font-size:22px;

    }

    .detail-text{

        font-size:13px;

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
     DETAIL BERITA
================================================== -->

<div class="detail-container">



    <!-- CARD -->

    <article class="detail-card">


        <!-- FOTO -->

        <?php if(!empty($foto)){ ?>

            <img

                src="images/<?= htmlspecialchars($foto); ?>"

                class="detail-image"

                alt="<?= htmlspecialchars($judul); ?>">


        <?php }else{ ?>


            <div class="no-image">

                <i class="fa-regular fa-image"></i>

                <span>

                    Tidak ada foto berita

                </span>

            </div>


        <?php } ?>



        <!-- CONTENT -->

        <div class="detail-content">


            <div class="detail-category">

                <i class="fa-solid fa-bullhorn"></i>

                BERITA SEKOLAH

            </div>


            <h1 class="detail-title">

                <?= htmlspecialchars($judul); ?>

            </h1>


            <div class="detail-date">

                <i class="fa-regular fa-calendar"></i>

                <?php

                if(!empty($tanggal)){

                    echo date(
                        'd F Y',
                        strtotime($tanggal)
                    );

                }else{

                    echo "Tanggal tidak tersedia";

                }

                ?>

            </div>


            <!-- ISI BERITA -->

            <div class="detail-text">

                <?= nl2br(htmlspecialchars($isi)); ?>

            </div>


            <!-- KEMBALI -->

            <a href="index.php"
               class="btn-kembali">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali ke Berita

            </a>


        </div>


    </article>



    <!-- FOOTER -->

    <?php include __DIR__ . '/includes/footer.php'; ?>


</div>


</body>

</html>