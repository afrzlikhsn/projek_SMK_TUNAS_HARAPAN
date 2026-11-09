<?php

session_start();


if(!isset($_SESSION['username'])){

    header("Location: login_admin.php");

    exit;

}


include __DIR__ . "/koneksi.php";


$id =
    isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;


$query =
    mysqli_query(
        $koneksi,
        "SELECT * FROM agenda
         WHERE id=$id"
    );


$agenda =
    mysqli_fetch_assoc($query);


if(!$agenda){

    die("Kalender Kegiatan tidak ditemukan.");

}


/* ==================================================
   UPDATE
================================================== */

if(isset($_POST['update'])){

    $judul =
        mysqli_real_escape_string(
            $koneksi,
            $_POST['judul']
        );

    $tanggal =
        mysqli_real_escape_string(
            $koneksi,
            $_POST['tanggal']
        );

    $deskripsi =
        mysqli_real_escape_string(
            $koneksi,
            $_POST['deskripsi']
        );


    $foto_lama =
        $agenda['foto'];


    $foto_baru =
        $foto_lama;


    if(
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] == 0
    ){

        $nama_file =
            $_FILES['foto']['name'];

        $tmp_file =
            $_FILES['foto']['tmp_name'];


        $ext =
            strtolower(
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

            $foto_baru =
                time() .
                "_" .
                preg_replace(
                    "/[^a-zA-Z0-9.]/",
                    "_",
                    $nama_file
                );


            move_uploaded_file(
                $tmp_file,
                __DIR__ .
                "/images/" .
                $foto_baru
            );


            if(
                !empty($foto_lama) &&
                file_exists(
                    __DIR__ .
                    "/images/" .
                    $foto_lama
                )
            ){

                unlink(
                    __DIR__ .
                    "/images/" .
                    $foto_lama
                );

            }

        }

    }


    mysqli_query(
        $koneksi,
        "UPDATE agenda SET

        judul='$judul',

        tanggal='$tanggal',

        deskripsi='$deskripsi',

        foto='$foto_baru'

        WHERE id=$id"
    );


    header(
        "Location: admin_agenda.php?status=update"
    );

    exit;

}

?>


<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="utf-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
    Edit Kalender Kegiatan
</title>


<link
    href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">


<style>

body{

    background:#f5f8fc;

    font-family:
        "Segoe UI",
        Arial,
        sans-serif;

}


.edit-container{

    max-width:800px;

    margin:
        80px auto;

    padding:
        0 15px;

}


.edit-card{

    background:white;

    padding:30px;

    border-radius:20px;

    box-shadow:
        0 8px 30px rgba(15,23,42,.08);

}


.edit-card h2{

    margin-top:0;

    color:#0b6b57;

    font-weight:800;

}


.form-control{

    height:45px;

    border-radius:10px;

    box-shadow:none;

}


textarea.form-control{

    height:150px;

}


.preview{

    width:180px;

    height:120px;

    object-fit:cover;

    border-radius:12px;

    margin-bottom:15px;

}


.btn-save{

    background:#0b6b57;

    color:white;

    border:none;

    border-radius:25px;

    padding:
        11px 25px;

    font-weight:700;

}


.btn-back{

    display:inline-block;

    margin-left:8px;

    padding:
        10px 20px;

    border-radius:25px;

    background:#e2e8f0;

    color:#334155;

    text-decoration:none!important;

    font-weight:700;

}


@media(max-width:600px){

    .edit-container{

        margin:
            30px auto;

    }


    .edit-card{

        padding:20px;

    }


    .preview{

        width:100%;

        height:200px;

    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<div class="edit-container">

<div class="edit-card">


<h2>

<span class="glyphicon glyphicon-edit"></span>

Edit Kalender Kegiatan

</h2>


<hr>


<form
    method="POST"
    enctype="multipart/form-data">


<div class="form-group">

<label>
    Judul Kalender Kegiatan
</label>

<input
    type="text"
    name="judul"
    class="form-control"
    value="<?= htmlspecialchars($agenda['judul']); ?>"
    required>

</div>


<div class="form-group">

<label>
    Tanggal
</label>

<input
    type="date"
    name="tanggal"
    class="form-control"
    value="<?= htmlspecialchars($agenda['tanggal']); ?>"
    required>

</div>


<div class="form-group">

<label>
    Deskripsi
</label>

<textarea
    name="deskripsi"
    class="form-control"
    required><?= htmlspecialchars($agenda['deskripsi']); ?></textarea>

</div>


<div class="form-group">

<label>
    Foto Saat Ini
</label>

<br>


<?php

$foto_lama =
    !empty($agenda['foto'])
    ? "images/" . $agenda['foto']
    : "images/default-agenda.jpg";

?>

<img
    src="<?= htmlspecialchars($foto_lama); ?>"
    class="preview">


<br>


<label>
    Ganti Foto
</label>

<input
    type="file"
    name="foto"
    class="form-control"
    accept=".jpg,.jpeg,.png,.webp">

</div>


<button
    type="submit"
    name="update"
    class="btn-save">

    <span class="glyphicon glyphicon-save"></span>

    Simpan Perubahan

</button>


<a
    href="admin_agenda.php"
    class="btn-back">

    Kembali

</a>


</form>

</div>

</div>


</body>

</html>