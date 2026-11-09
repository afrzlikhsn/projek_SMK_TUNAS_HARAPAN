<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login_admin.php');
    exit;
}

require_once __DIR__ . '/koneksi.php';

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$message = '';
$error = '';
$currentId = (int)$_SESSION['id_admin'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $username = trim($_POST['username'] ?? '');
        $passwordLama = (string)($_POST['password_lama'] ?? '');
        $passwordBaru = (string)($_POST['password_baru'] ?? '');
        $konfirmasi = (string)($_POST['konfirmasi_password'] ?? '');

        if ($username === '') {
            $error = 'Username tidak boleh kosong.';
        } elseif ($passwordBaru !== '' && strlen($passwordBaru) < 6) {
            $error = 'Password baru minimal 6 karakter.';
        } elseif ($passwordBaru !== $konfirmasi) {
            $error = 'Konfirmasi password baru tidak sama.';
        } else {
            $stmt = mysqli_prepare($koneksi, "SELECT id_admin, username, password FROM admin WHERE id_admin = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt, 'i', $currentId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $admin = $result ? mysqli_fetch_assoc($result) : null;
            mysqli_stmt_close($stmt);

            if (!$admin) {
                $error = 'Akun administrator tidak ditemukan.';
            } else {
                $passwordValid = password_verify($passwordLama, $admin['password']) || hash_equals((string)$admin['password'], $passwordLama);

                if (!$passwordValid) {
                    $error = 'Password lama tidak sesuai.';
                } else {
                    $check = mysqli_prepare($koneksi, "SELECT id_admin FROM admin WHERE username = ? AND id_admin <> ? LIMIT 1");
                    mysqli_stmt_bind_param($check, 'si', $username, $currentId);
                    mysqli_stmt_execute($check);
                    $exists = mysqli_stmt_get_result($check);
                    $duplicate = $exists && mysqli_num_rows($exists) > 0;
                    mysqli_stmt_close($check);

                    if ($duplicate) {
                        $error = 'Username tersebut sudah digunakan administrator lain.';
                    } else {
                        if ($passwordBaru !== '') {
                            $hash = password_hash($passwordBaru, PASSWORD_DEFAULT);
                            $update = mysqli_prepare($koneksi, "UPDATE admin SET username = ?, password = ? WHERE id_admin = ?");
                            mysqli_stmt_bind_param($update, 'ssi', $username, $hash, $currentId);
                        } else {
                            $update = mysqli_prepare($koneksi, "UPDATE admin SET username = ? WHERE id_admin = ?");
                            mysqli_stmt_bind_param($update, 'si', $username, $currentId);
                        }

                        if ($update && mysqli_stmt_execute($update)) {
                            mysqli_stmt_close($update);
                            $_SESSION['username'] = $username;
                            $message = 'Data akun berhasil diperbarui.';
                        } else {
                            if ($update) mysqli_stmt_close($update);
                            $error = 'Data akun gagal diperbarui.';
                        }
                    }
                }
            }
        }
    }

    if ($action === 'add_admin') {
        $username = trim($_POST['username_baru'] ?? '');
        $password = (string)($_POST['password_baru_admin'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Username dan password administrator baru wajib diisi.';
        } elseif (strlen($password) < 6) {
            $error = 'Password administrator minimal 6 karakter.';
        } else {
            $check = mysqli_prepare($koneksi, "SELECT id_admin FROM admin WHERE username = ? LIMIT 1");
            mysqli_stmt_bind_param($check, 's', $username);
            mysqli_stmt_execute($check);
            $result = mysqli_stmt_get_result($check);
            $duplicate = $result && mysqli_num_rows($result) > 0;
            mysqli_stmt_close($check);

            if ($duplicate) {
                $error = 'Username tersebut sudah digunakan.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = mysqli_prepare($koneksi, "INSERT INTO admin (username, password) VALUES (?, ?)");
                mysqli_stmt_bind_param($insert, 'ss', $username, $hash);

                if (mysqli_stmt_execute($insert)) {
                    mysqli_stmt_close($insert);
                    $message = 'Administrator baru berhasil ditambahkan.';
                } else {
                    mysqli_stmt_close($insert);
                    $error = 'Administrator baru gagal ditambahkan.';
                }
            }
        }
    }

    if ($action === 'delete_admin') {
        $deleteId = (int)($_POST['id_admin'] ?? 0);

        if ($deleteId === $currentId) {
            $error = 'Akun yang sedang digunakan tidak boleh dihapus.';
        } else {
            $countResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM admin");
            $countRow = $countResult ? mysqli_fetch_assoc($countResult) : ['total' => 0];

            if ((int)$countRow['total'] <= 1) {
                $error = 'Minimal harus ada satu administrator.';
            } else {
                $delete = mysqli_prepare($koneksi, "DELETE FROM admin WHERE id_admin = ?");
                mysqli_stmt_bind_param($delete, 'i', $deleteId);

                if (mysqli_stmt_execute($delete)) {
                    mysqli_stmt_close($delete);
                    $message = 'Administrator berhasil dihapus.';
                } else {
                    mysqli_stmt_close($delete);
                    $error = 'Administrator gagal dihapus.';
                }
            }
        }
    }
}

$admins = mysqli_query($koneksi, "SELECT id_admin, username FROM admin ORDER BY id_admin ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kelola Administrator | SMK Tunas Harapan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/admin.css">
<style>
.account-wrap{max-width:1100px;margin:0 auto;padding:28px 20px 45px}
.account-head{margin-bottom:22px}.account-head h1{margin:0 0 7px;font-size:28px}.account-head p{margin:0;color:#748092}
.account-grid{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(320px,.95fr);gap:20px}
.account-card{background:#fff;border:1px solid #e8ebf0;border-radius:16px;padding:24px;box-shadow:0 8px 24px rgba(15,23,42,.05)}
.account-card h3{margin:0 0 5px;font-size:18px}.account-card .sub{margin:0 0 20px;color:#7a8494;font-size:13px}
.account-label{display:block;font-size:12px;font-weight:700;color:#394456;margin:14px 0 7px}
.account-input{width:100%;height:42px;border:1px solid #dce1e8;border-radius:9px;padding:0 12px;outline:0}
.account-input:focus{border-color:#e66b4e;box-shadow:0 0 0 3px rgba(230,107,78,.1)}
.account-btn{border:0;border-radius:9px;padding:11px 16px;font-weight:700;cursor:pointer}.account-btn-primary{background:#e66b4e;color:#fff}.account-btn-primary:hover{background:#c94f37}
.account-btn-danger{background:#fff0ed;color:#b34c39}.account-alert{padding:11px 14px;border-radius:9px;margin-bottom:18px;font-size:13px}.account-success{background:#edf9f2;color:#217446;border:1px solid #c8ecd7}.account-error{background:#fff1ef;color:#b34c39;border:1px solid #f1cbc4}
.account-table{width:100%;border-collapse:collapse}.account-table th,.account-table td{padding:12px 10px;border-bottom:1px solid #edf0f4;text-align:left;font-size:13px}.account-table th{font-size:11px;text-transform:uppercase;color:#7b8593}.account-badge{display:inline-flex;padding:5px 8px;border-radius:20px;background:#eef4ff;color:#315f9c;font-size:11px;font-weight:700}
.account-form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
@media(max-width:850px){.account-grid{grid-template-columns:1fr}}@media(max-width:560px){.account-form-row{grid-template-columns:1fr}.account-wrap{padding:20px 14px}}
</style>
</head>
<body class="admin-page">
<button class="admin-menu-toggle" id="adminMenuToggle" type="button" aria-label="Buka menu"><i class="fa-solid fa-bars"></i></button>
<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>
<main class="admin-main">
    <div class="account-wrap">
        <div class="account-head">
            <h1><i class="fa-solid fa-user-shield"></i> Kelola Administrator</h1>
            <p>Ubah username, password, serta kelola akun yang memiliki akses ke panel pengelola.</p>
        </div>

        <?php if ($message !== ''): ?><div class="account-alert account-success"><i class="fa-solid fa-circle-check"></i> <?=e($message)?></div><?php endif; ?>
        <?php if ($error !== ''): ?><div class="account-alert account-error"><i class="fa-solid fa-circle-exclamation"></i> <?=e($error)?></div><?php endif; ?>

        <div class="account-grid">
            <section class="account-card">
                <h3>Akun Saya</h3>
                <p class="sub">Username dapat diganti. Password baru boleh dikosongkan jika hanya ingin mengganti username.</p>
                <form method="post">
                    <input type="hidden" name="action" value="update_profile">
                    <label class="account-label">Username</label>
                    <input class="account-input" type="text" name="username" value="<?=e($_SESSION['username'] ?? '')?>" maxlength="50" required>

                    <label class="account-label">Password Lama</label>
                    <input class="account-input" type="password" name="password_lama" autocomplete="current-password" required>

                    <div class="account-form-row">
                        <div>
                            <label class="account-label">Password Baru</label>
                            <input class="account-input" type="password" name="password_baru" minlength="6" autocomplete="new-password" placeholder="Minimal 6 karakter">
                        </div>
                        <div>
                            <label class="account-label">Konfirmasi Password Baru</label>
                            <input class="account-input" type="password" name="konfirmasi_password" minlength="6" autocomplete="new-password">
                        </div>
                    </div>

                    <div style="margin-top:20px">
                        <button class="account-btn account-btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </section>

            <section class="account-card">
                <h3>Daftar Administrator</h3>
                <p class="sub">Tambah akun operator lain atau hapus akun yang sudah tidak diperlukan.</p>
                <div style="overflow:auto">
                    <table class="account-table">
                        <thead><tr><th>Username</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                        <?php while ($a = mysqli_fetch_assoc($admins)): ?>
                            <tr>
                                <td><strong><?=e($a['username'])?></strong></td>
                                <td>
                                    <?php if ((int)$a['id_admin'] === $currentId): ?>
                                        <span class="account-badge">Akun aktif</span>
                                    <?php else: ?>
                                        <span class="account-badge">Administrator</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:right">
                                    <?php if ((int)$a['id_admin'] !== $currentId): ?>
                                    <form method="post" onsubmit="return confirm('Hapus administrator ini?');">
                                        <input type="hidden" name="action" value="delete_admin">
                                        <input type="hidden" name="id_admin" value="<?=e($a['id_admin'])?>">
                                        <button class="account-btn account-btn-danger" type="submit" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <hr style="border:0;border-top:1px solid #edf0f4;margin:22px 0">
                <h3>Tambah Administrator</h3>
                <p class="sub">Buat akun baru dengan password yang disimpan secara aman.</p>
                <form method="post">
                    <input type="hidden" name="action" value="add_admin">
                    <label class="account-label">Username Baru</label>
                    <input class="account-input" type="text" name="username_baru" maxlength="50" required>
                    <label class="account-label">Password Baru</label>
                    <input class="account-input" type="password" name="password_baru_admin" minlength="6" required>
                    <div style="margin-top:18px">
                        <button class="account-btn account-btn-primary" type="submit"><i class="fa-solid fa-user-plus"></i> Tambah Administrator</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
<script>
(function(){
    var btn=document.getElementById('adminMenuToggle');
    var sidebar=document.getElementById('adminSidebar');
    if(btn && sidebar){btn.addEventListener('click',function(){sidebar.classList.toggle('open');});}
})();
</script>
</body>
</html>
