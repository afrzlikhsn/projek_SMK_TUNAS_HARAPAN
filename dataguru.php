<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login_admin.php');
    exit;
}
include __DIR__ . '/koneksi.php';

$total_guru = 0;
$query = mysqli_query($koneksi, "SELECT * FROM dataguru ORDER BY id_guru DESC");
if ($query) {
    $total_guru = mysqli_num_rows($query);
}

$jumlah_pesan = 0;
$qPesan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pesan_masuk");
if ($qPesan) {
    $jumlah_pesan = (int) mysqli_fetch_assoc($qPesan)['total'];
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tenaga Pendidik | Admin SMK Tunas Harapan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="admin-page">
<button class="admin-menu-toggle" id="adminMenuToggle" type="button" aria-label="Buka menu"><i class="fa-solid fa-bars"></i></button>
<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>

<main class="admin-main">
    <header class="admin-topbar">
        <div class="admin-topbar-left">
            <div class="admin-topbar-icon"><i class="fa-solid fa-user-tie"></i></div>
            <div>
                <span class="admin-eyebrow">DATA SEKOLAH</span>
                <h1>Tenaga Pendidik</h1>
            </div>
        </div>
        <div class="admin-topbar-user">
            <div class="admin-topbar-avatar"><i class="fa-solid fa-user"></i></div>
            <div>
                <strong><?= e($_SESSION['username'] ?? 'admin') ?></strong>
                <small>Administrator</small>
            </div>
        </div>
    </header>

    <div class="admin-content">
        <section class="page-hero guru-hero">
            <div>
                <span class="hero-eyebrow">MANAJEMEN DATA</span>
                <h1><i class="fa-solid fa-chalkboard-user"></i> Tenaga Pendidik</h1>
                <p>Kelola informasi guru dan tenaga pendidik SMK Tunas Harapan dengan mudah melalui halaman administrator.</p>
            </div>
            <div class="hero-stat"><strong><?= $total_guru ?></strong><span>Guru terdaftar</span></div>
        </section>

        <section class="guru-stat-grid">
            <div class="guru-stat-card blue">
                <div class="guru-stat-icon"><i class="fa-solid fa-users"></i></div>
                <div><span>Total Guru</span><strong><?= $total_guru ?></strong><small>Data tersimpan</small></div>
            </div>
            <div class="guru-stat-card green">
                <div class="guru-stat-icon"><i class="fa-solid fa-user-check"></i></div>
                <div><span>Status Data</span><strong>Aktif</strong><small>Siap dikelola</small></div>
            </div>
            <div class="guru-stat-card orange">
                <div class="guru-stat-icon"><i class="fa-solid fa-envelope"></i></div>
                <div><span>Pesan Masuk</span><strong><?= $jumlah_pesan ?></strong><small>Pesan tersimpan</small></div>
            </div>
        </section>

        <section class="admin-card guru-table-card">
            <div class="toolbar guru-toolbar">
                <div class="toolbar-title">
                    <span class="section-kicker">DATA GURU</span>
                    <h3><i class="fa-solid fa-list"></i> Daftar Guru</h3>
                    <p>Gunakan pencarian untuk menemukan guru dengan cepat.</p>
                </div>
                <div class="toolbar-right">
                    <div class="search-box guru-search">
                        <input type="search" id="searchGuru" placeholder="Cari nama, mapel, NSM, alamat..." autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <a href="tambah_guru.php" class="btn-admin btn-primary-admin"><i class="fa-solid fa-plus"></i> Tambah Guru</a>
                </div>
            </div>

            <div class="table-meta">
                <span><i class="fa-solid fa-circle-info"></i> Menampilkan <b id="visibleGuru"><?= $total_guru ?></b> dari <?= $total_guru ?> data guru</span>
            </div>

            <div class="table-wrap">
                <table class="admin-table guru-table" id="guruTable">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th>Guru</th>
                            <th>Kurikulum</th>
                            <th>NSM</th>
                            <th>Alamat</th>
                            <th>Tanggal Lahir</th>
                            <th class="col-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($total_guru > 0): $no = 1; while ($data = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td class="col-no"><span class="number"><?= $no++ ?></span></td>
                            <td>
                                <div class="teacher">
                                    <div class="teacher-avatar"><i class="fa-solid fa-user"></i></div>
                                    <div class="teacher-info">
                                        <strong class="teacher-name"><?= e($data['nama']) ?></strong>
                                        <small>Tenaga pendidik</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-admin"><?= e($data['mapel']) ?></span></td>
                            <td class="muted-text"><?= e($data['nsm']) ?></td>
                            <td class="muted-text address-cell"><?= e($data['alamat']) ?></td>
                            <td class="muted-text"><i class="fa-regular fa-calendar"></i> <?= e($data['tanggal_lahir']) ?></td>
                            <td class="col-action">
                                <div class="action-wrapper">
                                    <a href="edit_guru.php?id_guru=<?= (int)$data['id_guru'] ?>" class="action-btn btn-edit" title="Edit data guru"><i class="fa-solid fa-pen"></i><span>Edit</span></a>
                                    <a href="hapus_guru.php?id_guru=<?= (int)$data['id_guru'] ?>" class="action-btn btn-delete" title="Hapus data guru" onclick="return confirm('Yakin ingin menghapus data guru <?= e($data['nama']) ?>?');"><i class="fa-solid fa-trash"></i><span>Hapus</span></a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-user-slash"></i><h4>Belum Ada Tenaga Pendidik</h4><p>Silakan tambahkan data guru terlebih dahulu.</p><a href="tambah_guru.php" class="btn-admin btn-primary-admin"><i class="fa-solid fa-plus"></i> Tambah Guru</a></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php include __DIR__ . '/includes/admin_footer.php'; ?>
    </div>
</main>

<script>
(function () {
    const search = document.getElementById('searchGuru');
    const table = document.getElementById('guruTable');
    const counter = document.getElementById('visibleGuru');
    const toggle = document.getElementById('adminMenuToggle');
    const sidebar = document.getElementById('adminSidebar');

    if (search && table) {
        search.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visible = 0;
            table.querySelectorAll('tbody tr').forEach(row => {
                const match = row.innerText.toLowerCase().includes(keyword);
                row.style.display = match ? '' : 'none';
                if (match && row.querySelector('.teacher-name')) visible++;
            });
            if (counter) counter.textContent = visible;
        });
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
            sidebar.classList.toggle('open');
        });
    }
})();
</script>
</body>
</html>
