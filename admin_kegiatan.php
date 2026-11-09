<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login_admin.php');
    exit;
}
require_once __DIR__ . '/koneksi.php';

$uploadDir = __DIR__ . '/uploads/site/';
$uploadWeb = 'uploads/site/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0775, true);
}

$message = (string)($_SESSION['kegiatan_flash_success'] ?? '');
$error = '';
unset($_SESSION['kegiatan_flash_success']);

function kegiatan_upload_image(string $field, string $old = ''): string {
    global $uploadDir, $uploadWeb;

    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return $old;
    }

    $allowed = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp'
    ];

    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!isset($allowed[$ext]) || !@getimagesize($_FILES[$field]['tmp_name'])) {
        return $old;
    }

    if ((int)$_FILES[$field]['size'] > 4 * 1024 * 1024) {
        return $old;
    }

    $name = 'kegiatan_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . $name)) {
        return $uploadWeb . $name;
    }

    return $old;
}

function kegiatan_delete_image(string $path): void {
    if ($path === '') return;
    $prefix = 'uploads/site/';
    if (strpos($path, $prefix) !== 0) return;

    $file = __DIR__ . '/' . $path;
    if (is_file($file)) {
        @unlink($file);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = trim($_POST['category'] ?? 'Kegiatan');
        $eventDate = trim($_POST['event_date'] ?? '');
        $eventDate = $eventDate !== '' ? $eventDate : null;
        $status = ($_POST['status'] ?? 'Aktif') === 'Aktif' ? 'Aktif' : 'Nonaktif';

        if ($title === '') {
            $error = 'Judul kegiatan wajib diisi.';
        } else {
            $oldImage = '';
            if ($id > 0) {
                $qOld = mysqli_query($koneksi, "SELECT image FROM site_gallery WHERE id=" . $id);
                if ($qOld && ($oldRow = mysqli_fetch_assoc($qOld))) {
                    $oldImage = $oldRow['image'] ?? '';
                }
            }

            $image = kegiatan_upload_image('image', $oldImage);

            if ($id > 0) {
                $stmt = mysqli_prepare(
                    $koneksi,
                    "UPDATE site_gallery
                     SET title=?, description=?, image=?, category=?, event_date=?, status=?
                     WHERE id=?"
                );
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssssssi', $title, $description, $image, $category, $eventDate, $status, $id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    if ($image !== $oldImage && $oldImage !== '') {
                        kegiatan_delete_image($oldImage);
                    }

                    $_SESSION['kegiatan_flash_success'] = 'Dokumentasi kegiatan berhasil diperbarui.';
                    header('Location: admin_kegiatan.php');
                    exit;
                } else {
                    $error = 'Gagal memperbarui dokumentasi.';
                }
            } else {
                $stmt = mysqli_prepare(
                    $koneksi,
                    "INSERT INTO site_gallery (title, description, image, category, event_date, status)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssssss', $title, $description, $image, $category, $eventDate, $status);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    $_SESSION['kegiatan_flash_success'] = 'Dokumentasi kegiatan berhasil ditambahkan.';
                    header('Location: admin_kegiatan.php');
                    exit;
                } else {
                    $error = 'Gagal menambahkan dokumentasi.';
                }
            }
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);

        if ($id > 0) {
            $q = mysqli_query($koneksi, "SELECT image FROM site_gallery WHERE id=" . $id);
            $row = $q ? mysqli_fetch_assoc($q) : null;

            if (mysqli_query($koneksi, "DELETE FROM site_gallery WHERE id=" . $id)) {
                if ($row && !empty($row['image'])) {
                    kegiatan_delete_image($row['image']);
                }
                $_SESSION['kegiatan_flash_success'] = 'Dokumentasi kegiatan berhasil dihapus.';
                header('Location: admin_kegiatan.php');
                exit;
            } else {
                $error = 'Gagal menghapus dokumentasi.';
            }
        }
    }
}

$items = [];
$q = mysqli_query(
    $koneksi,
    "SELECT * FROM site_gallery
     ORDER BY COALESCE(event_date, '1000-01-01') DESC, id DESC"
);
while ($q && ($row = mysqli_fetch_assoc($q))) {
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Sekolah | Admin SMK Tunas Harapan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        .kegiatan-form-grid{
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:16px;
        }
        .kegiatan-form-grid .full{grid-column:1/-1}
        .kegiatan-form-grid label{
            display:flex;
            flex-direction:column;
            gap:7px;
            color:#475569;
            font-size:12px;
            font-weight:700;
        }
        .kegiatan-form-grid input,
        .kegiatan-form-grid textarea,
        .kegiatan-form-grid select{
            width:100%;
            border:1px solid #e3e8f1;
            border-radius:11px;
            padding:11px 12px;
            outline:none;
            background:#fff;
            color:#172033;
            font:inherit;
            font-size:13px;
        }
        .kegiatan-form-grid textarea{min-height:110px;resize:vertical}
        .kegiatan-form-grid input:focus,
        .kegiatan-form-grid textarea:focus,
        .kegiatan-form-grid select:focus{
            border-color:#8db1ff;
            box-shadow:0 0 0 3px rgba(37,99,235,.09);
        }
        .kegiatan-card{
            overflow:hidden;
        }
        .kegiatan-card-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            padding:18px 20px;
            border-bottom:1px solid #e7ebf2;
        }
        .kegiatan-card-head h2{margin:0;font-size:18px}
        .kegiatan-card-head p{margin:5px 0 0;color:#7b879c;font-size:12px}
        .kegiatan-card-head .icon{
            width:42px;height:42px;border-radius:12px;background:#e5f5f1;color:#0b6b57;
            display:grid;place-items:center;font-size:18px;
        }
        .kegiatan-form{padding:20px}
        .kegiatan-list{
            display:grid;
            grid-template-columns:repeat(3,minmax(0,1fr));
            gap:18px;
            padding:20px;
        }
        .kegiatan-item{
            border:1px solid #e7ebf2;
            border-radius:16px;
            overflow:hidden;
            background:#fff;
            box-shadow:0 8px 22px rgba(20,35,70,.05);
        }
        .kegiatan-image{
            width:100%;height:175px;object-fit:cover;display:block;background:#edf2f7;
        }
        .kegiatan-body{padding:16px}
        .kegiatan-body h3{margin:0 0 7px;font-size:16px;color:#193574}
        .kegiatan-meta{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:9px}
        .kegiatan-badge{
            display:inline-flex;align-items:center;gap:5px;padding:5px 8px;border-radius:999px;
            background:#e8f4f1;color:#0b6b57;font-size:10px;font-weight:700;
        }
        .kegiatan-badge.status{background:#ecfdf3;color:#16834b}
        .kegiatan-desc{margin:0;color:#7b879c;font-size:12px;line-height:1.65;min-height:40px}
        .kegiatan-actions{display:flex;gap:8px;margin-top:14px}
        .kegiatan-actions button,.kegiatan-actions a{
            flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;
            border:0;border-radius:9px;padding:9px 10px;font-size:11px;font-weight:700;cursor:pointer;
            text-decoration:none;
        }
        .btn-kegiatan-edit{background:#e8f4f1;color:#0b6b57}
        .btn-kegiatan-delete{background:#fff1f2;color:#dc2626}
        .kegiatan-empty{padding:45px 20px;text-align:center;color:#94a3b8}
        .kegiatan-empty i{font-size:42px;color:#cbd5e1;margin-bottom:10px}
        .kegiatan-note{
            margin-top:12px;padding:11px 13px;border-radius:10px;background:#f8fafc;color:#7b879c;font-size:11px;line-height:1.6;
        }
        .kegiatan-alert{margin-bottom:18px;padding:13px 15px;border-radius:12px;font-size:12px;font-weight:600}
        .kegiatan-alert.success{background:#ecfdf3;color:#15803d;border:1px solid #bbf7d0}
        .kegiatan-alert.error{background:#fff1f2;color:#be123c;border:1px solid #fecdd3}
        .kegiatan-edit-box{
            display:none;margin-top:14px;padding-top:14px;border-top:1px solid #edf1f7;
        }
        .kegiatan-edit-box.open{display:block}
        @media(max-width:1100px){
            .kegiatan-list{grid-template-columns:repeat(2,minmax(0,1fr))}
        }
        @media(max-width:700px){
            .kegiatan-form-grid{grid-template-columns:1fr}
            .kegiatan-form-grid .full{grid-column:auto}
            .kegiatan-list{grid-template-columns:1fr}
        }
    </style>
</head>
<body class="admin-page">
<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>
<div class="admin-overlay" id="adminOverlay"></div>

<main class="admin-main">
    <header class="admin-topbar">
        <div class="admin-topbar-left">
            <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Buka menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div>
                <span class="admin-eyebrow">DOKUMENTASI SEKOLAH</span>
                <h1>Galeri Sekolah</h1>
            </div>
        </div>
        <div class="admin-topbar-user">
            <div class="admin-topbar-avatar"><i class="fa-solid fa-user"></i></div>
            <div>
                <strong><?= site_e($_SESSION['username'] ?? 'Administrator') ?></strong>
                <small>Administrator</small>
            </div>
        </div>
    </header>

    <section class="admin-content">
        <?php if ($message): ?>
            <div class="kegiatan-alert success"><i class="fa-solid fa-circle-check"></i> <?= site_e($message) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="kegiatan-alert error"><i class="fa-solid fa-circle-exclamation"></i> <?= site_e($error) ?></div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <h2 class="admin-title">Dokumentasi Kegiatan Siswa</h2>
                <p class="admin-subtitle">Tambahkan foto dan informasi kegiatan siswa, ekstrakurikuler, serta kegiatan sekolah. Data di halaman ini otomatis tampil pada menu Kegiatan di website.</p>
            </div>
        </div>

        <div class="admin-card kegiatan-card" style="margin-bottom:20px">
            <div class="kegiatan-card-head">
                <div>
                    <h2><i class="fa-solid fa-plus-circle" style="color:#0b6b57"></i> Tambah Dokumentasi</h2>
                    <p>Gunakan foto yang jelas dan informasi singkat agar dokumentasi terlihat rapi.</p>
                </div>
                <div class="icon"><i class="fa-solid fa-images"></i></div>
            </div>
            <form class="kegiatan-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save">
                <div class="kegiatan-form-grid">
                    <label>Judul Kegiatan
                        <input type="text" name="title" placeholder="Contoh: Lomba Futsal Antar Kelas" required>
                    </label>
                    <label>Kategori
                        <input type="text" name="category" value="Kegiatan Siswa" placeholder="Kegiatan Siswa / Ekstrakurikuler">
                    </label>
                    <label>Tanggal Kegiatan
                        <input type="date" name="event_date">
                    </label>
                    <label>Status
                        <select name="status">
                            <option value="Aktif">Aktif — tampil di website</option>
                            <option value="Nonaktif">Nonaktif — sembunyikan</option>
                        </select>
                    </label>
                    <label class="full">Deskripsi
                        <textarea name="description" placeholder="Ceritakan singkat kegiatan siswa..."></textarea>
                    </label>
                    <label class="full">Foto Dokumentasi
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                    </label>
                </div>
                <div class="kegiatan-note"><i class="fa-solid fa-circle-info"></i> Format JPG, PNG, atau WEBP maksimal 4 MB.</div>
                <div style="margin-top:16px">
                    <button type="submit" class="btn-admin btn-primary-admin"><i class="fa-solid fa-floppy-disk"></i> Simpan Dokumentasi</button>
                </div>
            </form>
        </div>

        <div class="admin-card kegiatan-card">
            <div class="kegiatan-card-head">
                <div>
                    <h2><i class="fa-solid fa-photo-film" style="color:#0b6b57"></i> Dokumentasi Tersimpan</h2>
                    <p><?= count($items) ?> dokumentasi tersimpan • terbaru ditampilkan paling atas</p>
                </div>
                <div class="icon"><i class="fa-solid fa-layer-group"></i></div>
            </div>

            <?php if ($items): ?>
                <div class="kegiatan-list">
                    <?php foreach ($items as $item): ?>
                        <article class="kegiatan-item">
                            <img class="kegiatan-image" src="<?= site_e($item['image'] ?: 'images/gerbang.jpg') ?>" alt="<?= site_e($item['title']) ?>">
                            <div class="kegiatan-body">
                                <div class="kegiatan-meta">
                                    <span class="kegiatan-badge"><i class="fa-solid fa-tag"></i> <?= site_e($item['category']) ?></span>
                                    <?php if (!empty($item['event_date'])): ?>
                                        <span class="kegiatan-badge"><i class="fa-regular fa-calendar"></i> <?= site_e(date('d/m/Y', strtotime($item['event_date']))) ?></span>
                                    <?php endif; ?>
                                    <span class="kegiatan-badge status"><i class="fa-solid fa-circle"></i> <?= site_e($item['status']) ?></span>
                                </div>
                                <h3><?= site_e($item['title']) ?></h3>
                                <p class="kegiatan-desc"><?= site_e($item['description'] ?: 'Tidak ada deskripsi.') ?></p>

                                <div class="kegiatan-actions">
                                    <button type="button" class="btn-kegiatan-edit" onclick="toggleEdit(<?= (int)$item['id'] ?>)">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                    <form method="post" style="flex:1" onsubmit="return confirm('Hapus dokumentasi <?= htmlspecialchars($item['title'], ENT_QUOTES) ?>?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn-kegiatan-delete" style="width:100%">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>

                                <div class="kegiatan-edit-box" id="edit-<?= (int)$item['id'] ?>">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="save">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <div class="kegiatan-form-grid">
                                            <label class="full">Judul
                                                <input type="text" name="title" value="<?= site_e($item['title']) ?>" required>
                                            </label>
                                            <label>Kategori
                                                <input type="text" name="category" value="<?= site_e($item['category']) ?>">
                                            </label>
                                            <label>Tanggal
                                                <input type="date" name="event_date" value="<?= site_e($item['event_date']) ?>">
                                            </label>
                                            <label>Status
                                                <select name="status">
                                                    <option value="Aktif" <?= $item['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="Nonaktif" <?= $item['status'] === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                                </select>
                                            </label>
                                            <label class="full">Deskripsi
                                                <textarea name="description"><?= site_e($item['description']) ?></textarea>
                                            </label>
                                            <label class="full">Ganti Foto
                                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                                            </label>
                                        </div>
                                        <div style="margin-top:12px">
                                            <button type="submit" class="btn-admin btn-primary-admin"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="kegiatan-empty">
                    <i class="fa-regular fa-images"></i>
                    <h3>Belum ada dokumentasi</h3>
                    <p>Tambahkan dokumentasi kegiatan siswa menggunakan formulir di atas.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
(function(){
    const toggle = document.getElementById('adminMenuToggle');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    if (toggle) toggle.addEventListener('click', function(){
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('show');
    });
    if (overlay) overlay.addEventListener('click', function(){
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('show');
    });
    window.toggleEdit = function(id){
        const el = document.getElementById('edit-' + id);
        if (el) el.classList.toggle('open');
    };
})();
</script>
</body>
</html>
