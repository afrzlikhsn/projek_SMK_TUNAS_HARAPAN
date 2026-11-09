<?php

session_start();

/* =========================================
   CEK LOGIN ADMIN
========================================= */

if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


/* =========================================
   PROSES TAMBAH AGENDA
========================================= */

if (isset($_POST['simpan'])) {

    $judul = mysqli_real_escape_string(
        $koneksi,
        $_POST['judul']
    );

    $tanggal = mysqli_real_escape_string(
        $koneksi,
        $_POST['tanggal']
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        $_POST['deskripsi']
    );

    $foto = "";


    /* =====================================
       UPLOAD FOTO
    ===================================== */

    if (
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] == 0
    ) {

        $nama_file = $_FILES['foto']['name'];
        $tmp_file  = $_FILES['foto']['tmp_name'];

        $ext = strtolower(
            pathinfo(
                $nama_file,
                PATHINFO_EXTENSION
            )
        );

        $allowed = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if (in_array($ext, $allowed)) {

            $foto =
                time() . "_" .
                preg_replace(
                    "/[^a-zA-Z0-9.]/",
                    "_",
                    $nama_file
                );

            $folder = __DIR__ . "/images/";

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            move_uploaded_file(
                $tmp_file,
                $folder . $foto
            );
        }
    }


    /* =====================================
       INSERT DATA
    ===================================== */

    $insert = mysqli_query(
        $koneksi,
        "INSERT INTO agenda
        (judul, tanggal, deskripsi, foto)
        VALUES
        ('$judul', '$tanggal', '$deskripsi', '$foto')"
    );


    if ($insert) {

        header(
            "Location: admin_agenda.php?status=tambah"
        );

        exit;

    } else {

        $error = mysqli_error($koneksi);

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
    Tambah Kalender Kegiatan | Admin SMK Tunas Harapan
</title>


<link
    rel="stylesheet"
    href="bootstrap/css/bootstrap.min.css">

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>

/* =========================================
   GLOBAL
========================================= */

*{
    box-sizing:border-box;
}

body{
    margin:0;
    font-family:"Segoe UI",Arial,sans-serif;
    background:#f4f7fb;
    color:#1f2937;
}


/* =========================================
   SIDEBAR
========================================= */

.sidebar{

    position:fixed;

    left:0;
    top:0;

    width:250px;

    height:100vh;

    background:linear-gradient(
        180deg,
        #173b91 0%,
        #102a6b 100%
    );

    z-index:1000;

    box-shadow:
        4px 0 20px rgba(0,0,0,.12);

    overflow-y:auto;
}


/* =========================================
   LOGO
========================================= */

.logo{

    height:90px;

    display:flex;

    align-items:center;

    gap:12px;

    padding:15px 20px;

    color:white;

    background:rgba(0,0,0,.12);

    border-bottom:
        1px solid rgba(255,255,255,.10);
}

.logo-icon{

    width:48px;
    height:48px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:13px;

    background:rgba(255,255,255,.15);

    font-size:23px;
}

.logo-text{

    font-size:17px;

    font-weight:700;

    line-height:1.3;
}

.logo-text small{

    display:block;

    font-size:11px;

    font-weight:400;

    opacity:.75;

    margin-top:3px;
}


/* =========================================
   MENU
========================================= */

.sidebar ul{

    list-style:none;

    padding:18px 12px;

    margin:0;
}

.sidebar ul li{

    margin-bottom:5px;

}

.sidebar ul li a{

    display:flex;

    align-items:center;

    gap:13px;

    padding:13px 15px;

    color:rgba(255,255,255,.82);

    text-decoration:none;

    font-size:14px;

    font-weight:500;

    border-radius:10px;

    transition:.25s;
}

.sidebar ul li a i{

    width:22px;

    text-align:center;

    font-size:16px;
}

.sidebar ul li a:hover{

    color:white;

    background:rgba(255,255,255,.12);

    transform:translateX(4px);
}

.sidebar ul li.active a{

    color:#173b91;

    background:#f4b942;

    font-weight:bold;

    box-shadow:
        0 6px 15px rgba(0,0,0,.15);
}


/* =========================================
   MAIN
========================================= */

.main{

    margin-left:250px;

    min-height:100vh;
}


/* =========================================
   TOPBAR
========================================= */

.topbar{

    min-height:72px;

    padding:15px 25px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    background:white;

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);

    border-bottom:
        1px solid #edf1f7;
}

.topbar-title{

    display:flex;

    align-items:center;

    gap:13px;
}

.topbar-icon{

    width:45px;
    height:45px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:#eff6ff;

    color:#0b6b57;

    font-size:19px;
}

.topbar h3{

    margin:0;

    font-size:20px;

    font-weight:700;

    color:#172033;
}

.topbar-subtitle{

    margin-top:3px;

    font-size:12px;

    color:#94a3b8;
}

.admin-info{

    display:flex;

    align-items:center;

    gap:10px;

    padding:8px 13px;

    background:#f8fafc;

    border-radius:10px;

    color:#64748b;

    font-size:12px;
}

.admin-avatar{

    width:35px;
    height:35px;

    display:flex;

    align-items:center;
    justify-content:center;

    background:#0b6b57;

    color:white;

    border-radius:50%;
}

.admin-info b{

    display:block;

    color:#1e3a8a;

    font-size:13px;
}


/* =========================================
   CONTENT
========================================= */

.content{

    padding:30px;
}


/* =========================================
   PAGE HEADER
========================================= */

.page-header{

    padding:28px 30px;

    border-radius:17px;

    color:white;

    background:
        linear-gradient(
            135deg,
            #1e40af,
            #0b6b57,
            #3b82f6
        );

    box-shadow:
        0 10px 25px rgba(37,99,235,.20);

    margin-bottom:25px;

    position:relative;

    overflow:hidden;
}

.page-header:after{

    content:"";

    position:absolute;

    width:220px;
    height:220px;

    right:-70px;
    top:-100px;

    border-radius:50%;

    background:
        rgba(255,255,255,.08);
}

.page-header h2{

    margin:0;

    font-size:24px;

    font-weight:700;

    position:relative;

    z-index:2;
}

.page-header p{

    margin:8px 0 0;

    color:
        rgba(255,255,255,.85);

    position:relative;

    z-index:2;
}


/* =========================================
   FORM CARD
========================================= */

.form-card{

    background:white;

    padding:30px;

    border-radius:18px;

    border:
        1px solid #edf1f7;

    box-shadow:
        0 6px 25px rgba(15,23,42,.07);
}

.form-title{

    display:flex;

    align-items:center;

    gap:12px;

    margin-bottom:25px;

    padding-bottom:18px;

    border-bottom:
        1px solid #edf1f7;
}

.form-title-icon{

    width:45px;
    height:45px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:#eff6ff;

    color:#0b6b57;

    font-size:18px;
}

.form-title h3{

    margin:0;

    font-size:18px;

    color:#1e293b;

    font-weight:700;
}

.form-title p{

    margin:3px 0 0;

    color:#94a3b8;

    font-size:12px;
}


/* =========================================
   FORM
========================================= */

.form-group{

    margin-bottom:22px;
}

.form-group label{

    display:block;

    margin-bottom:8px;

    color:#334155;

    font-size:13px;

    font-weight:600;
}

.form-control{

    height:45px;

    border:
        1px solid #dbe3ee;

    border-radius:10px;

    box-shadow:none;

    padding:10px 13px;

    transition:.25s;
}

.form-control:focus{

    border-color:#0b6b57;

    box-shadow:
        0 0 0 3px
        rgba(37,99,235,.10);
}

textarea.form-control{

    height:140px;

    resize:vertical;

    line-height:1.6;
}


/* =========================================
   FILE INPUT
========================================= */

.file-info{

    margin-top:7px;

    color:#94a3b8;

    font-size:11px;
}


/* =========================================
   BUTTON
========================================= */

.form-actions{

    display:flex;

    gap:10px;

    margin-top:10px;

    padding-top:20px;

    border-top:
        1px solid #edf1f7;
}

.btn-save{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    min-height:44px;

    padding:0 20px;

    border:none;

    border-radius:10px;

    background:
        linear-gradient(
            135deg,
            #1e40af,
            #0b6b57
        );

    color:white;

    font-weight:700;

    box-shadow:
        0 5px 15px
        rgba(37,99,235,.20);

    transition:.25s;
}

.btn-save:hover{

    transform:translateY(-2px);

    color:white;

    box-shadow:
        0 8px 20px
        rgba(37,99,235,.30);
}

.btn-cancel{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    min-height:44px;

    padding:0 20px;

    border-radius:10px;

    background:#f1f5f9;

    color:#475569!important;

    text-decoration:none!important;

    font-weight:600;

    transition:.25s;
}

.btn-cancel:hover{

    background:#e2e8f0;

    transform:translateY(-2px);
}


/* =========================================
   ERROR
========================================= */

.alert-error{

    background:#fef2f2;

    border:
        1px solid #fecaca;

    color:#b91c1c;

    padding:13px 15px;

    border-radius:10px;

    margin-bottom:20px;

    font-size:13px;
}


/* =========================================
   FOOTER
========================================= */

.footer{

    text-align:center;

    padding:25px;

    color:#94a3b8;

    font-size:12px;
}


/* =========================================
   RESPONSIVE
========================================= */

@media(max-width:900px){

    .sidebar{

        width:70px;
    }

    .logo{

        height:70px;

        justify-content:center;

        padding:10px;
    }

    .logo-text{

        display:none;
    }

    .logo-icon{

        width:42px;
        height:42px;
    }

    .sidebar ul{

        padding:12px 8px;
    }

    .sidebar ul li a{

        justify-content:center;

        padding:13px 8px;
    }

    .sidebar ul li a span{

        display:none;
    }

    .sidebar ul li a i{

        font-size:17px;
    }

    .main{

        margin-left:70px;
    }

    .content{

        padding:20px;
    }

}


@media(max-width:600px){

    .content{

        padding:12px;
    }

    .topbar{

        padding:12px 15px;
    }

    .topbar h3{

        font-size:16px;
    }

    .admin-info div:last-child{

        display:none;
    }

    .page-header{

        padding:22px;
    }

    .page-header h2{

        font-size:20px;
    }

    .form-card{

        padding:20px;
    }

    .form-actions{

        flex-direction:column;
    }

    .btn-save,
    .btn-cancel{

        width:100%;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<!-- =========================================
     SIDEBAR
========================================= -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<!-- CONTENT -->

    <div class="content">


        <!-- HEADER -->

        <div class="page-header">

            <h2>

                <i class="fa-solid fa-calendar-plus"></i>

                Tambah Kalender Kegiatan

            </h2>

            <p>

                Tambahkan kegiatan atau agenda terbaru
                SMK Tunas Harapan ke dalam sistem.

            </p>

        </div>


        <!-- ERROR -->

        <?php if(isset($error)){ ?>

            <div class="alert-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                Gagal menyimpan data:

                <?= htmlspecialchars($error); ?>

            </div>

        <?php } ?>


        <!-- FORM -->

        <div class="form-card">


            <div class="form-title">

                <div class="form-title-icon">

                    <i class="fa-solid fa-calendar-days"></i>

                </div>

                <div>

                    <h3>
                        Informasi Kalender Kegiatan
                    </h3>

                    <p>
                        Isi informasi agenda dengan lengkap.
                    </p>

                </div>

            </div>


            <form
                method="POST"
                enctype="multipart/form-data">


                <div class="row">


                    <!-- JUDUL -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>

                                <i class="fa-solid fa-heading"></i>

                                Judul Kalender Kegiatan

                            </label>

                            <input
                                type="text"
                                name="judul"
                                class="form-control"
                                placeholder="Contoh: Upacara Bendera"
                                required>

                        </div>

                    </div>


                    <!-- TANGGAL -->

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>

                                <i class="fa-solid fa-calendar"></i>

                                Tanggal Kalender Kegiatan

                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                class="form-control"
                                required>

                        </div>

                    </div>


                </div>


                <!-- DESKRIPSI -->

                <div class="form-group">

                    <label>

                        <i class="fa-solid fa-align-left"></i>

                        Deskripsi Kalender Kegiatan

                    </label>

                    <textarea
                        name="deskripsi"
                        class="form-control"
                        placeholder="Tuliskan informasi atau keterangan mengenai agenda..."
                        required></textarea>

                </div>


                <!-- FOTO -->

                <div class="form-group">

                    <label>

                        <i class="fa-solid fa-image"></i>

                        Foto Kalender Kegiatan

                    </label>

                    <input
                        type="file"
                        name="foto"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                    <div class="file-info">

                        <i class="fa-solid fa-circle-info"></i>

                        Format yang diperbolehkan:
                        JPG, JPEG, PNG, WEBP.

                    </div>

                </div>


                <!-- BUTTON -->

                <div class="form-actions">


                    <button
                        type="submit"
                        name="simpan"
                        class="btn-save">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Kalender Kegiatan

                    </button>


                    <a
                        href="admin_agenda.php"
                        class="btn-cancel">

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali ke Kalender Kegiatan

                    </a>


                </div>


            </form>


        </div>


        <!-- FOOTER -->

        <div class="footer">

            Copyright © <?= date('Y'); ?>

            SMK Tunas Harapan

            <br>

            Sistem Informasi Administrator

        </div>


    </div>

</main>


<script
    src="bootstrap/js/jquery.min.js">
</script>

<script
    src="bootstrap/js/bootstrap.min.js">
</script>


</body>

</html>