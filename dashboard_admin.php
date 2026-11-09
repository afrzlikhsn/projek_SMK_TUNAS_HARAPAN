<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login_admin.php');
    exit;
}

require_once __DIR__ . '/koneksi.php';

function totalData(mysqli $koneksi, string $table): int
{
    $allowed = ['dataguru', 'berita', 'prestasi', 'agenda', 'fasilitas', 'pesan_masuk', 'datamapel', 'site_gallery', 'site_features', 'site_stats'];
    if (!in_array($table, $allowed, true)) {
        return 0;
    }

    $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM `$table`");
    if (!$result) {
        return 0;
    }

    $row = mysqli_fetch_assoc($result);
    return (int) ($row['total'] ?? 0);
}

$stats = [
        'berita' => totalData($koneksi, 'berita'),
    'prestasi' => totalData($koneksi, 'prestasi'),
    'agenda' => totalData($koneksi, 'agenda'),
    'fasilitas' => totalData($koneksi, 'fasilitas'),
        'pesan' => totalData($koneksi, 'pesan_masuk'),
    'gallery' => totalData($koneksi, 'site_gallery'),
];

$quickMenus = [
    ['title' => 'Publikasi', 'desc' => 'Kelola publikasi dan informasi.', 'icon' => 'fa-newspaper', 'url' => 'berita.php', 'class' => 'orange'],
    ['title' => 'Capaian Siswa', 'desc' => 'Kelola capaian dan karya siswa.', 'icon' => 'fa-trophy', 'url' => 'kelola_prestasi.php', 'class' => 'yellow'],
    ['title' => 'Kalender Kegiatan', 'desc' => 'Atur kalender kegiatan sekolah.', 'icon' => 'fa-calendar-days', 'url' => 'admin_agenda.php', 'class' => 'red'],
    ['title' => 'Galeri Sekolah', 'desc' => 'Atur galeri dokumentasi sekolah.', 'icon' => 'fa-images', 'url' => 'admin_kegiatan.php', 'class' => 'green'],
    ['title' => 'Sarana Sekolah', 'desc' => 'Atur sarana pendukung pembelajaran.', 'icon' => 'fa-school', 'url' => 'fasilitas.php', 'class' => 'green'],
    ['title' => 'Identitas & Tampilan', 'desc' => 'Kelola identitas, tampilan, informasi, dan galeri.', 'icon' => 'fa-globe', 'url' => 'konten_website.php', 'class' => 'blue'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | SMK Tunas Harapan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
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
                <span class="admin-eyebrow">PANEL ADMINISTRATOR</span>
                <h1>Dashboard</h1>
            </div>
        </div>

        <div class="admin-topbar-user">
            <div class="admin-topbar-avatar"><i class="fa-solid fa-user"></i></div>
            <div>
                <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                <small>Administrator</small>
            </div>
        </div>
    </header>

    <section class="admin-content">
        <div class="admin-welcome">
            <div class="admin-welcome-content">
                <span class="admin-welcome-label">SELAMAT DATANG 👋</span>
                <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
                <p>Kelola informasi SMK Tunas Harapan dengan lebih mudah melalui panel administrator.</p>
                <div class="admin-clock" id="adminClock"></div>
            </div>
            <div class="admin-welcome-shape shape-one"></div>
            <div class="admin-welcome-shape shape-two"></div>
        </div>

        <section class="admin-section">
            <div class="admin-section-heading">
                <div>
                    <span>RINGKASAN</span>
                    <h2>Data Sekolah</h2>
                </div>
                <p>Jumlah data yang tersimpan pada sistem.</p>
            </div>

            <div class="admin-stat-grid">
                <a class="admin-stat-card orange" href="berita.php">
                    <div class="admin-stat-icon"><i class="fa-solid fa-newspaper"></i></div>
                    <div><strong><?= $stats['berita'] ?></strong><span>Berita</span></div>
                    <i class="fa-solid fa-arrow-up-right-from-square admin-stat-arrow"></i>
                </a>
                <a class="admin-stat-card yellow" href="kelola_prestasi.php">
                    <div class="admin-stat-icon"><i class="fa-solid fa-trophy"></i></div>
                    <div><strong><?= $stats['prestasi'] ?></strong><span>Prestasi</span></div>
                    <i class="fa-solid fa-arrow-up-right-from-square admin-stat-arrow"></i>
                </a>
                <a class="admin-stat-card red" href="admin_agenda.php">
                    <div class="admin-stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
                    <div><strong><?= $stats['agenda'] ?></strong><span>Agenda</span></div>
                    <i class="fa-solid fa-arrow-up-right-from-square admin-stat-arrow"></i>
                </a>
                <a class="admin-stat-card green" href="fasilitas.php">
                    <div class="admin-stat-icon"><i class="fa-solid fa-school"></i></div>
                    <div><strong><?= $stats['fasilitas'] ?></strong><span>Fasilitas</span></div>
                    <i class="fa-solid fa-arrow-up-right-from-square admin-stat-arrow"></i>
                </a>
            </div>
        </section>

        <section class="admin-section admin-lower-grid">
            <div class="admin-panel">
                <div class="admin-panel-heading">
                    <div>
                        <span>AKSES CEPAT</span>
                        <h2>Menu Utama</h2>
                    </div>
                </div>
                <div class="admin-quick-grid">
                    <?php foreach ($quickMenus as $menu): ?>
                        <a href="<?= htmlspecialchars($menu['url']) ?>" class="admin-quick-card <?= htmlspecialchars($menu['class']) ?>">
                            <span class="admin-quick-icon"><i class="fa-solid <?= htmlspecialchars($menu['icon']) ?>"></i></span>
                            <span class="admin-quick-text">
                                <strong><?= htmlspecialchars($menu['title']) ?></strong>
                                <small><?= htmlspecialchars($menu['desc']) ?></small>
                            </span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>

        <?php include __DIR__ . '/includes/admin_footer.php'; ?>
    </section>
</main>

<script>
(function () {
    const toggle = document.getElementById('adminMenuToggle');
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const clock = document.getElementById('adminClock');

    function setMenu(open) {
        if (!sidebar || !overlay) return;
        sidebar.classList.toggle('mobile-open', open);
        overlay.classList.toggle('show', open);
        document.body.classList.toggle('menu-open', open);
    }

    if (toggle) toggle.addEventListener('click', () => setMenu(!sidebar.classList.contains('mobile-open')));
    if (overlay) overlay.addEventListener('click', () => setMenu(false));

    function updateClock() {
        const now = new Date();
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        const pad = n => String(n).padStart(2, '0');
        clock.innerHTML = '<i class="fa-regular fa-clock"></i> ' +
            days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear() +
            ' • ' + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds()) + ' WIB';
    }

    updateClock();
    setInterval(updateClock, 1000);
})();
</script>
</body>
</html>
