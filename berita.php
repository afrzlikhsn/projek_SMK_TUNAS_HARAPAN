<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login_admin.php');
    exit;
}

include __DIR__ . '/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC, id DESC");
$jumlah_berita = 0;
$query_jumlah = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM berita");
if ($query_jumlah) {
    $data_jumlah = mysqli_fetch_assoc($query_jumlah);
    $jumlah_berita = (int)($data_jumlah['total'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publikasi Sekolah - SMK Tunas Harapan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<?php include __DIR__ . '/includes/admin_sidebar.php'; ?>
<button class="admin-menu-toggle" type="button" onclick="document.getElementById('adminSidebar').classList.toggle('mobile-open')" aria-label="Buka menu">
    <i class="fa-solid fa-bars"></i>
</button>

<main class="admin-main">
    <header class="admin-topbar">
        <div class="admin-topbar-left">
            <div class="admin-topbar-icon"><i class="fa-solid fa-newspaper"></i></div>
            <div>
                <span class="admin-eyebrow">PANEL ADMINISTRATOR</span>
                <h1>Publikasi Sekolah</h1>
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

    <div class="admin-content">
        <section class="page-hero berita-hero">
            <div class="hero-eyebrow">INFORMASI SEKOLAH</div>
            <div class="berita-hero-row">
                <div>
                    <h1><i class="fa-solid fa-newspaper"></i> Kelola Publikasi Sekolah</h1>
                    <p>Kelola informasi, kegiatan, dan kabar terbaru SMK Tunas Harapan melalui satu halaman administrator.</p>
                </div>
                <div class="hero-stat">
                    <strong><?= $jumlah_berita ?></strong>
                    <span>Total Berita</span>
                </div>
            </div>
        </section>

        <section class="berita-summary-grid">
            <div class="berita-summary-card blue">
                <div class="berita-summary-icon"><i class="fa-solid fa-newspaper"></i></div>
                <div><span>Total Berita</span><strong><?= $jumlah_berita ?></strong><small>Berita tersimpan dalam sistem</small></div>
            </div>
            <div class="berita-summary-card orange">
                <div class="berita-summary-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <div><span>Aksi Cepat</span><strong>Tambah</strong><small>Buat berita sekolah baru</small></div>
            </div>
            <div class="berita-summary-card green">
                <div class="berita-summary-icon"><i class="fa-solid fa-images"></i></div>
                <div><span>Media</span><strong>Foto</strong><small>Dokumentasi berita sekolah</small></div>
            </div>
        </section>

        <section class="admin-card berita-table-card">
            <div class="toolbar berita-toolbar">
                <div class="toolbar-title">
                    <h3><i class="fa-solid fa-list"></i> Daftar Berita</h3>
                    <p id="beritaMeta">Menampilkan <?= $jumlah_berita ?> berita yang tersimpan.</p>
                </div>
                <div class="toolbar-right">
                    <div class="search-box">
                        <input type="text" id="searchBerita" placeholder="Cari judul berita..." autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <a href="tambah_berita.php" class="btn-admin btn-primary-admin">
                        <i class="fa-solid fa-plus"></i> Tambah Berita
                    </a>
                </div>
            </div>

            <div class="table-wrap">
                <table class="admin-table berita-table" id="beritaTable">
                    <thead>
                        <tr>
                            <th class="berita-no">No</th>
                            <th class="berita-photo">Foto</th>
                            <th>Judul Berita</th>
                            <th>Tanggal</th>
                            <th class="berita-action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($query && mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; while ($data = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><span class="number"><?= $no++ ?></span></td>
                                <td>
                                    <?php if (!empty($data['foto'])): ?>
                                        <img src="images/<?= htmlspecialchars($data['foto']) ?>" class="berita-thumb" alt="Foto berita">
                                    <?php else: ?>
                                        <div class="berita-thumb berita-thumb-empty"><i class="fa-regular fa-image"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="berita-title-cell">
                                        <strong><?= htmlspecialchars($data['judul']) ?></strong>
                                        <small>Informasi SMK Tunas Harapan</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="berita-date"><i class="fa-regular fa-calendar"></i> <?= date('d M Y', strtotime($data['tanggal'])) ?></span>
                                </td>
                                <td>
                                    <div class="action-wrapper">
                                        <a href="edit_berita.php?id=<?= (int)$data['id'] ?>" class="action-btn btn-edit" title="Edit Berita"><i class="fa-solid fa-pen"></i><span>Edit</span></a>
                                        <a href="hapus_berita.php?id=<?= (int)$data['id'] ?>" class="action-btn btn-delete" title="Hapus Berita" onclick="return confirm('Yakin ingin menghapus berita ini?')"><i class="fa-solid fa-trash"></i><span>Hapus</span></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr id="emptyBeritaRow">
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fa-regular fa-newspaper"></i>
                                    <strong>Belum Ada Berita</strong>
                                    <span>Silakan tambahkan berita sekolah melalui tombol "Tambah Berita".</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <?php include __DIR__ . '/includes/admin_footer.php'; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('searchBerita');
    const table = document.getElementById('beritaTable');
    const meta = document.getElementById('beritaMeta');
    if (!input || !table) return;

    input.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        const rows = Array.from(table.querySelectorAll('tbody tr')).filter(row => row.id !== 'emptyBeritaRow');
        let visible = 0;
        rows.forEach(row => {
            const match = row.innerText.toLowerCase().includes(keyword);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        meta.textContent = keyword ? `Menampilkan ${visible} berita yang sesuai pencarian.` : `Menampilkan ${rows.length} berita yang tersimpan.`;
    });
});
</script>
</body>
</html>
