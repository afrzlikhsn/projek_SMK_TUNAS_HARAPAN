<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


if(isset($_POST['simpan'])){

    $judul = trim($_POST['judul']);

    $deskripsi = trim($_POST['deskripsi']);

    $tanggal = $_POST['tanggal'];

    $foto = "";


    if($judul == "" || $deskripsi == "" || $tanggal == ""){

        die("Semua data wajib diisi.");

    }


    /* =========================
       UPLOAD FOTO
    ========================= */

    if(isset($_FILES['foto']) &&
       $_FILES['foto']['error'] == 0){

        $folder =
            __DIR__ .
            "/uploads/prestasi/";


        if(!is_dir($folder)){

            mkdir(
                $folder,
                0777,
                true
            );

        }


        $nama_asli =
            $_FILES['foto']['name'];

        $tmp =
            $_FILES['foto']['tmp_name'];

        $ukuran =
            $_FILES['foto']['size'];


        $ext =
            strtolower(
                pathinfo(
                    $nama_asli,
                    PATHINFO_EXTENSION
                )
            );


        $allowed = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if(!in_array($ext,$allowed)){

            die(
                "Format foto harus JPG, JPEG, PNG atau WEBP."
            );

        }


        if($ukuran > 5 * 1024 * 1024){

            die(
                "Ukuran foto maksimal 5 MB."
            );

        }


        $foto =
            uniqid("prestasi_",true)
            . "."
            . $ext;


        if(!move_uploaded_file(
            $tmp,
            $folder . $foto
        )){

            die(
                "Foto gagal diupload."
            );

        }

    }


    /* =========================
       INSERT
    ========================= */

    $stmt = mysqli_prepare(
        $koneksi,

        "INSERT INTO prestasi
        (judul, deskripsi, foto, tanggal)
        VALUES (?, ?, ?, ?)"
    );


    if(!$stmt){

        die(
            "Prepare gagal: "
            . mysqli_error($koneksi)
        );

    }


    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $judul,
        $deskripsi,
        $foto,
        $tanggal
    );


    if(!mysqli_stmt_execute($stmt)){

        die(
            "Gagal menyimpan: "
            . mysqli_stmt_error($stmt)
        );

    }


    mysqli_stmt_close($stmt);


    header(
        "Location: kelola_prestasi.php?status=tambah"
    );

    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Tambah Capaian Siswa - SMK Tunas Harapan</title>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<style>

body{
    margin:0;
    font-family:'Segoe UI',Arial,sans-serif;
    background:#f4f7fb;
    color:#1f2937;
}

.container-form{
    max-width:850px;
    margin:40px auto;
    padding:0 20px;
}

.card-form{
    background:white;
    border-radius:17px;
    padding:30px;
    border:1px solid #edf1f7;
    box-shadow:0 8px 25px rgba(15,23,42,.07);
}

.header-form{
    margin-bottom:25px;
}

.header-form h2{
    margin:0 0 8px;
    color:#172033;
    font-size:24px;
    font-weight:700;
}

.header-form p{
    margin:0;
    color:#94a3b8;
    font-size:13px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#334155;
    font-size:13px;
    font-weight:600;
}

.form-control{
    height:44px;
    border-radius:9px;
    border:1px solid #dbe3ee;
    box-shadow:none;
}

textarea.form-control{
    height:140px;
    resize:vertical;
}

.form-control:focus{
    border-color:#0b6b57;
    box-shadow:0 0 0 3px rgba(37,99,235,.08);
}

.btn-simpan{
    background:#0b6b57;
    color:white;
    border:none;
    padding:11px 18px;
    border-radius:9px;
    font-weight:600;
}

.btn-simpan:hover{
    background:#095844;
    color:white;
}

.btn-kembali{
    background:#e2e8f0;
    color:#334155;
    padding:11px 18px;
    border-radius:9px;
    font-weight:600;
    text-decoration:none;
    display:inline-block;
    margin-right:8px;
}

.btn-kembali:hover{
    color:#334155;
    text-decoration:none;
}

.info-upload{
    margin-top:7px;
    color:#94a3b8;
    font-size:11px;
}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<div class="container-form">

<div class="card-form">


<div class="header-form">

<h2>

<i class="fa-solid fa-trophy"
style="color:#8b5cf6"></i>

&nbsp; Tambah Capaian Siswa

</h2>

<p>
Tambahkan prestasi baru SMK Tunas Harapan.
</p>

</div>


<form
method="POST"
enctype="multipart/form-data">


<div class="form-group">

<label>
Judul Capaian Siswa
</label>

<input
type="text"
name="judul"
class="form-control"
placeholder="Contoh: Juara 1 Lomba Cerdas Cermat"
required>

</div>


<div class="form-group">

<label>
Deskripsi
</label>

<textarea
name="deskripsi"
class="form-control"
placeholder="Tuliskan keterangan prestasi..."
required></textarea>

</div>


<div class="form-group">

<label>
Tanggal Capaian Siswa
</label>

<input
type="date"
name="tanggal"
class="form-control"
required>

</div>


<div class="form-group">

<label>
Foto Capaian Siswa
</label>

<input
type="file"
name="foto"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

<div class="info-upload">

Format JPG, JPEG, PNG atau WEBP.
Maksimal 5 MB.

</div>

</div>


<div style="margin-top:25px;">

<a
href="kelola_prestasi.php"
class="btn-kembali">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>


<button
type="submit"
name="simpan"
class="btn-simpan">

<i class="fa-solid fa-save"></i>

Simpan Capaian Siswa

</button>

</div>


</form>


</div>

</div>


</body>

</html>