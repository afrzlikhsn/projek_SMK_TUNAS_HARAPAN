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
    "SELECT foto FROM fasilitas WHERE id=$id"
);


$data = mysqli_fetch_assoc($query);


if($data){

    if(
        !empty($data['foto']) &&
        file_exists("images/" . $data['foto'])
    ){

        unlink("images/" . $data['foto']);

    }


    mysqli_query(
        $koneksi,
        "DELETE FROM fasilitas WHERE id=$id"
    );

}


header("Location: fasilitas.php");
exit;

?>