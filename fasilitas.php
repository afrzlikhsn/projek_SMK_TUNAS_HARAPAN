<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM fasilitas ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Sarana Sekolah - Admin</title>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

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


/* SIDEBAR */

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#173b91,#102a6b);
    z-index:1000;
    box-shadow:4px 0 20px rgba(0,0,0,.12);
    overflow-y:auto;
}

.logo{
    height:90px;
    display:flex;
    align-items:center;
    gap:12px;
    padding:15px 20px;
    color:white;
    background:rgba(0,0,0,.12);
    border-bottom:1px solid rgba(255,255,255,.1);
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

.sidebar ul{
    list-style:none;
    padding:18px 12px;
    margin:0;
}

.sidebar li{
    margin-bottom:5px;
}

.sidebar li a{
    display:flex;
    align-items:center;
    gap:13px;
    padding:13px 15px;
    color:rgba(255,255,255,.82);
    text-decoration:none;
    border-radius:10px;
    transition:.25s;
    font-size:14px;
}

.sidebar li a:hover{
    color:white;
    background:rgba(255,255,255,.12);
    transform:translateX(4px);
}

.sidebar li.active a{
    color:white;
    background:linear-gradient(135deg,#3b82f6,#0b6b57);
    box-shadow:0 6px 15px rgba(37,99,235,.3);
}


/* CONTENT */

.content{
    margin-left:250px;
    min-height:100vh;
    padding:25px 30px;
}


/* TOPBAR */

.topbar{
    min-height:72px;
    padding:15px 22px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:white;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(15,23,42,.06);
    border:1px solid #edf1f7;
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
    background:#f5f3ff;
    color:#8b5cf6;
    font-size:19px;
}

.topbar h3{
    margin:0;
    font-size:20px;
    font-weight:700;
}

.topbar-subtitle{
    margin-top:3px;
    font-size:12px;
    color:#94a3b8;
}

.admin-info{
    display:flex;
    align-items:center;
    gap:8px;
    padding:8px 13px;
    background:#f8fafc;
    border-radius:10px;
    color:#64748b;
    font-size:12px;
}

.admin-info b{
    color:#1e3a8a;
}


/* BOX */

.box{
    margin-top:25px;
    padding:25px;
    background:white;
    border-radius:16px;
    border:1px solid #edf1f7;
    box-shadow:0 5px 20px rgba(15,23,42,.06);
}

.box-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}

.box-header h3{
    margin:0;
    font-size:18px;
    font-weight:700;
}


/* BUTTON */

.btn-tambah{
    background:#0b6b57;
    color:white;
    border:none;
    border-radius:9px;
    padding:10px 17px;
    font-weight:600;
}

.btn-tambah:hover{
    background:#095844;
    color:white;
}


/* TABLE */

.table{
    margin-bottom:0;
}

.table th{
    background:#173b91;
    color:white;
    text-align:center;
    border-color:#173b91!important;
}

.table td{
    vertical-align:middle!important;
}

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#f8fbff;
}


/* FOTO */

.foto-fasilitas{
    width:95px;
    height:65px;
    object-fit:cover;
    border-radius:10px;
    box-shadow:0 3px 8px rgba(0,0,0,.12);
}

.no-photo{
    width:95px;
    height:65px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    background:#f1f5f9;
    color:#94a3b8;
    border-radius:10px;
    font-size:20px;
}


/* BUTTON AKSI */

.btn-edit{
    background:#f59e0b;
    color:white;
    border:none;
    border-radius:7px;
}

.btn-hapus{
    background:#ef4444;
    color:white;
    border:none;
    border-radius:7px;
}

.btn-edit:hover,
.btn-hapus:hover{
    color:white;
    opacity:.9;
}


/* EMPTY */

.empty{
    text-align:center;
    padding:50px 20px!important;
    color:#94a3b8;
}

.empty i{
    font-size:45px;
    margin-bottom:15px;
    color:#cbd5e1;
}

.empty h4{
    color:#64748b;
    font-weight:600;
}


/* RESPONSIVE */

@media(max-width:768px){

    .sidebar{
        width:70px;
    }

    .logo{
        justify-content:center;
        padding:10px;
    }

    .logo-text{
        display:none;
    }

    .sidebar ul{
        padding:12px 8px;
    }

    .sidebar li a{
        justify-content:center;
        padding:13px 8px;
    }

    .sidebar li a span{
        display:none;
    }

    .content{
        margin-left:70px;
        padding:15px;
    }

    .topbar{
        display:block;
    }

    .admin-info{
        margin-top:12px;
    }

    .box-header{
        display:block;
    }

    .box-header h3{
        margin-bottom:15px;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>


<!-- SIDEBAR -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<!-- CONTENT -->

<main class="content">


    <!-- TOPBAR -->

    <div class="topbar">

        <div class="topbar-title">

            <div class="topbar-icon">

                <i class="fa-solid fa-building"></i>

            </div>

            <div>

                <h3>Sarana Sekolah</h3>

                <div class="topbar-subtitle">

                    Kelola fasilitas yang ditampilkan pada halaman utama

                </div>

            </div>

        </div>


        <div class="admin-info">

            <i class="fa-solid fa-user"></i>

            Login sebagai:

            <b>

                <?= htmlspecialchars($_SESSION['username']); ?>

            </b>

        </div>

    </div>


    <!-- DATA -->

    <div class="box">

        <div class="box-header">

            <h3>

                <i class="fa-solid fa-list"></i>

                Daftar Sarana Sekolah

            </h3>


            <a href="tambah_fasilitas.php"
               class="btn btn-tambah">

                <i class="fa-solid fa-plus"></i>

                Tambah Sarana Sekolah

            </a>

        </div>


        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th width="60">No</th>

                        <th width="130">Foto</th>

                        <th width="180">Nama Sarana Sekolah</th>

                        <th>Deskripsi</th>

                        <th width="130">Aksi</th>

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


                        <td class="text-center">

                            <?php if(!empty($data['foto'])){ ?>

                                <img
                                    src="images/<?= htmlspecialchars($data['foto']); ?>"
                                    class="foto-fasilitas"
                                    alt="Sarana Sekolah">

                            <?php }else{ ?>

                                <div class="no-photo">

                                    <i class="fa-solid fa-image"></i>

                                </div>

                            <?php } ?>

                        </td>


                        <td>

                            <strong>

                                <?= htmlspecialchars($data['nama']); ?>

                            </strong>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                mb_substr(
                                    strip_tags($data['deskripsi']),
                                    0,
                                    120
                                )
                            ); ?>

                            <?php

                            if(
                                strlen(
                                    strip_tags($data['deskripsi'])
                                ) > 120
                            ){

                                echo "...";

                            }

                            ?>

                        </td>


                        <td class="text-center">

                            <a
                                href="edit_fasilitas.php?id=<?= $data['id']; ?>"
                                class="btn btn-sm btn-edit"
                                title="Edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>


                            <a
                                href="hapus_fasilitas.php?id=<?= $data['id']; ?>"
                                class="btn btn-sm btn-hapus"
                                title="Hapus"
                                onclick="return confirm('Yakin ingin menghapus fasilitas ini?')">

                                <i class="fa-solid fa-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php

                    }

                }else{

                ?>

                    <tr>

                        <td colspan="5" class="empty">

                            <i class="fa-solid fa-building"></i>

                            <h4>

                                Belum Ada Sarana Sekolah

                            </h4>

                            <p>

                                Silakan tambahkan fasilitas sekolah.

                            </p>

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

</main>

</body>

</html>