<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login_admin.php");
    exit;
}

include __DIR__ . "/koneksi.php";


$id = isset($_GET['id'])
    ? intval($_GET['id'])
    : 0;


if($id <= 0){

    header("Location: pesan.php");
    exit;

}


$query = mysqli_query(
    $koneksi,
    "DELETE FROM pesan_masuk
     WHERE id = $id"
);


header("Location: pesan.php");

exit;

?>