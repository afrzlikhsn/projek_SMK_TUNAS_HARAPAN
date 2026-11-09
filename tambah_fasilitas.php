<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";

$pesan = "";

if(isset($_POST['simpan'])){

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        $_POST['deskripsi']
    );

    $link = mysqli_real_escape_string(
        $koneksi,
        $_POST['link']
    );

    $foto = "";


    if(
        isset($_FILES['foto']) &&
        $_FILES['foto']['error'] == 0
    ){

        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $ukuran = $_FILES['foto']['size'];

        $ext = strtolower(
            pathinfo($nama_file, PATHINFO_EXTENSION)
        );

        $format = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if(!in_array($ext,$format)){

            $pesan =
                "Format foto tidak diperbolehkan.";

        }

        elseif($ukuran > 2 * 1024 * 1024){

            $pesan =
                "Ukuran foto maksimal 2 MB.";

        }

        else{

            $foto =
                time() .
                "_" .
                uniqid() .
                "." .
                $ext;


            if(!move_uploaded_file(
                $tmp_file,
                "images/" . $foto
            )){

                $pesan =
                    "Foto gagal diupload.";

            }

        }

    }


    if($pesan == ""){

        $sql = "INSERT INTO fasilitas
                (nama, deskripsi, foto, link)
                VALUES
                ('$nama','$deskripsi','$foto','$link')";


        if(mysqli_query($koneksi,$sql)){

            header("Location: fasilitas.php");
            exit;

        }else{

            $pesan =
                "Gagal menyimpan data: " .
                mysqli_error($koneksi);

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Tambah Sarana Sekolah</title>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
    box-sizing:border-box;
}

body{
    margin:0;
    background:#f4f7fb;
    font-family:'Segoe UI',Arial,sans-serif;
}

.content{
    margin-left:250px;
    padding:30px;
}

.form-box{
    max-width:850px;
    margin:auto;
    background:white;
    padding:32px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.07);
}

.form-header{
    padding-bottom:20px;
    margin-bottom:25px;
    border-bottom:1px solid #edf1f7;
}

.form-header h2{
    margin:0 0 7px;
    color:#173b91;
    font-size:22px;
    font-weight:700;
}

.form-header p{
    margin:0;
    color:#94a3b8;
    font-size:13px;
}

.form-group{
    margin-bottom:22px;
}

.form-group label{
    color:#334155;
    font-weight:600;
    margin-bottom:8px;
}

.form-control{
    height:45px;
    border-radius:9px;
    border:1px solid #dbe2ea;
    box-shadow:none;
}

.form-control:focus{
    border-color:#0b6b57;
    box-shadow:0 0 0 3px rgba(37,99,235,.08);
}

textarea.form-control{
    height:180px;
    resize:vertical;
    padding-top:12px;
}

.help-block{
    color:#94a3b8;
    font-size:12px;
}

.btn-simpan{
    background:#0b6b57;
    color:white;
    border:none;
    border-radius:9px;
    padding:11px 20px;
}

.btn-kembali{
    background:#64748b;
    color:white;
    border:none;
    border-radius:9px;
    padding:11px 20px;
}

.btn-simpan:hover,
.btn-kembali:hover{
    color:white;
}

@media(max-width:768px){

    .content{
        margin-left:0;
        padding:15px;
    }

    .form-box{
        padding:22px;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<div class="content">

    <div class="form-box">

        <div class="form-header">

            <h2>

                <i class="fa-solid fa-building"></i>

                Tambah Sarana Sekolah

            </h2>

            <p>

                Tambahkan informasi fasilitas sekolah.

            </p>

        </div>


        <?php if($pesan != ""){ ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars($pesan); ?>

            </div>

        <?php } ?>


        <form
            method="POST"
            enctype="multipart/form-data">


            <div class="form-group">

                <label>

                    Nama Sarana Sekolah

                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Contoh: Perpustakaan"
                    required>

            </div>


            <div class="form-group">

                <label>

                    Deskripsi Sarana Sekolah

                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    placeholder="Jelaskan fasilitas sekolah..."
                    required></textarea>

            </div>


            <div class="form-group">

                <label>

                    Foto Sarana Sekolah

                </label>

                <input
                    type="file"
                    name="foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp">

                <span class="help-block">

                    JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.

                </span>

            </div>


            <div class="form-group">

                <label>

                    Link Selengkapnya

                </label>

                <input
                    type="text"
                    name="link"
                    class="form-control"
                    placeholder="Contoh: perpustakaan.php">

                <span class="help-block">

                    Halaman yang dibuka ketika pengunjung
                    menekan tombol <b>Selengkapnya</b>.

                </span>

            </div>


            <button
                type="submit"
                name="simpan"
                class="btn btn-simpan">

                <i class="fa-solid fa-save"></i>

                Simpan Sarana Sekolah

            </button>


            <a
                href="fasilitas.php"
                class="btn btn-kembali">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </form>

    </div>

</div>

</body>

</html>