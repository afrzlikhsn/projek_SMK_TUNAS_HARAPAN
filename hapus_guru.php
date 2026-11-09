<?php
include "koneksi.php";

$id_guru = $_GET['id_guru'] ?? '';

if (empty($id_guru)) {
    echo "<script>
        alert('ID guru tidak ditemukan');
        window.location='index.php';
    </script>";
    exit;
}

$id_guru = mysqli_real_escape_string($koneksi, $id_guru);

$hapus = mysqli_query($koneksi, "DELETE FROM dataguru WHERE id_guru='$id_guru'");

if ($hapus) {
    echo "<script>
        alert('Data guru berhasil dihapus');
        window.location='index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data guru');
        window.location='index.php';
    </script>";
}
?>