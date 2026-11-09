<?php

session_start();

/* ==============================
   CEK LOGIN ADMIN
============================== */

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}


/* ==============================
   KONEKSI DATABASE
============================== */

include __DIR__ . "/koneksi.php";


/* ==============================
   CEK ID BERITA
============================== */

if(!isset($_GET['id']) || empty($_GET['id'])){

    header("Location: berita.php");
    exit;

}

$id = (int) $_GET['id'];


/* ==============================
   AMBIL NAMA FOTO
============================== */

$query_foto = mysqli_query(
    $koneksi,
    "SELECT foto FROM berita WHERE id = $id"
);


if(!$query_foto){

    die(
        "Gagal mengambil data berita: "
        . mysqli_error($koneksi)
    );

}


$data = mysqli_fetch_assoc($query_foto);


/* ==============================
   HAPUS FOTO
============================== */

if($data && !empty($data['foto'])){

    $file_foto =
        __DIR__ . "/images/" . $data['foto'];


    if(file_exists($file_foto)){

        unlink($file_foto);

    }

}


/* ==============================
   HAPUS DATA BERITA
============================== */

$query_hapus = mysqli_query(
    $koneksi,
    "DELETE FROM berita WHERE id = $id"
);


/* ==============================
   CEK HASIL
============================== */

if($query_hapus){

    header("Location: berita.php");
    exit;

}else{

    die(
        "Gagal menghapus berita: "
        . mysqli_error($koneksi)
    );

}

?>