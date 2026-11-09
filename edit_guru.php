<?php
include "koneksi.php";

$id = $_GET['id_guru'];

$query = mysqli_query($koneksi,"SELECT * FROM dataguru WHERE id_guru='$id'");
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama=$_POST['nama'];
    $nsm=$_POST['nsm'];
    $mapel=$_POST['mapel'];
    $alamat=$_POST['alamat'];
    $tanggal=$_POST['tanggal_lahir'];

    $update=mysqli_query($koneksi,"
    UPDATE dataguru SET

    nama='$nama',
    nsm='$nsm',
    mapel='$mapel',
    alamat='$alamat',
    tanggal_lahir='$tanggal'

    WHERE id_guru='$id'
    ");

    if($update){

        echo "<script>

        alert('Data berhasil diupdate');

        window.location='dataguru.php';

        </script>";

    }else{

        die(mysqli_error($koneksi));

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Edit Guru</title>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

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

border-radius:10px;

box-shadow:0 5px 15px rgba(0,0,0,.15);

}

.panel-heading{

background:#ff9800!important;

color:white!important;

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<div class="container">

<div class="panel panel-warning">

<div class="panel-heading">

<h3>Edit Tenaga Pendidik</h3>

</div>

<div class="panel-body">

<form method="POST">

<div class="form-group">

<label>Nama Guru</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= $data['nama']; ?>"
required>

</div>

<div class="form-group">

<label>NSM</label>

<input
type="text"
name="nsm"
class="form-control"
value="<?= $data['nsm']; ?>"
required>

</div>

<div class="form-group">

<label>Kurikulum</label>

<input
type="text"
name="mapel"
class="form-control"
value="<?= $data['mapel']; ?>"
required>

</div>

<div class="form-group">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"
rows="3"
required><?= $data['alamat']; ?></textarea>

</div>

<div class="form-group">

<label>Tanggal Lahir</label>

<input
type="date"
name="tanggal_lahir"
class="form-control"
value="<?= $data['tanggal_lahir']; ?>"
required>

</div>

<button
type="submit"
name="update"
class="btn btn-warning">

Update

</button>

<a
href="dataguru.php"
class="btn btn-default">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>