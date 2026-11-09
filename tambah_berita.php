<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

/* ==============================
   KONEKSI DATABASE
============================== */

include __DIR__ . "/koneksi.php";


/* ==============================
   PROSES SIMPAN BERITA
============================== */

if(isset($_POST['simpan'])){

    $judul = mysqli_real_escape_string(
        $koneksi,
        $_POST['judul']
    );

    $isi = mysqli_real_escape_string(
        $koneksi,
        $_POST['isi']
    );

    $tanggal = mysqli_real_escape_string(
        $koneksi,
        $_POST['tanggal']
    );


    /* ==============================
       UPLOAD FOTO
    ============================== */

    $foto = "";

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){

        $nama_file = $_FILES['foto']['name'];

        $tmp_file = $_FILES['foto']['tmp_name'];

        $ukuran_file = $_FILES['foto']['size'];


        $ekstensi = strtolower(
            pathinfo(
                $nama_file,
                PATHINFO_EXTENSION
            )
        );


        $ekstensi_diizinkan = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];


        if(!in_array($ekstensi, $ekstensi_diizinkan)){

            die("Format foto tidak diizinkan.");

        }


        if($ukuran_file > 5000000){

            die("Ukuran foto maksimal 5 MB.");

        }


        /* Nama foto dibuat unik */

        $foto = time() . "_" .
                preg_replace(
                    "/[^a-zA-Z0-9._-]/",
                    "_",
                    $nama_file
                );


        $folder_upload = __DIR__ . "/images/";


        if(!is_dir($folder_upload)){

            mkdir(
                $folder_upload,
                0777,
                true
            );

        }


        move_uploaded_file(
            $tmp_file,
            $folder_upload . $foto
        );

    }


    /* ==============================
       SIMPAN KE DATABASE
    ============================== */

    $query = mysqli_query(
        $koneksi,
        "INSERT INTO berita
        (judul, isi, foto, tanggal)
        VALUES
        ('$judul', '$isi', '$foto', '$tanggal')"
    );


    if($query){

        header("Location: berita.php");
        exit;

    }else{

        echo "Gagal menyimpan berita: " .
             mysqli_error($koneksi);

    }

}

?>


<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Tambah Berita - SMK Tunas Harapan</title>


<link
rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<style>

*{
    box-sizing:border-box;
}

body{

    margin:0;

    background:#ecf0f5;

    font-family:
        'Segoe UI',
        sans-serif;

}


/* ==============================
   SIDEBAR
============================== */

.sidebar{

    position:fixed;

    left:0;

    top:0;

    width:240px;

    height:100vh;

    background:#1e3a8a;

}

.logo{

    padding:20px;

    text-align:center;

    font-size:22px;

    font-weight:bold;

    color:white;

    background:#163172;

}

.logo span{

    font-size:35px;

    display:block;

    margin-bottom:10px;

}


.sidebar ul{

    list-style:none;

    padding:0;

    margin:0;

}


.sidebar ul li{

    border-bottom:
        1px solid
        rgba(255,255,255,.08);

}


.sidebar ul li a{

    display:block;

    padding:15px 20px;

    color:white;

    text-decoration:none;

    transition:.3s;

    font-size:15px;

}


.sidebar ul li a:hover{

    background:#0b6b57;

    padding-left:28px;

}


.sidebar ul li.active{

    background:#0b6b57;

}


/* ==============================
   CONTENT
============================== */

.content{

    margin-left:240px;

    padding:25px;

}


/* ==============================
   TOPBAR
============================== */

.topbar{

    background:white;

    padding:15px 25px;

    border-radius:10px;

    box-shadow:
        0 2px 10px
        rgba(0,0,0,.08);

    display:flex;

    justify-content:
        space-between;

    align-items:center;

}


.topbar h3{

    margin:0;

    font-weight:bold;

}


/* ==============================
   BOX
============================== */

.box{

    background:white;

    margin-top:25px;

    padding:25px;

    border-radius:12px;

    box-shadow:
        0 5px 12px
        rgba(0,0,0,.08);

}


.box h3{

    margin-top:0;

    font-weight:bold;

    color:#1e3a8a;

}


/* ==============================
   FORM
============================== */

.form-group label{

    font-weight:bold;

}


.form-control{

    border-radius:6px;

    height:42px;

}


textarea.form-control{

    height:250px;

    resize:vertical;

}


/* ==============================
   BUTTON
============================== */

.btn-simpan{

    background:#0b6b57;

    color:white;

    border:none;

    border-radius:6px;

    padding:11px 20px;

}


.btn-simpan:hover{

    background:#095844;

    color:white;

}


.btn-kembali{

    background:#6b7280;

    color:white;

    border:none;

    border-radius:6px;

    padding:11px 20px;

}


.btn-kembali:hover{

    background:#4b5563;

    color:white;

}


/* ==============================
   RESPONSIVE
============================== */

@media(max-width:768px){

    .sidebar{

        width:200px;

    }

    .content{

        margin-left:200px;

    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<!-- ==============================
     SIDEBAR
============================== -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<div class="content">


    <div class="topbar">


        <h3>

            <span
            class="glyphicon glyphicon-plus">
            </span>

            Tambah Berita

        </h3>


        <div>

            <b>
                <?= htmlspecialchars(
                    $_SESSION['username']
                ); ?>
            </b>

            (

            <?= htmlspecialchars(
                $_SESSION['role']
            ); ?>

            )

        </div>


    </div>


    <!-- ==============================
         FORM
    ============================== -->

    <div class="box">


        <h3>

            <span
            class="glyphicon glyphicon-bullhorn">
            </span>

            Tambah Publikasi Sekolah

        </h3>


        <hr>


        <form
        method="POST"
        enctype="multipart/form-data">


            <!-- JUDUL -->

            <div class="form-group">

                <label>
                    Judul Berita
                </label>


                <input
                type="text"
                name="judul"
                class="form-control"
                placeholder="Masukkan judul berita"
                required>

            </div>


            <!-- TANGGAL -->

            <div class="form-group">

                <label>
                    Tanggal
                </label>


                <input
                type="date"
                name="tanggal"
                class="form-control"
                value="<?= date('Y-m-d'); ?>"
                required>

            </div>


            <!-- FOTO -->

            <div class="form-group">

                <label>
                    Foto Berita
                </label>


                <input
                type="file"
                name="foto"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp">


                <p class="help-block">

                    Format:
                    JPG, JPEG, PNG, WEBP.
                    Maksimal 5 MB.

                </p>

            </div>


            <!-- ISI -->

            <div class="form-group">

                <label>
                    Isi Berita
                </label>


                <textarea
                name="isi"
                class="form-control"
                placeholder="Tulis isi berita di sini..."
                required></textarea>

            </div>


            <hr>


            <!-- BUTTON -->

            <button
            type="submit"
            name="simpan"
            class="btn btn-simpan">

                <span
                class="glyphicon glyphicon-save">
                </span>

                Simpan Berita

            </button>


            <a
            href="berita.php"
            class="btn btn-kembali">

                <span
                class="glyphicon glyphicon-arrow-left">
                </span>

                Kembali

            </a>


        </form>

    </div>

</div>


</body>

</html>