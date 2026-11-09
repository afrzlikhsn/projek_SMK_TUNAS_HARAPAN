<?php
if (!isset($koneksi)) require_once __DIR__ . '/../koneksi.php';
$nav_db = [
  'index.php'=>'Beranda',
  'About.php'=>'Profil',
  'program_keahlian.php'=>'Program Keahlian',
  'berita_user.php'=>'Publikasi',
  'agendabaru.php'=>'Kalender',
  'kegiatan.php'=>'Galeri',
  'prestasi.php'=>'Capaian',
  'contact.php'=>'Kontak'
];
$current_page=basename($_SERVER['PHP_SELF']??'index.php');
$logo='images/logo-smk-tunas-harapan.jpg';
$schoolName=site_setting($koneksi,'school_name','SMK TUNAS HARAPAN');
$schoolShort=site_setting($koneksi,'school_short','Batang Serangan • Langkat');
$address=site_setting($koneksi,'school_address','Batang Serangan, Kabupaten Langkat, Sumatera Utara');
$ig=site_setting($koneksi,'school_instagram','');
$fb=site_setting($koneksi,'school_facebook','');
$tiktok=site_setting($koneksi,'school_tiktok','');
$youtube=site_setting($koneksi,'school_youtube','');
$wa=site_setting($koneksi,'school_whatsapp','');
$icons=['index.php'=>'fa-solid fa-house','About.php'=>'fa-solid fa-building-columns','program_keahlian.php'=>'fa-solid fa-compass-drafting','berita_user.php'=>'fa-solid fa-newspaper','agendabaru.php'=>'fa-solid fa-calendar-days','kegiatan.php'=>'fa-solid fa-images','prestasi.php'=>'fa-solid fa-medal','contact.php'=>'fa-solid fa-location-dot'];
?>
<aside class="site-sidebar" id="siteSidebar">
  <div class="site-sidebar-inner">
    <div class="site-sidebar-brand">
      <a class="site-brand" href="index.php">
        <?php if($logo): ?><span class="site-brand-icon site-brand-logo"><img src="<?=site_e($logo)?>" alt="Logo <?=site_e($schoolName)?>"></span><?php else: ?><span class="site-brand-icon"><i class="fa-solid fa-school"></i></span><?php endif; ?>
        <span class="site-brand-text"><strong><?=site_e($schoolName)?></strong><small><?=site_e($schoolShort)?></small></span>
      </a>
      <button class="site-sidebar-close" id="siteSidebarClose" type="button" aria-label="Tutup menu"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="site-sidebar-label">JELAJAHI SEKOLAH</div>
    <nav class="site-sidebar-nav" aria-label="Navigasi utama">
      <?php foreach($nav_db as $file=>$label): ?>
        <a class="site-sidebar-link <?=$current_page===$file?'active':''?>" href="<?=site_e($file)?>">
          <span class="site-sidebar-link-icon"><i class="<?=site_e($icons[$file])?>"></i></span>
          <span><?=site_e($label)?></span>
          <?php if($current_page===$file): ?><span class="site-sidebar-arrow"><i class="fa-solid fa-chevron-right"></i></span><?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="site-sidebar-extra">
      <div class="site-sidebar-extra-head"><span>TERHUBUNG DENGAN KAMI</span><i class="fa-solid fa-sparkles"></i></div>
      <p>Ikuti informasi, kegiatan, dan karya siswa SMK Tunas Harapan.</p>
      <div class="site-sidebar-socials">
        <?php if($ig): ?><a class="social-instagram" href="<?=site_e($ig)?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
        <?php if($fb): ?><a class="social-facebook" href="<?=site_e($fb)?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a><?php endif; ?>
        <?php if($tiktok): ?><a class="social-tiktok" href="<?=site_e($tiktok)?>" target="_blank" rel="noopener" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a><?php endif; ?>
        <?php if($youtube): ?><a class="social-youtube" href="<?=site_e($youtube)?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a><?php endif; ?>
        <?php if($wa): ?><a class="social-whatsapp" href="https://wa.me/<?=site_e(preg_replace('/\D+/','',$wa))?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a><?php endif; ?>
        <?php if(!$ig && !$fb && !$tiktok && !$youtube && !$wa): ?><span class="site-sidebar-social-empty"><i class="fa-solid fa-share-nodes"></i> Media sosial sekolah</span><?php endif; ?>
      </div>
    </div>

    <div class="site-sidebar-contact">
      <div class="site-sidebar-contact-icon"><i class="fa-solid fa-location-dot"></i></div>
      <div><strong>SMK Tunas Harapan</strong><span><?=site_e($address)?></span></div>
    </div>

    <div class="site-sidebar-bottom">
      <span class="site-online-dot"></span>
      <div><strong>Portal Sekolah</strong><small>Aktif • <?=date('Y')?></small></div>
    </div>
  </div>
</aside>
<div class="site-sidebar-overlay" id="siteSidebarOverlay"></div>
<button class="site-mobile-menu" id="siteMobileMenu" type="button" aria-label="Buka menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
