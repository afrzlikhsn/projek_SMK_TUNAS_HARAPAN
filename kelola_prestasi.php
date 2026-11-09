<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM prestasi ORDER BY tanggal DESC, id DESC"
);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Capaian Siswa - SMK Tunas Harapan</title>

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


/* LOGO */

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


/* NAVIGATION */

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

    background:
        linear-gradient(
            135deg,
            #3b82f6,
            #0b6b57
        );

    box-shadow:
        0 6px 15px rgba(37,99,235,.30);
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

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);

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


/* PANEL */

.panel{
    margin-top:25px;

    background:white;

    border-radius:16px;

    border:1px solid #edf1f7;

    box-shadow:
        0 5px 20px rgba(15,23,42,.06);

    padding:25px;
}

.panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;

    margin-bottom:22px;
}

.panel-header h4{
    margin:0;

    font-size:18px;
    font-weight:700;

    color:#1e293b;
}


/* BUTTON */

.btn-tambah{
    display:inline-flex;

    align-items:center;
    gap:7px;

    padding:10px 16px;

    border:none;

    border-radius:9px;

    background:#0b6b57;

    color:white!important;

    text-decoration:none!important;

    font-size:13px;

    font-weight:600;

    transition:.25s;
}

.btn-tambah:hover{
    background:#095844;
    transform:translateY(-2px);
}


/* TABLE */

.table{
    margin-bottom:0;
}

.table thead{
    background:#f8fafc;
}

.table thead th{
    border:none!important;

    color:#475569;

    font-size:12px;

    padding:14px!important;
}

.table tbody td{
    vertical-align:middle!important;

    border-color:#edf1f7!important;

    padding:13px!important;

    font-size:13px;
}

.foto{
    width:75px;
    height:55px;

    object-fit:cover;

    border-radius:9px;

    background:#f1f5f9;
}

.no-foto{
    width:75px;
    height:55px;

    display:flex;

    align-items:center;
    justify-content:center;

    border-radius:9px;

    background:#f1f5f9;

    color:#94a3b8;

    font-size:11px;
}


/* ACTION */

.btn-action{
    display:inline-flex;

    align-items:center;
    justify-content:center;

    width:36px;
    height:36px;

    border-radius:8px;

    text-decoration:none!important;

    color:white!important;

    margin-right:4px;

    transition:.2s;
}

.btn-edit{
    background:#f59e0b;
}

.btn-hapus{
    background:#ef4444;
}

.btn-action:hover{
    opacity:.85;
    transform:translateY(-2px);
}


/* EMPTY */

.empty{
    text-align:center;

    padding:50px 20px;

    color:#94a3b8;
}

.empty i{
    font-size:45px;
    margin-bottom:15px;
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

    .panel-header{
        display:block;
    }

    .btn-tambah{
        margin-top:15px;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<!-- SIDEBAR -->

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<!-- CONTENT -->

<div class="content">


<!-- TOPBAR -->

<div class="topbar">

<div class="topbar-title">

<div class="topbar-icon">

<i class="fa-solid fa-trophy"></i>

</div>

<div>

<h3>Capaian Siswa</h3>

<div class="topbar-subtitle">
Kelola prestasi dan pencapaian SMK Tunas Harapan
</div>

</div>

</div>


<div class="admin-info">

<div class="admin-avatar">

<i class="fa-solid fa-user"></i>

</div>

<div>

<span>Login sebagai</span>

<b>
<?= htmlspecialchars($_SESSION['username']); ?>
</b>

</div>

</div>

</div>


<!-- PANEL -->

<div class="panel">

<div class="panel-header">

<h4>

<i class="fa-solid fa-trophy"
style="color:#8b5cf6"></i>

&nbsp; Data Capaian Siswa

</h4>


<a href="tambah_prestasi.php"
class="btn-tambah">

<i class="fa-solid fa-plus"></i>

Tambah Capaian Siswa

</a>

</div>


<div class="table-responsive">

<table class="table table-hover">

<thead>

<tr>

<th width="60">No</th>

<th width="100">Foto</th>

<th>Judul</th>

<th>Deskripsi</th>

<th width="120">Tanggal</th>

<th width="120">Aksi</th>

</tr>

</thead>

<tbody>


<?php

$no = 1;

if(mysqli_num_rows($query) > 0){

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

<td>
<?= $no++; ?>
</td>


<td>

<?php if(!empty($data['foto'])){ ?>

<img
src="uploads/prestasi/<?= htmlspecialchars($data['foto']); ?>"
class="foto">

<?php }else{ ?>

<div class="no-foto">
<i class="fa-regular fa-image"></i>
</div>

<?php } ?>

</td>


<td>

<strong>
<?= htmlspecialchars($data['judul']); ?>
</strong>

</td>


<td>

<?= htmlspecialchars(
mb_strimwidth(
$data['deskripsi'],
0,
100,
"..."
)
); ?>

</td>


<td>

<?= date(
'd-m-Y',
strtotime($data['tanggal'])
); ?>

</td>


<td>

<a
href="edit_prestasi.php?id=<?= $data['id']; ?>"
class="btn-action btn-edit"
title="Edit">

<i class="fa-solid fa-pen"></i>

</a>


<a
href="hapus_prestasi.php?id=<?= $data['id']; ?>"
class="btn-action btn-hapus"
title="Hapus"
onclick="return confirm('Yakin ingin menghapus prestasi ini?');">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="6">

<div class="empty">

<i class="fa-solid fa-trophy"></i>

<h4>Belum Ada Data Capaian Siswa</h4>

<p>
Silakan tambahkan prestasi melalui tombol Tambah Capaian Siswa.
</p>

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

</div>


</body>

</html>