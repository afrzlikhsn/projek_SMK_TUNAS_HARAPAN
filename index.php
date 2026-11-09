<?php
require_once __DIR__.'/koneksi.php';
$schoolName=site_setting($koneksi,'school_name','SMK TUNAS HARAPAN');
$heroImage=site_setting($koneksi,'hero_image','images/gerbang.jpg');
$tag=site_setting($koneksi,'school_tagline','Membangun Generasi Terampil, Berkarakter, Mandiri, dan Siap Berkarya.');
$heroTitle=site_setting($koneksi,'hero_title',$schoolName);
$heroSubtitle=site_setting($koneksi,'hero_subtitle','Batang Serangan • Langkat');
$heroButton1=site_setting($koneksi,'hero_button1','Jelajahi Sekolah');
$heroButton2=site_setting($koneksi,'hero_button2','Lihat Program Keahlian');
$introTitle=site_setting($koneksi,'intro_title','Belajar dengan arah, berkarya dengan keterampilan.');
$stats=site_stats($koneksi); $features=site_features($koneksi);
$qf=mysqli_query($koneksi,"SELECT * FROM fasilitas WHERE status='Aktif' ORDER BY urutan ASC,id DESC LIMIT 4");$facilities=[];while($qf&&($r=mysqli_fetch_assoc($qf)))$facilities[]=$r;
$qb=mysqli_query($koneksi,"SELECT * FROM berita ORDER BY tanggal DESC,id DESC LIMIT 3");$news=[];while($qb&&($r=mysqli_fetch_assoc($qb)))$news[]=$r;
?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=site_e($schoolName)?></title><link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><link rel="stylesheet" href="assets/css/site.css"></head>
<body class="site-page">
<?php include __DIR__.'/includes/navbar.php'; ?>
<section class="site-hero" style="background-image:url('<?=site_e($heroImage)?>')">
 <div class="site-hero-content">
  <span class="eyebrow">RUANG TUMBUH • RUANG BERKARYA</span>
  <h1><?=site_e($heroTitle)?></h1>
  <p><?=site_e($heroSubtitle)?> — <?=site_e($tag)?></p>
  <div class="site-hero-buttons"><a href="About.php" class="site-btn"><i class="fa-solid fa-arrow-right"></i> <?=site_e($heroButton1)?></a><a href="program_keahlian.php" class="site-btn alt"><i class="fa-solid fa-compass"></i> <?=site_e($heroButton2)?></a></div>
 </div>
</section>
<div class="site-running"><div style="max-width:1160px;margin:auto"><i class="fa-solid fa-bullhorn"></i>&nbsp; <?=site_e(site_setting($koneksi,'running_text','Selamat datang di Sistem Informasi SMK Tunas Harapan'))?></div></div>
<section class="site-section"><div class="site-intro"><span class="site-kicker">TENTANG SEKOLAH</span><h2><?=site_e($introTitle)?></h2><p><?=site_e(site_setting($koneksi,'intro_text','SMK Tunas Harapan mengembangkan kompetensi akademik, keterampilan kejuruan, karakter, kreativitas, dan kesiapan peserta didik untuk melanjutkan pendidikan maupun memasuki dunia kerja.'))?></p></div></section>
<?php if($stats): ?><section class="site-stat-section"><div class="site-stat-grid"><?php foreach($stats as $s): ?><div class="site-stat"><div class="site-stat-icon"><i class="fa-solid <?=site_e($s['icon'])?>"></i></div><strong><?=site_e($s['value'])?></strong><span><?=site_e($s['label'])?></span></div><?php endforeach; ?></div></section><?php endif; ?>
<?php if($features): ?><section class="site-section"><div class="site-section-head"><span class="site-kicker">CARA KAMI BERTUMBUH</span><h2>Nilai yang Dibawa ke Ruang Kelas</h2><p>Prinsip yang menjadi bagian dari pengalaman belajar di SMK Tunas Harapan.</p></div><div class="site-feature-grid"><?php foreach($features as $f): ?><article class="site-feature"><div class="site-feature-icon"><i class="fa-solid <?=site_e($f['icon'])?>"></i></div><h3><?=site_e($f['title'])?></h3><p><?=site_e($f['description'])?></p></article><?php endforeach; ?></div></section><?php endif; ?>
<?php if($facilities): ?><section class="site-section"><div class="site-section-head"><span class="site-kicker">LINGKUNGAN BELAJAR</span><h2>Ruang untuk Praktik dan Berkembang</h2></div><div class="site-card-grid"><?php foreach($facilities as $f): $img=!empty($f['foto'])?'images/'.$f['foto']:'images/gerbang.jpg'; ?><article class="site-card"><img src="<?=site_e($img)?>" alt="<?=site_e($f['nama'])?>"><div class="site-card-body"><h3><?=site_e($f['nama'])?></h3><p><?=site_e(mb_substr(strip_tags($f['deskripsi']??''),0,150))?><?=strlen(strip_tags($f['deskripsi']??''))>150?'...':''?></p></div></article><?php endforeach; ?></div></section><?php endif; ?>
<?php if($news): ?><section class="site-section"><div class="site-section-head"><span class="site-kicker">PAPAN INFORMASI</span><h2>Publikasi Terbaru</h2></div><div class="site-card-grid"><?php foreach($news as $n): $img=!empty($n['foto'])?'images/'.$n['foto']:'images/gerbang.jpg'; ?><article class="site-card"><img src="<?=site_e($img)?>" alt="<?=site_e($n['judul'])?>"><div class="site-card-body"><small style="color:#e66b4e;font-weight:800"><?=site_e(date('d F Y',strtotime($n['tanggal'])))?></small><h3><?=site_e($n['judul'])?></h3><p><?=site_e(mb_substr(strip_tags($n['isi']??''),0,120))?>...</p><a href="detail_berita.php?id=<?=(int)$n['id']?>" style="color:#c94f37;font-weight:800;font-size:11px">Baca publikasi →</a></div></article><?php endforeach; ?></div></section><?php endif; ?>
<section class="site-about-hero"><div class="site-intro"><span class="site-kicker">SMK TUNAS HARAPAN</span><h2>“Belajar, terampil, lalu berani melangkah.”</h2><p><?=site_e(site_setting($koneksi,'school_address','Batang Serangan, Kabupaten Langkat, Sumatera Utara'))?></p></div></section>
<?php include __DIR__.'/includes/footer.php'; ?><script src="bootstrap/js/jquery.min.js"></script><script src="bootstrap/js/bootstrap.min.js"></script></body></html>
