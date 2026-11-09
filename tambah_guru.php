<?php
include "koneksi.php";

if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $mapel = $_POST['mapel'];
    $nsm = $_POST['nsm'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    $query = mysqli_query($koneksi,"
    INSERT INTO dataguru
    (nama,mapel,nsm,alamat,tanggal_lahir)
    VALUES
    ('$nama','$mapel','$nsm','$alamat','$tanggal_lahir')
    ");

    if($query){
        echo "<script>
        alert('Data guru berhasil ditambahkan');
        window.location='dataguru.php';
        </script>";
    }else{
        echo "<script>
        alert('Gagal menambahkan data');
        </script>";

        echo mysqli_error($koneksi);
    }

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Tambah Guru</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<style>

body{

background:#eef2f7;

font-family:Segoe UI;

}

.container{

margin-top:40px;

max-width:700px;

}

.panel{

border:none;

border-radius:12px;

box-shadow:0 5px 15px rgba(0,0,0,.15);

}

.panel-heading{

background:#0b6b57!important;

color:white!important;

}

.btn-success{

background:#198754;

border:none;

}

.btn-primary{

background:#0b6b57;

border:none;

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<div class="container">

<div class="panel panel-primary">

<div class="panel-heading">

<h3 class="panel-title">

Tambah Tenaga Pendidik

</h3>

</div>

<div class="panel-body">

<form method="POST">

<div class="form-group">

<label>Nama Guru</label>

<input
type="text"
name="nama"
class="form-control"
required>

</div>

<div class="form-group">

<label>NSM</label>

<input
type="text"
name="nsm"
class="form-control"
required>

</div>

<div class="form-group">

<label>Kurikulum</label>

<input
type="text"
name="mapel"
class="form-control"
required>

</div>

<div class="form-group">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"
rows="3"
required></textarea>

</div>

<div class="form-group">

<label>Tanggal Lahir</label>

<input
type="date"
name="tanggal_lahir"
class="form-control"
required>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

<span class="glyphicon glyphicon-floppy-disk"></span>

Simpan

</button>

<a
href="dataguru.php"
class="btn btn-primary">

<span class="glyphicon glyphicon-arrow-left"></span>

Kembali

</a>

</form>

</div>

</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>

</html>