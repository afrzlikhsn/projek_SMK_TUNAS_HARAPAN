<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


if(!isset($_GET['id'])){
    header("Location: fasilitas.php");
    exit;
}


$id = intval($_GET['id']);


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM fasilitas WHERE id=$id"
);


$data = mysqli_fetch_assoc($query);


if(!$data){
    header("Location: fasilitas.php");
    exit;
}


$pesan = "";


if(isset($_POST['update'])){

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


    $foto = $data['foto'];


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

            $foto_baru =
                time() .
                "_" .
                uniqid() .
                "." .
                $ext;


            if(move_uploaded_file(
                $tmp_file,
                "images/" . $foto_baru
            )){

                if(
                    !empty($foto) &&
                    file_exists("images/" . $foto)
                ){

                    unlink("images/" . $foto);

                }


                $foto = $foto_baru;

            }

        }

    }


    if($pesan == ""){

        $sql = "UPDATE fasilitas SET
                nama='$nama',
                deskripsi='$deskripsi',
                foto='$foto',
                link='$link'
                WHERE id=$id";


        if(mysqli_query($koneksi,$sql)){

            header("Location: fasilitas.php");
            exit;

        }else{

            $pesan =
                "Gagal mengubah fasilitas: " .
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

<title>Edit Sarana Sekolah</title>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

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

h2{
    margin:0 0 25px;
    color:#173b91;
    font-weight:700;
}

.form-control{
    height:45px;
    border-radius:9px;
    box-shadow:none;
}

textarea.form-control{
    height:180px;
    resize:vertical;
}

.preview{
    width:200px;
    height:130px;
    object-fit:cover;
    border-radius:12px;
    margin-bottom:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.12);
}

.btn-update{
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

.btn-update:hover,
.btn-kembali:hover{
    color:white;
}

@media(max-width:768px){

    .content{
        margin-left:0;
        padding:15px;
    }

}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>

<body>

<div class="content">

    <div class="form-box">

        <h2>

            <i class="fa-solid fa-pen-to-square"></i>

            Edit Sarana Sekolah

        </h2>


        <?php if($pesan != ""){ ?>

            <div class="alert alert-danger">

                <?= htmlspecialchars($pesan); ?>

            </div>

        <?php } ?>


        <form
            method="POST"
            enctype="multipart/form-data">


            <div class="form-group">

                <label>Nama Sarana Sekolah</label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="<?= htmlspecialchars($data['nama']); ?>"
                    required>

            </div>


            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

            </div>


            <div class="form-group">

                <label>Foto Saat Ini</label>

                <br>

                <?php if(!empty($data['foto'])){ ?>

                    <img
                        src="images/<?= htmlspecialchars($data['foto']); ?>"
                        class="preview">

                <?php }else{ ?>

                    <p class="text-muted">

                        Belum ada foto.

                    </p>

                <?php } ?>

            </div>


            <div class="form-group">

                <label>Ganti Foto</label>

                <input
                    type="file"
                    name="foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp">

                <p class="help-block">

                    Kosongkan jika tidak ingin mengganti foto.

                </p>

            </div>


            <div class="form-group">

                <label>Link Selengkapnya</label>

                <input
                    type="text"
                    name="link"
                    class="form-control"
                    value="<?= htmlspecialchars($data['link']); ?>"
                    placeholder="Contoh: perpustakaan.php">

            </div>


            <button
                type="submit"
                name="update"
                class="btn btn-update">

                <i class="fa-solid fa-save"></i>

                Simpan Perubahan

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