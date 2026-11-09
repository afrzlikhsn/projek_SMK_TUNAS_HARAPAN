<?php
$current_admin_page=basename($_SERVER['PHP_SELF']??'dashboard_admin.php');
$admin_menu=[
 ['file'=>'dashboard_admin.php','label'=>'Ringkasan','icon'=>'fa-chart-pie'],
 ['file'=>'admin_program.php','label'=>'Program Keahlian','icon'=>'fa-compass-drafting'],
 ['file'=>'berita.php','label'=>'Publikasi','icon'=>'fa-newspaper'],
 ['file'=>'kelola_prestasi.php','label'=>'Capaian Siswa','icon'=>'fa-medal'],
 ['file'=>'admin_agenda.php','label'=>'Kalender Kegiatan','icon'=>'fa-calendar-check'],
 ['file'=>'fasilitas.php','label'=>'Sarana Sekolah','icon'=>'fa-building-columns'],
 ['file'=>'admin_kegiatan.php','label'=>'Galeri Sekolah','icon'=>'fa-images'],
 ['file'=>'pesan.php','label'=>'Kotak Pesan','icon'=>'fa-inbox'],
 ['file'=>'kelola_admin.php','label'=>'Kelola Administrator','icon'=>'fa-user-shield'],
];
?>
<aside class="admin-sidebar" id="adminSidebar">
  <div class="admin-sidebar-brand">
    <div class="admin-brand-mark admin-brand-logo"><img src="images/logo-smk-tunas-harapan.jpg" alt="Logo SMK Tunas Harapan"></div>
    <div class="admin-brand-text"><strong>SMK TUNAS HARAPAN</strong><small>PORTAL PENGELOLA</small></div>
  </div>
  <div class="admin-sidebar-scroll">
    <div class="admin-sidebar-section">RUANG KERJA</div>
    <nav class="admin-menu admin-menu-primary">
      <?php foreach($admin_menu as $item): ?><a href="<?=htmlspecialchars($item['file'])?>" class="admin-menu-link <?=$current_admin_page===basename($item['file'])?'active':''?>"><i class="fa-solid <?=htmlspecialchars($item['icon'])?> admin-menu-icon"></i><span class="admin-menu-label"><?=htmlspecialchars($item['label'])?></span></a><?php endforeach; ?>
    </nav>
    <div class="admin-sidebar-section">IDENTITAS DIGITAL</div>
    <nav class="admin-menu">
      <a href="konten_website.php" class="admin-menu-link <?=$current_admin_page==='konten_website.php'?'active':''?>"><i class="fa-solid fa-sliders admin-menu-icon"></i><span class="admin-menu-label">Identitas & Tampilan</span></a>
    </nav>
  </div>
  <div class="admin-sidebar-status"><i class="fa-solid fa-shield-halved"></i><div><strong>Sistem Aktif</strong><small>Data tersimpan & terkelola</small></div><span></span></div>
  <div class="admin-sidebar-bottom">
    <div class="admin-user-card"><div class="admin-user-avatar"><i class="fa-solid fa-user-gear"></i></div><div class="admin-user-text"><strong><?=htmlspecialchars($_SESSION['username']??'Administrator')?></strong><small>Pengelola sistem</small></div></div>
    <a href="logout_admin.php" class="admin-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Keluar Sistem</span></a>
  </div>
</aside>
