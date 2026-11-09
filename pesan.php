<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


/* ==========================
   HAPUS PESAN
========================== */

if(isset($_GET['hapus'])){

    $id = intval($_GET['hapus']);

    mysqli_query(
        $koneksi,
        "DELETE FROM pesan_masuk WHERE id='$id'"
    );

    header("Location: pesan.php");
    exit;
}


/* ==========================
   AMBIL DATA PESAN
========================== */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pesan_masuk ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Pesan Masuk - SMK Tunas Harapan</title>


<link
rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:#ecf0f5;

    font-family:'Segoe UI',sans-serif;
}


/* ==========================
SIDEBAR
========================== */

.sidebar{

    position:fixed;

    left:0;
    top:0;

    width:240px;

    height:100vh;

    background:#1e3a8a;

    overflow:auto;

    z-index:1000;
}

.logo{

    padding:20px;

    text-align:center;

    font-size:21px;

    font-weight:bold;

    color:white;

    background:#163172;
}

.logo span{

    display:block;

    font-size:35px;

    margin-bottom:10px;
}

.sidebar ul{

    list-style:none;

    margin:0;

    padding:0;
}

.sidebar ul li{

    border-bottom:
    1px solid rgba(255,255,255,.08);
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

.sidebar ul li a .glyphicon{

    width:25px;
}


/* ==========================
CONTENT
========================== */

.content{

    margin-left:240px;

    padding:25px;
}


/* ==========================
TOPBAR
========================== */

.topbar{

    background:white;

    padding:18px 25px;

    border-radius:10px;

    box-shadow:
    0 2px 10px rgba(0,0,0,.08);

    display:flex;

    justify-content:space-between;

    align-items:center;
}

.topbar h3{

    margin:0;

    font-weight:bold;
}

.admin-info{

    color:#666;
}

.admin-info b{

    color:#1e3a8a;
}


/* ==========================
BOX
========================== */

.box{

    background:white;

    margin-top:25px;

    padding:25px;

    border-radius:12px;

    box-shadow:
    0 5px 12px rgba(0,0,0,.08);
}

.box-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:20px;
}

.box-header h3{

    margin:0;

    font-weight:bold;

    color:#1e3a8a;
}


/* ==========================
TABLE
========================== */

.table{

    margin-bottom:0;
}

.table th{

    background:#1e3a8a;

    color:white;

    text-align:center;

    vertical-align:middle!important;
}

.table td{

    vertical-align:middle!important;
}

.table-hover tbody tr:hover{

    background:#f4f8ff;
}


/* ==========================
BUTTON
========================== */

.btn-hapus{

    background:#dc2626;

    color:white;

    border:none;
}

.btn-hapus:hover{

    background:#b91c1c;

    color:white;
}


/* ==========================
PESAN KOSONG
========================== */

.empty{

    text-align:center;

    padding:50px;

    color:#888;
}

.empty .glyphicon{

    font-size:55px;

    color:#ccc;

    display:block;

    margin-bottom:15px;
}


/* ==========================
RESPONSIVE
========================== */

@media(max-width:768px){

    .sidebar{

        width:200px;
    }

    .content{

        margin-left:200px;

        padding:15px;
    }

    .topbar{

        display:block;
    }

    .admin-info{

        margin-top:10px;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<!-- ==========================
SIDEBAR
========================== -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<div class="content">


    <!-- TOPBAR -->

    <div class="topbar">

        <h3>

            <span class="glyphicon glyphicon-envelope"></span>

            Pesan Masuk

        </h3>


        <div class="admin-info">

            Login sebagai:

            <b>

                <?= htmlspecialchars($_SESSION['username']); ?>

            </b>

            &nbsp;

            (

            <?= htmlspecialchars($_SESSION['role']); ?>

            )

        </div>

    </div>



    <!-- ==========================
    DATA PESAN
    ========================== -->

    <div class="box">


        <div class="box-header">

            <h3>

                Daftar Pesan dari Pengunjung

            </h3>

        </div>


        <div class="table-responsive">


            <table class="table table-bordered table-hover">


                <thead>

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th width="150">
                            Nama
                        </th>

                        <th width="200">
                            Email
                        </th>

                        <th>
                            Pesan
                        </th>

                        <th width="160">
                            Tanggal
                        </th>

                        <th width="100">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php

                $no = 1;

                if(mysqli_num_rows($query) > 0){

                    while($data = mysqli_fetch_assoc($query)){

                ?>


                    <tr>


                        <td class="text-center">

                            <?= $no++; ?>

                        </td>


                        <td>

                            <?= htmlspecialchars($data['nama']); ?>

                        </td>


                        <td>

                            <?= htmlspecialchars($data['email']); ?>

                        </td>


                        <td>

                            <?= nl2br(
                                htmlspecialchars($data['pesan'])
                            ); ?>

                        </td>


                        <td class="text-center">

                            <?= htmlspecialchars($data['tanggal']); ?>

                        </td>


                        <td class="text-center">


                            <a

                                href="pesan.php?hapus=<?= $data['id']; ?>"

                                class="btn btn-danger btn-sm btn-hapus"

                                onclick="return confirm('Yakin ingin menghapus pesan ini?');"

                            >

                                <span class="glyphicon glyphicon-trash"></span>

                                Hapus

                            </a>


                        </td>


                    </tr>


                <?php

                    }

                }else{

                ?>


                    <tr>

                        <td
                            colspan="6"
                            class="empty">

                            <span
                                class="glyphicon glyphicon-envelope">
                            </span>

                            <strong>
                                Belum ada pesan masuk.
                            </strong>

                            <br>

                            Pesan dari halaman Contact
                            akan muncul di sini.

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

    <div style="
        text-align:center;
        margin-top:35px;
        color:#777;
    ">

        <hr>

        Copyright © <?= date('Y'); ?>

        SMK Tunas Harapan

    </div>


</div>


</body>

</html>