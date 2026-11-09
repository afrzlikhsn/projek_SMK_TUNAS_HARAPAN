<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


/* ==================================================
   HITUNG PESAN
================================================== */

$jumlah_pesan = 0;

$query_pesan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM pesan_masuk"
);

if($query_pesan){
    $data_pesan = mysqli_fetch_assoc($query_pesan);
    $jumlah_pesan = $data_pesan['total'];
}


/* ==================================================
   TAMBAH AGENDA
================================================== */

if(isset($_POST['tambah'])){

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


    if(
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] == 0
    ){

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

        if(in_array($ext,$allowed)){

            $foto =
                time() . "_" .
                preg_replace(
                    "/[^a-zA-Z0-9.]/",
                    "_",
                    $nama_file
                );

            move_uploaded_file(
                $tmp_file,
                __DIR__ . "/images/" . $foto
            );
        }
    }


    mysqli_query(
        $koneksi,
        "INSERT INTO agenda
        (judul,tanggal,deskripsi,foto)
        VALUES
        ('$judul','$tanggal','$deskripsi','$foto')"
    );


    header(
        "Location: admin_agenda.php?status=tambah"
    );

    exit;
}


/* ==================================================
   HAPUS AGENDA
================================================== */

if(isset($_GET['hapus'])){

    $id = (int)$_GET['hapus'];


    $cek = mysqli_query(
        $koneksi,
        "SELECT foto FROM agenda WHERE id=$id"
    );


    if($cek){

        $data = mysqli_fetch_assoc($cek);


        if(
            !empty($data['foto']) &&
            file_exists(
                __DIR__ .
                "/images/" .
                $data['foto']
            )
        ){

            unlink(
                __DIR__ .
                "/images/" .
                $data['foto']
            );
        }
    }


    mysqli_query(
        $koneksi,
        "DELETE FROM agenda WHERE id=$id"
    );


    header(
        "Location: admin_agenda.php?status=hapus"
    );

    exit;
}


/* ==================================================
   DATA AGENDA
================================================== */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM agenda
     ORDER BY tanggal DESC, id DESC"
);

$total_agenda = $query
    ? mysqli_num_rows($query)
    : 0;

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
    Kalender Kegiatan | Admin SMK Tunas Harapan
</title>


<link
rel="stylesheet"
href="bootstrap/css/bootstrap.min.css">


<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>

/* ==================================================
   GLOBAL
================================================== */

*{
    box-sizing:border-box;
}

body{
    margin:0;
    font-family:"Segoe UI",Arial,sans-serif;
    background:#f4f7fb;
    color:#1f2937;
}


/* ==================================================
   SIDEBAR
================================================== */

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


/* ==================================================
   LOGO
================================================== */

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


/* ==================================================
   SIDEBAR MENU
================================================== */

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

    color:white;

    background:linear-gradient(
        135deg,
        #3b82f6,
        #0b6b57
    );

    box-shadow:
        0 6px 15px rgba(37,99,235,.30);
}


/* ==================================================
   BADGE PESAN
================================================== */

.badge-pesan{

    margin-left:auto;

    min-width:23px;

    height:23px;

    padding:0 6px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#ef4444;

    color:white;

    border-radius:50px;

    font-size:10px;

    font-weight:bold;
}


/* ==================================================
   MAIN
================================================== */

.main{

    margin-left:250px;

    min-height:100vh;
}


/* ==================================================
   TOPBAR
================================================== */

.topbar{

    min-height:72px;

    padding:15px 25px;

    background:white;

    display:flex;

    align-items:center;

    justify-content:space-between;

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);
}

.topbar-title{

    display:flex;

    align-items:center;

    gap:12px;

    font-size:20px;

    font-weight:700;

    color:#172033;
}

.topbar-icon{

    width:45px;
    height:45px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:12px;

    background:#fff7ed;

    color:#f59e0b;

    font-size:20px;
}

.topbar-title span{

    display:block;

    font-size:12px;

    color:#94a3b8;

    font-weight:normal;

    margin-top:3px;
}

.topbar-right{

    display:flex;

    align-items:center;

    gap:12px;
}

.admin-badge{

    padding:8px 13px;

    background:#eff6ff;

    color:#0b6b57;

    border-radius:20px;

    font-size:11px;

    font-weight:bold;
}


/* ==================================================
   CONTENT
================================================== */

.content{

    padding:25px 30px;
}


/* ==================================================
   PAGE HEADER
================================================== */

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

    position:relative;

    overflow:hidden;

    margin-bottom:25px;
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
}

.page-header p{

    margin:8px 0 0;

    opacity:.85;

    font-size:13px;
}


/* ==================================================
   STAT
================================================== */

.stat-card{

    background:white;

    border-radius:16px;

    padding:20px;

    margin-bottom:25px;

    display:flex;

    align-items:center;

    gap:15px;

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);
}

.stat-icon{

    width:52px;
    height:52px;

    border-radius:14px;

    display:flex;

    align-items:center;
    justify-content:center;

    background:#fff7ed;

    color:#f59e0b;

    font-size:23px;
}

.stat-card small{

    color:#94a3b8;
}

.stat-card h3{

    margin:3px 0 0;

    color:#172033;

    font-weight:700;
}


/* ==================================================
   TABLE CARD
================================================== */

.table-card{

    background:white;

    border-radius:18px;

    padding:25px;

    box-shadow:
        0 6px 25px rgba(15,23,42,.07);
}


/* ==================================================
   TOOLBAR
================================================== */

.toolbar{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

    flex-wrap:wrap;

    margin-bottom:22px;
}

.toolbar-title h3{

    margin:0;

    color:#172033;

    font-weight:700;

    font-size:18px;
}

.toolbar-title p{

    margin:5px 0 0;

    color:#94a3b8;

    font-size:12px;
}


/* ==================================================
   BUTTON TAMBAH
================================================== */

.btn-add{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    min-height:42px;

    padding:0 18px;

    border-radius:10px;

    color:white!important;

    text-decoration:none!important;

    background:
        linear-gradient(
            135deg,
            #1e40af,
            #0b6b57
        );

    font-weight:700;

    font-size:13px;

    box-shadow:
        0 5px 15px rgba(37,99,235,.22);

    transition:.25s;
}

.btn-add:hover{

    transform:translateY(-2px);

    box-shadow:
        0 8px 20px rgba(37,99,235,.3);
}


/* ==================================================
   TABLE
================================================== */

.table-responsive{

    border-radius:12px;

    overflow-x:auto;
}

.table-modern{

    width:100%;

    min-width:850px;

    border-collapse:separate;

    border-spacing:0;
}

.table-modern thead th{

    padding:14px 12px;

    background:#173b91;

    color:white;

    border:none;

    font-size:12px;

    text-transform:uppercase;

    white-space:nowrap;
}

.table-modern thead th:first-child{

    border-radius:10px 0 0 0;
}

.table-modern thead th:last-child{

    border-radius:0 10px 0 0;
}

.table-modern tbody td{

    padding:14px 12px;

    vertical-align:middle;

    border-bottom:1px solid #edf1f7;
}

.table-modern tbody tr{

    transition:.2s;
}

.table-modern tbody tr:hover{

    background:#f8fbff;
}


/* ==================================================
   FOTO
================================================== */

.agenda-thumb{

    width:75px;

    height:55px;

    object-fit:cover;

    border-radius:10px;

    box-shadow:
        0 3px 10px rgba(0,0,0,.12);
}


/* ==================================================
   JUDUL
================================================== */

.agenda-title{

    font-weight:700;

    color:#17365d;

    margin-bottom:5px;
}

.agenda-description{

    color:#94a3b8;

    font-size:12px;

    max-width:300px;

    line-height:1.5;
}


/* ==================================================
   TANGGAL
================================================== */

.agenda-date{

    white-space:nowrap;

    color:#64748b;

    font-size:12px;
}

.agenda-date i{

    color:#f59e0b;

    margin-right:5px;
}


/* ==================================================
   AKSI
================================================== */

.action-wrapper{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    white-space:nowrap;
}

.action-btn{

    height:36px;

    min-width:72px;

    padding:0 11px;

    border-radius:8px;

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    text-decoration:none!important;

    font-size:12px;

    font-weight:700;

    transition:.25s;
}


/* EDIT */

.btn-edit{

    background:#fff7ed;

    color:#d97706!important;
}

.btn-edit:hover{

    background:#f59e0b;

    color:white!important;

    transform:translateY(-2px);
}


/* HAPUS */

.btn-delete{

    background:#fef2f2;

    color:#dc2626!important;
}

.btn-delete:hover{

    background:#dc2626;

    color:white!important;

    transform:translateY(-2px);
}


/* ==================================================
   EMPTY
================================================== */

.empty{

    text-align:center;

    padding:50px 20px;

    color:#94a3b8;
}

.empty i{

    font-size:45px;

    margin-bottom:12px;

    color:#cbd5e1;
}


/* ==================================================
   FOOTER
================================================== */

.footer{

    padding:25px;

    text-align:center;

    color:#94a3b8;

    font-size:12px;
}


/* ==================================================
   MOBILE
================================================== */

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

    .sidebar ul{

        padding:12px 8px;
    }

    .sidebar ul li a{

        justify-content:center;

        padding:13px 8px;
    }

    .sidebar ul li a span:not(.badge-pesan){

        display:none;
    }

    .sidebar ul li a i{

        font-size:17px;
    }

    .badge-pesan{

        position:absolute;

        margin-left:28px;

        margin-top:-25px;

        min-width:17px;

        height:17px;

        font-size:8px;
    }

    .main{

        margin-left:70px;
    }

    .content{

        padding:20px 15px;
    }

}


@media(max-width:600px){

    .topbar{

        padding:12px 15px;

        display:block;
    }

    .topbar-right{

        margin-top:10px;
    }

    .content{

        padding:15px 10px;
    }

    .page-header{

        padding:22px;
    }

    .page-header h2{

        font-size:20px;
    }

    .table-card{

        padding:17px;
    }

    .toolbar{

        align-items:stretch;
    }

    .btn-add{

        width:100%;
    }

}


/* ==================================================
   SCROLLBAR
================================================== */

.sidebar::-webkit-scrollbar{

    width:5px;
}

.sidebar::-webkit-scrollbar-thumb{

    background:rgba(255,255,255,.2);

    border-radius:10px;
}

/* ==================================================
   LAYOUT FIX - ADMIN SIDEBAR + CONTENT
================================================== */
.admin-main .content{
    margin-left:0;
    padding:0;
}
.admin-main{
    min-width:0;
}
@media(max-width:900px){
    .admin-main .content{padding:0;}
}
</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<!-- ==================================================
     SIDEBAR
================================================== -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<div class="admin-overlay" id="adminOverlay"></div>

<main class="admin-main">

<!-- CONTENT -->

    <div class="content">


        <!-- HEADER -->

        <div class="page-header">

            <h2>

                <i class="fa-solid fa-calendar-days"></i>

                Kalender Kegiatan

            </h2>

            <p>

                Kelola jadwal dan kegiatan sekolah
                melalui panel administrator.

            </p>

        </div>



        <!-- STAT -->

        <div class="row">

            <div class="col-md-4">

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                    <div>

                        <small>
                            Total Kalender Kegiatan
                        </small>

                        <h3>
                            <?= $total_agenda; ?>
                        </h3>

                    </div>

                </div>

            </div>

        </div>



        <!-- ==================================================
             MENU AGENDA
        ================================================== -->

        <div class="table-card">


            <div class="toolbar">


                <div class="toolbar-title">

                    <h3>

                        <i class="fa-solid fa-list-check"></i>

                        Daftar Kalender Kegiatan

                    </h3>

                    <p>

                        Semua agenda kegiatan SMK Tunas Harapan
                        yang tersimpan dalam sistem.

                    </p>

                </div>


                <!-- BUTTON TAMBAH -->

                <a
                    href="tambah_agenda.php"
                    class="btn-add">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Kalender Kegiatan

                </a>


            </div>



            <!-- TABLE -->

            <div class="table-responsive">


                <table class="table-modern">


                    <thead>

                        <tr>

                            <th style="width:60px;text-align:center;">
                                No
                            </th>

                            <th style="width:100px;">
                                Foto
                            </th>

                            <th>
                                Kalender Kegiatan
                            </th>

                            <th style="width:150px;">
                                Tanggal
                            </th>

                            <th style="width:190px;text-align:center;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php

                    $no = 1;

                    if(
                        $query &&
                        mysqli_num_rows($query) > 0
                    ){

                        while(
                            $agenda =
                            mysqli_fetch_assoc($query)
                        ){

                            $foto =
                                !empty($agenda['foto'])
                                ? "images/" . $agenda['foto']
                                : "images/default-agenda.jpg";

                    ?>


                        <tr>


                            <!-- NO -->

                            <td style="text-align:center;">

                                <strong>

                                    <?= $no++; ?>

                                </strong>

                            </td>


                            <!-- FOTO -->

                            <td>

                                <img
                                    src="<?= htmlspecialchars($foto); ?>"
                                    class="agenda-thumb"
                                    alt="Foto Kalender Kegiatan">

                            </td>


                            <!-- AGENDA -->

                            <td>

                                <div class="agenda-title">

                                    <?= htmlspecialchars(
                                        $agenda['judul']
                                    ); ?>

                                </div>

                                <div class="agenda-description">

                                    <?= htmlspecialchars(
                                        mb_substr(
                                            $agenda['deskripsi'],
                                            0,
                                            100
                                        )
                                    ); ?>

                                    <?= strlen(
                                        $agenda['deskripsi']
                                    ) > 100 ? '...' : ''; ?>

                                </div>

                            </td>


                            <!-- TANGGAL -->

                            <td>

                                <div class="agenda-date">

                                    <i class="fa-regular fa-calendar"></i>

                                    <?= date(
                                        'd-m-Y',
                                        strtotime(
                                            $agenda['tanggal']
                                        )
                                    ); ?>

                                </div>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <div class="action-wrapper">


                                    <a
                                        href="edit_agenda.php?id=<?= $agenda['id']; ?>"
                                        class="action-btn btn-edit">

                                        <i class="fa-solid fa-pen"></i>

                                        Edit

                                    </a>


                                    <a
                                        href="admin_agenda.php?hapus=<?= $agenda['id']; ?>"
                                        class="action-btn btn-delete"

                                        onclick="return confirm(
                                        'Yakin ingin menghapus agenda <?= htmlspecialchars($agenda['judul']); ?>?'
                                        );">

                                        <i class="fa-solid fa-trash"></i>

                                        Hapus

                                    </a>


                                </div>

                            </td>


                        </tr>


                    <?php

                        }

                    }else{

                    ?>


                        <tr>

                            <td colspan="5">

                                <div class="empty">

                                    <i class="fa-regular fa-calendar-xmark"></i>

                                    <h4>
                                        Belum Ada Kalender Kegiatan
                                    </h4>

                                    <p>
                                        Silakan tambahkan agenda kegiatan
                                        sekolah terlebih dahulu.
                                    </p>

                                    <a
                                        href="tambah_agenda.php"
                                        class="btn-add">

                                        <i class="fa-solid fa-plus"></i>

                                        Tambah Kalender Kegiatan

                                    </a>

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