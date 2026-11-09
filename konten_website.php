<?php
session_start();
if (!isset($_SESSION['username'])) { header('Location: login_admin.php'); exit; }
require_once __DIR__ . '/koneksi.php';

$uploadDir = __DIR__ . '/uploads/site/';
if (!is_dir($uploadDir)) @mkdir($uploadDir, 0775, true);
$uploadWeb = 'uploads/site/';
$message=''; $error='';
$activeTab = $_POST['active_tab'] ?? ($_GET['tab'] ?? 'umum');
$allowedTabs = ['umum','profil','fitur','statistik'];
if (!in_array($activeTab, $allowedTabs, true)) $activeTab = 'umum';

function upload_site_image(string $field, string $old=''): string {
    global $uploadDir, $uploadWeb;
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return $old;
    $allowed=['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','webp'=>'image/webp'];
    $ext=strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!isset($allowed[$ext]) || !@getimagesize($_FILES[$field]['tmp_name'])) return $old;
    if ((int)$_FILES[$field]['size'] > 4*1024*1024) return $old;
    $name='site_'.date('YmdHis').'_'.bin2hex(random_bytes(4)).'.'.$ext;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir.$name)) return $uploadWeb.$name;
    return $old;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $action=$_POST['action'] ?? '';
    if ($action==='settings') {
        $keys=['school_name','school_short','school_tagline','school_address','school_email','school_phone','school_whatsapp','school_maps','school_instagram','school_facebook','school_tiktok','school_youtube','hero_title','hero_subtitle','hero_button1','hero_button2','running_text','running_text_highlight','intro_title','intro_text','home_quote','footer_description','footer_copyright'];
        foreach($keys as $key){
            $value=trim($_POST[$key] ?? '');
            $stmt=mysqli_prepare($koneksi,"INSERT INTO site_settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
            if($stmt){mysqli_stmt_bind_param($stmt,'ss',$key,$value);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);}
        }
        $old=site_setting($koneksi,'hero_image','images/gerbang.jpg');
        $hero=upload_site_image('hero_image',$old);
        $stmt=mysqli_prepare($koneksi,"INSERT INTO site_settings(setting_key,setting_value,setting_type) VALUES('hero_image',?,'image') ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
        if($stmt){mysqli_stmt_bind_param($stmt,'s',$hero);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);}
        $logo=upload_site_image('school_logo',site_setting($koneksi,'school_logo',''));
        $stmt=mysqli_prepare($koneksi,"INSERT INTO site_settings(setting_key,setting_value,setting_type) VALUES('school_logo',?,'image') ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
        if($stmt){mysqli_stmt_bind_param($stmt,'s',$logo);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);}
        $message='Pengaturan website berhasil disimpan.';
    } elseif ($action==='section') {
        $key=$_POST['section_key']??''; $title=trim($_POST['title']??''); $content=trim($_POST['content']??''); $old=site_section($koneksi,$key); $image=upload_site_image('section_image',$old['image']??'');
        if($key && $title){$stmt=mysqli_prepare($koneksi,"INSERT INTO site_sections(section_key,title,content,image,status) VALUES(?,?,?,?,?) ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content),image=VALUES(image),status=VALUES(status)");$status=($_POST['status']??'Aktif')==='Aktif'?'Aktif':'Nonaktif';if($stmt){mysqli_stmt_bind_param($stmt,'sssss',$key,$title,$content,$image,$status);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Konten bagian sekolah berhasil disimpan.';}}
    } elseif ($action==='feature_save') {
        $id=(int)($_POST['id']??0);$title=trim($_POST['title']??'');$desc=trim($_POST['description']??'');$icon=trim($_POST['icon']??'fa-star');$sort=(int)($_POST['sort_order']??0);$status=($_POST['status']??'Aktif')==='Aktif'?'Aktif':'Nonaktif';
        if($id){$stmt=mysqli_prepare($koneksi,"UPDATE site_features SET title=?,description=?,icon=?,sort_order=?,status=? WHERE id=?");mysqli_stmt_bind_param($stmt,'sssisi',$title,$desc,$icon,$sort,$status,$id);}else{$stmt=mysqli_prepare($koneksi,"INSERT INTO site_features(title,description,icon,sort_order,status) VALUES(?,?,?,?,?)");mysqli_stmt_bind_param($stmt,'sssis',$title,$desc,$icon,$sort,$status);}if($stmt){mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Keunggulan sekolah berhasil disimpan.';}
    } elseif ($action==='feature_delete') {
        $id=(int)($_POST['id']??0);$stmt=mysqli_prepare($koneksi,"DELETE FROM site_features WHERE id=?");if($stmt){mysqli_stmt_bind_param($stmt,'i',$id);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Keunggulan dihapus.';}
    } elseif ($action==='stat_save') {
        $id=(int)($_POST['id']??0);$key=trim($_POST['stat_key']??'');$label=trim($_POST['label']??'');$value=trim($_POST['value']??'');$icon=trim($_POST['icon']??'fa-chart-column');$sort=(int)($_POST['sort_order']??0);$status=($_POST['status']??'Aktif')==='Aktif'?'Aktif':'Nonaktif';
        if($id){$stmt=mysqli_prepare($koneksi,"UPDATE site_stats SET stat_key=?,label=?,value=?,icon=?,sort_order=?,status=? WHERE id=?");mysqli_stmt_bind_param($stmt,'ssssisi',$key,$label,$value,$icon,$sort,$status,$id);}else{$stmt=mysqli_prepare($koneksi,"INSERT INTO site_stats(stat_key,label,value,icon,sort_order,status) VALUES(?,?,?,?,?,?)");mysqli_stmt_bind_param($stmt,'ssssss',$key,$label,$value,$icon,$sort,$status);}if($stmt){mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Statistik berhasil disimpan.';}
    } elseif ($action==='stat_delete') {
        $id=(int)($_POST['id']??0);$stmt=mysqli_prepare($koneksi,"DELETE FROM site_stats WHERE id=?");if($stmt){mysqli_stmt_bind_param($stmt,'i',$id);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Statistik dihapus.';}
    } elseif ($action==='gallery_save') {
        $id=(int)($_POST['id']??0);$title=trim($_POST['gallery_title']??'');$desc=trim($_POST['gallery_desc']??'');$cat=trim($_POST['category']??'Kegiatan');$date=$_POST['event_date']??null;$status=($_POST['gallery_status']??'Aktif')==='Aktif'?'Aktif':'Nonaktif';
        $old=''; if($id){$r=mysqli_query($koneksi,"SELECT image FROM site_gallery WHERE id=".$id);$old=$r?((mysqli_fetch_assoc($r)['image']??'')):'';}
        $image=upload_site_image('gallery_image',$old);
        if($id){$stmt=mysqli_prepare($koneksi,"UPDATE site_gallery SET title=?,description=?,image=?,category=?,event_date=?,status=? WHERE id=?");mysqli_stmt_bind_param($stmt,'ssssssi',$title,$desc,$image,$cat,$date,$status,$id);}else{$stmt=mysqli_prepare($koneksi,"INSERT INTO site_gallery(title,description,image,category,event_date,status) VALUES(?,?,?,?,?,?)");mysqli_stmt_bind_param($stmt,'ssssss',$title,$desc,$image,$cat,$date,$status);}if($stmt){mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Kegiatan/galeri berhasil disimpan.';}
    } elseif ($action==='gallery_delete') {
        $id=(int)($_POST['id']??0);$stmt=mysqli_prepare($koneksi,"DELETE FROM site_gallery WHERE id=?");if($stmt){mysqli_stmt_bind_param($stmt,'i',$id);mysqli_stmt_execute($stmt);mysqli_stmt_close($stmt);$message='Kegiatan/galeri dihapus.';}
    }
}

$sections=[]; foreach(['profile','vision','mission','about_intro'] as $k){$sections[$k]=site_section($koneksi,$k);}
$features=[];$q=mysqli_query($koneksi,"SELECT * FROM site_features ORDER BY sort_order,id");while($q&&($r=mysqli_fetch_assoc($q)))$features[]=$r;
$stats=[];$q=mysqli_query($koneksi,"SELECT * FROM site_stats ORDER BY sort_order,id");while($q&&($r=mysqli_fetch_assoc($q)))$stats[]=$r;
$gallery=[];$q=mysqli_query($koneksi,"SELECT * FROM site_gallery ORDER BY id DESC");while($q&&($r=mysqli_fetch_assoc($q)))$gallery[]=$r;
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Identitas & Tampilan | Admin</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><link rel="stylesheet" href="assets/css/admin.css"></head>
<body class="admin-page">
<?php include __DIR__.'/includes/admin_sidebar.php'; ?><div class="admin-overlay" id="adminOverlay"></div>
<main class="admin-main"><header class="admin-topbar"><div class="admin-topbar-left"><button class="admin-menu-toggle" id="adminMenuToggle"><i class="fa-solid fa-bars"></i></button><div><span class="admin-eyebrow">PENGELOLAAN WEBSITE</span><h1>Identitas & Tampilan</h1></div></div><div class="admin-topbar-user"><div class="admin-topbar-avatar"><i class="fa-solid fa-user"></i></div><div><strong><?=site_e($_SESSION['username'])?></strong><small>Administrator</small></div></div></header>
<section class="admin-content">
<?php if($message): ?><div class="cms-alert success"><i class="fa-solid fa-circle-check"></i><?=site_e($message)?></div><?php endif; ?>
<div class="cms-intro"><div><span>CMS SEKOLAH</span><h2>Kelola seluruh isi website</h2><p>Ubah teks, foto, statistik, visi-misi, keunggulan, kontak, dan kegiatan dari satu halaman tanpa mengedit kode PHP.</p></div><a class="cms-preview" href="index.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Website</a></div>

<div class="cms-tabs" role="tablist"><button type="button" class="<?= $activeTab==='umum' ? 'active' : '' ?>" data-tab="umum" role="tab" aria-selected="<?= $activeTab==='umum' ? 'true' : 'false' ?>">Identitas & Beranda</button><button type="button" class="<?= $activeTab==='profil' ? 'active' : '' ?>" data-tab="profil" role="tab" aria-selected="<?= $activeTab==='profil' ? 'true' : 'false' ?>">Profil, Visi & Misi</button><button type="button" class="<?= $activeTab==='fitur' ? 'active' : '' ?>" data-tab="fitur" role="tab" aria-selected="<?= $activeTab==='fitur' ? 'true' : 'false' ?>">Keunggulan</button><button type="button" class="<?= $activeTab==='statistik' ? 'active' : '' ?>" data-tab="statistik" role="tab" aria-selected="<?= $activeTab==='statistik' ? 'true' : 'false' ?>">Statistik</button></div>

<div class="cms-tab <?= $activeTab==='umum' ? 'active' : '' ?>" id="tab-umum" role="tabpanel"><form method="post" enctype="multipart/form-data"><input type="hidden" name="active_tab" value="umum"><input type="hidden" name="action" value="settings"><div class="cms-grid">
<div class="cms-card"><div class="cms-card-head"><div><span>IDENTITAS</span><h3>Informasi Sekolah</h3></div><i class="fa-solid fa-school"></i></div><div class="cms-form-grid"><label>Nama Sekolah<input name="school_name" value="<?=site_e(site_setting($koneksi,'school_name'))?>"></label><label>Nama Singkat<input name="school_short" value="<?=site_e(site_setting($koneksi,'school_short'))?>"></label><label class="full">Slogan / Tagline<input name="school_tagline" value="<?=site_e(site_setting($koneksi,'school_tagline'))?>"></label><label class="full">Alamat<textarea name="school_address"><?=site_e(site_setting($koneksi,'school_address'))?></textarea></label><label>Email<input name="school_email" value="<?=site_e(site_setting($koneksi,'school_email'))?>"></label><label>Telepon<input name="school_phone" value="<?=site_e(site_setting($koneksi,'school_phone'))?>"></label><label>WhatsApp (format 628...)<input name="school_whatsapp" value="<?=site_e(site_setting($koneksi,'school_whatsapp'))?>"></label><label>Google Maps<input name="school_maps" value="<?=site_e(site_setting($koneksi,'school_maps'))?>"></label></div></div>
<div class="cms-card"><div class="cms-card-head"><div><span>MEDIA</span><h3>Logo & Hero</h3></div><i class="fa-solid fa-image"></i></div><div class="cms-form-grid"><label>Logo Sekolah<input type="file" name="school_logo" accept="image/*"><small>JPG, PNG, WEBP maksimal 4 MB.</small></label><label>Foto Hero<input type="file" name="hero_image" accept="image/*"><small>Gunakan foto gerbang/kegiatan terbaik.</small></label><label>Judul Hero<input name="hero_title" value="<?=site_e(site_setting($koneksi,'hero_title'))?>"></label><label>Subjudul Hero<input name="hero_subtitle" value="<?=site_e(site_setting($koneksi,'hero_subtitle'))?>"></label><label>Tombol 1<input name="hero_button1" value="<?=site_e(site_setting($koneksi,'hero_button1'))?>"></label><label>Tombol 2<input name="hero_button2" value="<?=site_e(site_setting($koneksi,'hero_button2'))?>"></label></div></div>
<div class="cms-card full-card"><div class="cms-card-head"><div><span>BERANDA</span><h3>Teks yang tampil di halaman utama</h3></div><i class="fa-solid fa-house"></i></div><div class="cms-form-grid"><label class="full">Running Text<input name="running_text" value="<?=site_e(site_setting($koneksi,'running_text'))?>"></label><label class="full">Running Text Highlight<input name="running_text_highlight" value="<?=site_e(site_setting($koneksi,'running_text_highlight'))?>"></label><label>Judul Intro<input name="intro_title" value="<?=site_e(site_setting($koneksi,'intro_title'))?>"></label><label class="full">Deskripsi Intro<textarea name="intro_text"><?=site_e(site_setting($koneksi,'intro_text'))?></textarea></label><label class="full">Quote Sekolah<textarea name="home_quote"><?=site_e(site_setting($koneksi,'home_quote'))?></textarea></label></div></div>
<div class="cms-card full-card"><div class="cms-card-head"><div><span>FOOTER & SOSIAL</span><h3>Kontak dan media sosial</h3></div><i class="fa-solid fa-share-nodes"></i></div><div class="cms-form-grid"><label class="cms-social-field cms-social-instagram">Instagram<input name="school_instagram" value="<?=site_e(site_setting($koneksi,'school_instagram'))?>"></label><label class="cms-social-field cms-social-facebook">Facebook<input name="school_facebook" value="<?=site_e(site_setting($koneksi,'school_facebook'))?>"></label><label class="cms-social-field cms-social-tiktok">TikTok<input name="school_tiktok" value="<?=site_e(site_setting($koneksi,'school_tiktok'))?>" placeholder="https://www.tiktok.com/@... "></label><label class="cms-social-field cms-social-youtube">YouTube<input name="school_youtube" value="<?=site_e(site_setting($koneksi,'school_youtube'))?>" placeholder="https://youtube.com/@... "></label><label>Deskripsi Footer<input name="footer_description" value="<?=site_e(site_setting($koneksi,'footer_description'))?>"></label><label class="full">Teks Copyright<input name="footer_copyright" value="<?=site_e(site_setting($koneksi,'footer_copyright'))?>"></label></div></div>
</div><div class="cms-savebar"><button class="cms-save" type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Semua Pengaturan</button></div></form></div>

<div class="cms-tab <?= $activeTab==='profil' ? 'active' : '' ?>" id="tab-profil" role="tabpanel"><div class="cms-section-list">
<?php foreach($sections as $key=>$s): ?><form class="cms-card" method="post" enctype="multipart/form-data"><input type="hidden" name="active_tab" value="profil"><input type="hidden" name="action" value="section"><input type="hidden" name="section_key" value="<?=site_e($key)?>"><div class="cms-card-head"><div><span><?=site_e(strtoupper($key))?></span><h3><?=site_e($s['title']??$key)?></h3></div><i class="fa-solid fa-pen-to-square"></i></div><div class="cms-form-grid"><label>Judul<input name="title" value="<?=site_e($s['title']??'')?>"></label><label>Status<select name="status"><option <?=($s['status']??'Aktif')==='Aktif'?'selected':''?>>Aktif</option><option <?=($s['status']??'Aktif')==='Nonaktif'?'selected':''?>>Nonaktif</option></select></label><label class="full">Isi<textarea name="content" rows="7"><?=site_e($s['content']??'')?></textarea><small>Untuk Visi/Misi, gunakan satu poin per baris.</small></label><label>Ganti Foto<input type="file" name="section_image" accept="image/*"></label></div><button class="cms-save small" type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan</button></form><?php endforeach; ?></div></div>

<div class="cms-tab <?= $activeTab==='fitur' ? 'active' : '' ?>" id="tab-fitur" role="tabpanel"><div class="cms-card"><div class="cms-card-head"><div><span>DINAMIS</span><h3>Keunggulan Sekolah</h3></div></div><p class="cms-note">Bagian “Pendidikan Berkualitas”, “Berbasis Akhlak”, dan “Pengembangan Capaian Siswa” di halaman Tentang dapat ditambah, diubah, diurutkan, atau dinonaktifkan.</p><?php foreach($features as $f): ?><form class="cms-inline-row" method="post"><input type="hidden" name="active_tab" value="fitur"><input type="hidden" name="action" value="feature_save"><input type="hidden" name="id" value="<?=$f['id']?>"><input name="title" value="<?=site_e($f['title'])?>" placeholder="Judul"><input name="description" value="<?=site_e($f['description'])?>" placeholder="Deskripsi"><input name="icon" value="<?=site_e($f['icon'])?>" placeholder="fa-star"><input type="number" name="sort_order" value="<?=$f['sort_order']?>" title="Urutan"><select name="status"><option <?= $f['status']==='Aktif'?'selected':''?>>Aktif</option><option <?= $f['status']==='Nonaktif'?'selected':''?>>Nonaktif</option></select><button class="icon-save" title="Simpan"><i class="fa-solid fa-floppy-disk"></i></button></form><form method="post" class="delete-inline" onsubmit="return confirm('Hapus keunggulan ini?')"><input type="hidden" name="active_tab" value="fitur"><input type="hidden" name="action" value="feature_delete"><input type="hidden" name="id" value="<?=$f['id']?>"><button><i class="fa-solid fa-trash"></i> Hapus</button></form><?php endforeach; ?><form class="cms-add-box" method="post"><input type="hidden" name="active_tab" value="fitur"><input type="hidden" name="action" value="feature_save"><strong>Tambah Keunggulan Baru</strong><div class="cms-inline-row"><input name="title" placeholder="Judul" required><input name="description" placeholder="Deskripsi" required><input name="icon" value="fa-star" placeholder="fa-star"><input type="number" name="sort_order" value="4"><select name="status"><option>Aktif</option><option>Nonaktif</option></select><button class="icon-save"><i class="fa-solid fa-plus"></i></button></div></form></div></div>

<div class="cms-tab <?= $activeTab==='statistik' ? 'active' : '' ?>" id="tab-statistik" role="tabpanel"><div class="cms-card"><div class="cms-card-head"><div><span>STATISTIK BERANDA</span><h3>Angka Informasi Sekolah</h3></div><i class="fa-solid fa-chart-column"></i></div><p class="cms-note">Angka pada kartu biru di Beranda dapat diubah di sini. Jika nanti database siswa sudah tersedia, angka tertentu dapat dibuat otomatis.</p><?php foreach($stats as $s): ?><form class="cms-inline-row" method="post"><input type="hidden" name="active_tab" value="statistik"><input type="hidden" name="action" value="stat_save"><input type="hidden" name="id" value="<?=$s['id']?>"><input name="stat_key" value="<?=site_e($s['stat_key'])?>" placeholder="Key"><input name="label" value="<?=site_e($s['label'])?>" placeholder="Label"><input name="value" value="<?=site_e($s['value'])?>" placeholder="300+"><input name="icon" value="<?=site_e($s['icon'])?>" placeholder="fa-school"><input type="number" name="sort_order" value="<?=$s['sort_order']?>"><select name="status"><option <?= $s['status']==='Aktif'?'selected':''?>>Aktif</option><option <?= $s['status']==='Nonaktif'?'selected':''?>>Nonaktif</option></select><button class="icon-save"><i class="fa-solid fa-floppy-disk"></i></button></form><form method="post" class="delete-inline" onsubmit="return confirm('Hapus statistik ini?')"><input type="hidden" name="active_tab" value="statistik"><input type="hidden" name="action" value="stat_delete"><input type="hidden" name="id" value="<?=$s['id']?>"><button><i class="fa-solid fa-trash"></i> Hapus</button></form><?php endforeach; ?><form class="cms-add-box" method="post"><input type="hidden" name="active_tab" value="statistik"><input type="hidden" name="action" value="stat_save"><strong>Tambah Statistik</strong><div class="cms-inline-row"><input name="stat_key" placeholder="unique-key" required><input name="label" placeholder="Label" required><input name="value" placeholder="50+" required><input name="icon" value="fa-star"><input type="number" name="sort_order" value="5"><select name="status"><option>Aktif</option><option>Nonaktif</option></select><button class="icon-save"><i class="fa-solid fa-plus"></i></button></div></form></div></div>


<?php include __DIR__.'/includes/admin_footer.php'; ?></section></main>
<script>(function(){
const tabs=[...document.querySelectorAll('.cms-tabs button[data-tab]')], panels=[...document.querySelectorAll('.cms-tab')];
function activateTab(name,updateHash=true){
  const valid=tabs.some(b=>b.dataset.tab===name)?name:'umum';
  tabs.forEach(b=>{const on=b.dataset.tab===valid;b.classList.toggle('active',on);b.setAttribute('aria-selected',on?'true':'false');});
  panels.forEach(p=>p.classList.toggle('active',p.id==='tab-'+valid));
  document.querySelectorAll('form input[name="active_tab"]').forEach(i=>i.value=valid);
  if(updateHash) history.replaceState(null,'','#'+valid);
}
tabs.forEach(b=>b.addEventListener('click',()=>activateTab(b.dataset.tab,true)));
const h=location.hash.replace('#','').trim();
activateTab(h||<?=json_encode($activeTab)?>,false);
const t=document.getElementById('adminMenuToggle'),s=document.getElementById('adminSidebar'),o=document.getElementById('adminOverlay');
if(t)t.onclick=()=>{s.classList.toggle('mobile-open');o.classList.toggle('show')};
if(o)o.onclick=()=>{s.classList.remove('mobile-open');o.classList.remove('show')};
})();</script></body></html>
