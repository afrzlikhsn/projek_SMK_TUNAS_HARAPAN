<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
if (!isset($koneksi)) require_once __DIR__ . '/../koneksi.php';
$schoolName=site_setting($koneksi,'school_name','SMK TUNAS HARAPAN');
$short=site_setting($koneksi,'school_short','Batang Serangan');
$address=site_setting($koneksi,'school_address','Batang Serangan, Batang Serangan, Langkat');
$email=site_setting($koneksi,'school_email','');
$phone=site_setting($koneksi,'school_phone','');
$wa=site_setting($koneksi,'school_whatsapp','');
$ig=site_setting($koneksi,'school_instagram','');
$fb=site_setting($koneksi,'school_facebook','');
$tiktok=site_setting($koneksi,'school_tiktok','');
$youtube=site_setting($koneksi,'school_youtube','');
$desc=site_setting($koneksi,'footer_description','Sistem Informasi Sekolah');
$copy=site_setting($koneksi,'footer_copyright','Semua hak dilindungi.');
?><footer class="site-footer"><div class="site-footer-container">
<div class="site-footer-brand"><div class="site-footer-icon"><span class="glyphicon glyphicon-education"></span></div><div><strong><?=site_e($schoolName)?></strong><p><?=site_e($desc)?> • <?=site_e($short)?></p></div></div>
<div class="site-footer-info"><span><i class="glyphicon glyphicon-map-marker"></i><?=site_e($address)?></span><?php if($email): ?><span><i class="glyphicon glyphicon-envelope"></i><a href="mailto:<?=site_e($email)?>"><?=site_e($email)?></a></span><?php endif; ?><?php if($phone): ?><span><i class="glyphicon glyphicon-phone"></i><?=site_e($phone)?></span><?php endif; ?><?php if($wa): ?><span><i class="fa-brands fa-whatsapp"></i><a href="https://wa.me/<?=site_e(preg_replace('/\D+/','',$wa))?>" target="_blank">WhatsApp</a></span><?php endif; ?></div>
<div class="site-footer-bottom"><span>&copy; <?=date('Y')?> <?=site_e($schoolName)?>. <?=site_e($copy)?></span><div class="site-socials"><?php if($ig): ?><a href="<?=site_e($ig)?>" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><?php endif; ?><?php if($fb): ?><a href="<?=site_e($fb)?>" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a><?php endif; ?><?php if($tiktok): ?><a class="social-tiktok" href="<?=site_e($tiktok)?>" target="_blank" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a><?php endif; ?><?php if($youtube): ?><a class="social-youtube" href="<?=site_e($youtube)?>" target="_blank" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a><?php endif; ?></div></div>
</div></footer><button type="button" class="site-scroll-top" id="siteScrollTop" aria-label="Kembali ke atas">↑</button>
<script>(function(){const openBtn=document.getElementById('siteMobileMenu'),sidebar=document.getElementById('siteSidebar'),closeBtn=document.getElementById('siteSidebarClose'),overlay=document.getElementById('siteSidebarOverlay'),scrollButton=document.getElementById('siteScrollTop');function setMenu(open){if(sidebar)sidebar.classList.toggle('is-open',open);if(overlay)overlay.classList.toggle('is-open',open);if(openBtn)openBtn.setAttribute('aria-expanded',open?'true':'false');document.body.classList.toggle('sidebar-open',open)}if(openBtn)openBtn.addEventListener('click',()=>setMenu(true));if(closeBtn)closeBtn.addEventListener('click',()=>setMenu(false));if(overlay)overlay.addEventListener('click',()=>setMenu(false));if(sidebar)sidebar.querySelectorAll('a').forEach(l=>l.addEventListener('click',()=>setMenu(false)));window.addEventListener('resize',()=>{if(window.innerWidth>760)setMenu(false)});if(scrollButton){window.addEventListener('scroll',()=>scrollButton.classList.toggle('show',window.scrollY>350));scrollButton.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}))}})();</script>
