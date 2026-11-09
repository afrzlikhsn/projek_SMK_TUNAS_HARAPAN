<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


if(!isset($_GET['id'])){

    header("Location: kelola_prestasi.php");

    exit;
}


$id = intval($_GET['id']);


/* =========================
   AMBIL DATA
========================= */

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM prestasi WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result =
    mysqli_stmt_get_result($stmt);

$data =
    mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if(!$data){

    die("Data prestasi tidak ditemukan.");

}


/* =========================
   UPDATE
========================= */

if(isset($_POST['update'])){

    $judul =
        trim($_POST['judul']);

    $deskripsi =
        trim($_POST['deskripsi']);

    $tanggal =
        $_POST['tanggal'];


    $foto =
        $data['foto'];


    /* =========================
       FOTO BARU
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
                "Format foto tidak diperbolehkan."
            );

        }


        if($ukuran > 5 * 1024 * 1024){

            die(
                "Ukuran foto maksimal 5 MB."
            );

        }


        $foto_baru =
            uniqid(
                "prestasi_",
                true
            )
            . "."
            . $ext;


        if(!move_uploaded_file(
            $tmp,
            $folder . $foto_baru
        )){

            die(
                "Gagal mengupload foto baru."
            );

        }


        /* HAPUS FOTO LAMA */

        if(!empty($data['foto'])){

            $foto_lama =
                $folder .
                $data['foto'];


            if(file_exists($foto_lama)){

                unlink($foto_lama);

            }

        }


        $foto =
            $foto_baru;

    }


    /* =========================
       UPDATE DATABASE
    ========================= */

    $stmt = mysqli_prepare(
        $koneksi,

        "UPDATE prestasi

         SET
         judul=?,
         deskripsi=?,
         foto=?,
         tanggal=?

         WHERE id=?"
    );


    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $judul,
        $deskripsi,
        $foto,
        $tanggal,
        $id
    );


    if(!mysqli_stmt_execute($stmt)){

        die(
            "Gagal update: "
            . mysqli_stmt_error($stmt)
        );

    }


    mysqli_stmt_close($stmt);


    header(
        "Location: kelola_prestasi.php?status=edit"
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

<title>Edit Capaian Siswa - SMK Tunas Harapan</title>

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

    box-shadow:
        0 8px 25px rgba(15,23,42,.07);
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

    box-shadow:
        0 0 0 3px rgba(37,99,235,.08);
}

.foto-lama{
    width:160px;

    height:110px;

    object-fit:cover;

    border-radius:10px;

    margin-bottom:10px;
}

.btn-update{
    background:#0b6b57;

    color:white;

    border:none;

    padding:11px 18px;

    border-radius:9px;

    font-weight:600;
}

.btn-update:hover{
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

.info{
    color:#94a3b8;

    font-size:11px;

    margin-top:5px;
}

</style>

    <link rel="stylesheet" href="assets/css/admin.css">

</head>


<body>


<div class="container-form">

<div class="card-form">


<div class="header-form">

<h2>

<i class="fa-solid fa-pen"
style="color:#f59e0b"></i>

&nbsp; Edit Capaian Siswa

</h2>

<p>
Perbarui informasi prestasi SMK Tunas Harapan.
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
required
value="<?= htmlspecialchars($data['judul']); ?>">

</div>


<div class="form-group">

<label>
Deskripsi
</label>

<textarea
name="deskripsi"
class="form-control"
required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

</div>


<div class="form-group">

<label>
Tanggal Capaian Siswa
</label>

<input
type="date"
name="tanggal"
class="form-control"
required
value="<?= htmlspecialchars($data['tanggal']); ?>">

</div>


<div class="form-group">

<label>
Foto Saat Ini
</label>


<?php if(!empty($data['foto'])){ ?>

<br>

<img
src="uploads/prestasi/<?= htmlspecialchars($data['foto']); ?>"
class="foto-lama">

<?php }else{ ?>

<p class="text-muted">
Belum ada foto.
</p>

<?php } ?>


<label>
Ganti Foto
</label>

<input
type="file"
name="foto"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

<div class="info">
Kosongkan jika tidak ingin mengganti foto.
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
name="update"
class="btn-update">

<i class="fa-solid fa-save"></i>

Simpan Perubahan

</button>

</div>


</form>


</div>

</div>


</body>

</html>