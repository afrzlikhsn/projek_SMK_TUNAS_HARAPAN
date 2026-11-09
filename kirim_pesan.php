<?php

include __DIR__ . "/koneksi.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: contac.php");
    exit;

}


/* ==============================
   AMBIL DATA
============================== */

$nama  = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');


/* ==============================
   VALIDASI
============================== */

if ($nama === '' || $email === '' || $pesan === '') {

    echo "
    <script>
        alert('Semua data wajib diisi!');
        window.location='contac.php';
    </script>
    ";

    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "
    <script>
        alert('Format email tidak valid!');
        window.location='contac.php';
    </script>
    ";

    exit;
}


/* ==============================
   SIMPAN DATABASE
============================== */

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO pesan_masuk
    (nama, email, pesan)
    VALUES (?, ?, ?)"
);


mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $nama,
    $email,
    $pesan
);


if (mysqli_stmt_execute($stmt)) {

    echo "
    <script>

        alert(
            'Pesan berhasil dikirim! Terima kasih sudah menghubungi SMK Tunas Harapan.'
        );

        window.location='contac.php';

    </script>
    ";

} else {

    echo "
    <script>

        alert(
            'Pesan gagal dikirim. Silakan coba lagi.'
        );

        window.location='contac.php';

    </script>
    ";

}


mysqli_stmt_close($stmt);

mysqli_close($koneksi);

?>