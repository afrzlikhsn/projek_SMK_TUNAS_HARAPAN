<?php
session_start();
require_once __DIR__ . '/koneksi.php';

if (isset($_SESSION['id_admin'])) {
    header('Location: dashboard_admin.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Nama pengguna dan kata sandi wajib diisi.';
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id_admin, username, password FROM admin WHERE username = ? LIMIT 1");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = $result ? mysqli_fetch_assoc($result) : null;
            mysqli_stmt_close($stmt);

            $valid = false;
            $needsUpgrade = false;

            if ($row) {
                $stored = (string)$row['password'];

                if (password_verify($password, $stored)) {
                    $valid = true;
                } elseif (hash_equals($stored, $password)) {
                    // Kompatibilitas dengan database lama yang masih menyimpan password teks.
                    $valid = true;
                    $needsUpgrade = true;
                }

                if ($valid) {
                    if ($needsUpgrade) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $update = mysqli_prepare($koneksi, "UPDATE admin SET password = ? WHERE id_admin = ?");
                        if ($update) {
                            mysqli_stmt_bind_param($update, 'si', $newHash, $row['id_admin']);
                            mysqli_stmt_execute($update);
                            mysqli_stmt_close($update);
                        }
                    }

                    session_regenerate_id(true);
                    $_SESSION['id_admin'] = (int)$row['id_admin'];
                    $_SESSION['username'] = $row['username'];

                    header('Location: dashboard_admin.php');
                    exit;
                }
            }

            $error = 'Nama pengguna atau kata sandi tidak sesuai.';
        } else {
            $error = 'Sistem login tidak dapat membaca data administrator.';
        }
    }
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Masuk Pengelola | SMK Tunas Harapan</title><link rel="stylesheet" href="assets/css/admin.css"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body.login-screen{min-height:100vh;background:#172033;display:grid;place-items:center;overflow:hidden}
.login-scene{width:min(980px,94%);min-height:570px;display:grid;grid-template-columns:1.05fr .95fr;background:#fff;border-radius:24px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,.3)}
.login-story{position:relative;background:#172033;color:#fff;padding:55px;display:flex;flex-direction:column;justify-content:space-between;overflow:hidden}
.login-story:after{content:"";position:absolute;width:430px;height:430px;border:1px solid rgba(255,255,255,.1);border-radius:50%;right:-220px;bottom:-180px;box-shadow:0 0 0 50px rgba(255,255,255,.025)}
.login-mark{position:relative;z-index:2;width:58px;height:58px;border-radius:16px;background:#e66b4e;display:grid;place-items:center;font-size:24px}
.login-story h1{position:relative;z-index:2;font-size:45px;line-height:1;margin:0 0 14px;font-weight:900;letter-spacing:-1px}.login-story p{position:relative;z-index:2;color:#c1c8d2;font-size:12px;line-height:1.8;max-width:390px}.login-story small{position:relative;z-index:2;color:#f2c86d;letter-spacing:1.5px;font-weight:900;font-size:9px}
.login-form{padding:55px 48px;display:flex;align-items:center}.login-form-inner{width:100%;max-width:350px;margin:auto}.login-form .kicker{color:#e66b4e;font-size:9px;font-weight:900;letter-spacing:1.5px}.login-form h2{font-size:29px;font-weight:900;margin:8px 0 8px}.login-form .intro{color:#727b8a;font-size:11px;margin-bottom:27px}.login-label{display:block;font-size:10px;font-weight:900;margin-bottom:7px}.login-input{position:relative;margin-bottom:18px}.login-input i{position:absolute;left:13px;top:13px;color:#a0a7b1}.login-input input{width:100%;height:44px;border:1px solid #e5dfd4;border-radius:9px;padding:0 12px 0 38px;outline:none}.login-input input:focus{border-color:#e66b4e;box-shadow:0 0 0 3px rgba(230,107,78,.1)}.login-submit{width:100%;height:45px;border:0;border-radius:9px;background:#e66b4e;color:#fff;font-weight:900;font-size:11px}.login-submit:hover{background:#c94f37}.login-error{padding:10px 12px;background:#fff2ef;color:#b64d3a;border:1px solid #f5c8bf;border-radius:8px;font-size:10px;margin-bottom:15px}.login-home{display:block;text-align:center;margin-top:18px;color:#727b8a;font-size:10px}.login-home:hover{color:#e66b4e;text-decoration:none}
@media(max-width:760px){.login-scene{grid-template-columns:1fr}.login-story{min-height:230px;padding:30px}.login-story h1{font-size:32px}.login-form{padding:35px 25px}}
</style></head><body class="login-screen">
<div class="login-scene">
<section class="login-story"><div><div class="login-mark"><i class="fa-solid fa-compass-drafting"></i></div><small>PORTAL PENGELOLA SEKOLAH</small></div><div><h1>SMK Tunas Harapan</h1><p>Ruang kerja digital untuk mengelola informasi sekolah, publikasi, kalender kegiatan, capaian siswa, sarana, dan galeri sekolah.</p></div><small>BATANG SERANGAN • LANGKAT</small></section>
<section class="login-form"><div class="login-form-inner"><span class="kicker">AKSES ADMINISTRATOR</span><h2>Selamat datang kembali.</h2><p class="intro">Masuk untuk melanjutkan pengelolaan portal sekolah.</p>
<?php if($error !== ''): ?><div class="login-error"><i class="fa-solid fa-circle-exclamation"></i> <?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" autocomplete="on"><label class="login-label">Nama pengguna</label><div class="login-input"><i class="fa-solid fa-user"></i><input name="username" required autocomplete="username" placeholder="Masukkan username"></div><label class="login-label">Kata sandi</label><div class="login-input"><i class="fa-solid fa-lock"></i><input type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password"></div><button class="login-submit" type="submit" name="login"><i class="fa-solid fa-arrow-right-to-bracket"></i> MASUK KE PORTAL</button></form>
<a class="login-home" href="index.php">← Kembali ke halaman sekolah</a></div></section></div></body></html>
