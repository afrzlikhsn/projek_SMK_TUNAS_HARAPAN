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
   AMBIL FOTO
========================= */

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT foto FROM prestasi WHERE id=?"
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


/* =========================
   HAPUS FOTO
========================= */

if($data && !empty($data['foto'])){

    $file =
        __DIR__ .
        "/uploads/prestasi/" .
        $data['foto'];


    if(file_exists($file)){

        unlink($file);

    }

}


/* =========================
   HAPUS DATABASE
========================= */

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM prestasi WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);


header(
    "Location: kelola_prestasi.php?status=hapus"
);

exit;

?>