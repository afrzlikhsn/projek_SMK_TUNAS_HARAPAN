<?php
require_once __DIR__ . '/koneksi.php';
$schoolName = site_setting($koneksi,'school_name','SMK TUNAS HARAPAN');
$short = site_setting($koneksi,'school_short','Batang Serangan, Langkat');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Program Keahlian | <?= htmlspecialchars($schoolName) ?></title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/site.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.program-hero{background:linear-gradient(135deg,#073b31,#124e8c);color:#fff;padding:95px 20px 70px;text-align:center}
.program-hero h1{font-size:42px;font-weight:900;margin:0 0 12px}.program-hero p{max-width:720px;margin:auto;color:rgba(255,255,255,.85);line-height:1.7}
.program-wrap{max-width:1100px;margin:auto;padding:65px 20px}
.program-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:22px}
.program-card{background:#fff;border:1px solid #e6edf0;border-radius:20px;padding:28px;box-shadow:0 10px 28px rgba(15,23,42,.06);transition:.25s}
.program-card:hover{transform:translateY(-5px);box-shadow:0 18px 36px rgba(11,107,87,.12)}
.program-icon{width:58px;height:58px;border-radius:16px;background:#e5f5f1;color:#0b6b57;display:grid;place-items:center;font-size:24px;margin-bottom:18px}
.program-card h3{font-size:19px;color:#0b6b57;font-weight:800;margin:0 0 10px}.program-card p{font-size:13px;color:#64748b;line-height:1.8;margin:0}
.program-meta{margin-top:16px;display:inline-flex;padding:7px 10px;border-radius:999px;background:#f5f8fa;color:#124e8c;font-size:11px;font-weight:700}
@media(max-width:700px){.program-grid{grid-template-columns:1fr}.program-hero h1{font-size:31px}}
</style>
</head>
<body class="site-page">
<?php include __DIR__ . '/includes/navbar.php'; ?>
<section class="program-hero">
<div class="container">
<span class="site-kicker" style="color:#f4b942">PENDIDIKAN KEJURUAN</span>
<h1>Program Keahlian</h1>
<p>Kenali pilihan kompetensi yang dirancang untuk mengembangkan keterampilan, kreativitas, dan kesiapan peserta didik SMK Tunas Harapan.</p>
</div>
</section>
<main class="program-wrap">
<div class="site-section-head">
<span class="site-kicker">PILIHAN KOMPETENSI</span>
<h2>Belajar Sesuai Minat dan Potensi</h2>
<p>Program keahlian menjadi bagian dari informasi awal bagi calon peserta didik sebelum menentukan jalur belajar yang sesuai.</p>
</div>
<div class="program-grid">
<?php $programs=[];$q=mysqli_query($koneksi,"SELECT * FROM site_programs WHERE status='Aktif' ORDER BY sort_order ASC,id ASC");while($q&&($r=mysqli_fetch_assoc($q)))$programs[]=$r; ?>
<?php foreach($programs as $p): ?>
<article class="program-card"><?php if(!empty($p['gambar'])): ?><img src="<?=htmlspecialchars($p['gambar'])?>" alt="<?=htmlspecialchars($p['nama'])?>" style="width:100%;height:170px;object-fit:cover;border-radius:14px;margin-bottom:18px"><?php endif; ?><div class="program-icon"><i class="fa-solid <?=htmlspecialchars($p['icon'])?>"></i></div><h3><?=htmlspecialchars($p['nama'])?></h3><p><?=htmlspecialchars($p['deskripsi'])?></p><span class="program-meta"><?=htmlspecialchars($p['kategori'])?></span></article>
<?php endforeach; ?>
</div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
