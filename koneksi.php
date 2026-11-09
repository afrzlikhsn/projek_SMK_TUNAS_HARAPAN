<?php
/**
 * Koneksi database SMK Tunas Harapan
 *
 * Default untuk XAMPP:
 *   host = localhost
 *   user = root
 *   password = kosong
 *   database = smktunasharapan
 *
 * Jika dipindahkan ke hosting, isi variabel environment:
 * DB_HOST, DB_USER, DB_PASS, DB_NAME
 * atau buat file config/database.php dengan array:
 * ['host'=>..., 'user'=>..., 'pass'=>..., 'name'=>...]
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

date_default_timezone_set('Asia/Jakarta');

$config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
    'name' => getenv('DB_NAME') ?: 'smktunasharapan',
];

$customConfig = __DIR__ . '/config/database.php';
if (is_file($customConfig)) {
    $custom = require $customConfig;
    if (is_array($custom)) {
        $config = array_merge($config, $custom);
    }
}

mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_connect(
    $config['host'],
    $config['user'],
    $config['pass'],
    $config['name']
);

if (!$koneksi) {
    http_response_code(500);
    $detail = htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8');
    die(
        '<div style="font-family:Arial,sans-serif;max-width:760px;margin:60px auto;padding:24px;'
        . 'border:1px solid #f0c7c0;border-radius:12px;background:#fff7f5;color:#7a2e24">'
        . '<h2 style="margin-top:0">Koneksi database gagal</h2>'
        . '<p>Pastikan MySQL/MariaDB aktif dan database <b>'
        . htmlspecialchars($config['name'], ENT_QUOTES, 'UTF-8')
        . '</b> sudah di-import.</p>'
        . '<p><b>Detail:</b> ' . $detail . '</p>'
        . '<p>Untuk XAMPP lokal gunakan root tanpa password. Untuk hosting, sesuaikan DB_HOST, DB_USER, DB_PASS, dan DB_NAME.</p>'
        . '</div>'
    );
}

if (!mysqli_set_charset($koneksi, 'utf8mb4')) {
    die('Gagal mengatur charset database: ' . htmlspecialchars(mysqli_error($koneksi), ENT_QUOTES, 'UTF-8'));
}

require_once __DIR__ . '/includes/site_setup.php';
require_once __DIR__ . '/includes/site_helpers.php';
?>
