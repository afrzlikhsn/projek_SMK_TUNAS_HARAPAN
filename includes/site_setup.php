<?php
/**
 * Auto setup untuk CMS konten website SMK Tunas Harapan.
 * Tidak menghapus atau mengubah tabel lama.
 */
if (!function_exists('run_site_cms_setup')) {
    function run_site_cms_setup(mysqli $koneksi): void
    {
        static $done = false;
        if ($done) return;
        $done = true;

        $queries = [
            "CREATE TABLE IF NOT EXISTS site_settings (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                setting_key VARCHAR(100) NOT NULL UNIQUE,
                setting_value LONGTEXT NULL,
                setting_type VARCHAR(20) NOT NULL DEFAULT 'text',
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "CREATE TABLE IF NOT EXISTS site_sections (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                section_key VARCHAR(100) NOT NULL UNIQUE,
                title VARCHAR(255) NOT NULL,
                content LONGTEXT NULL,
                image VARCHAR(255) NULL,
                status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "CREATE TABLE IF NOT EXISTS site_features (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(150) NOT NULL,
                description TEXT NULL,
                icon VARCHAR(80) NOT NULL DEFAULT 'fa-star',
                sort_order INT NOT NULL DEFAULT 0,
                status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "CREATE TABLE IF NOT EXISTS site_stats (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                stat_key VARCHAR(100) NOT NULL UNIQUE,
                label VARCHAR(150) NOT NULL,
                value VARCHAR(50) NOT NULL,
                icon VARCHAR(80) NOT NULL DEFAULT 'fa-chart-column',
                sort_order INT NOT NULL DEFAULT 0,
                status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "CREATE TABLE IF NOT EXISTS site_programs (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(180) NOT NULL,
                deskripsi TEXT NULL,
                kategori VARCHAR(120) NOT NULL DEFAULT 'Kompetensi Keahlian',
                icon VARCHAR(80) NOT NULL DEFAULT 'fa-laptop-code',
                gambar VARCHAR(255) NULL,
                sort_order INT NOT NULL DEFAULT 0,
                status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
            "CREATE TABLE IF NOT EXISTS site_gallery (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(180) NOT NULL,
                description TEXT NULL,
                image VARCHAR(255) NULL,
                category VARCHAR(100) NOT NULL DEFAULT 'Kegiatan',
                event_date DATE NULL,
                status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        ];
        foreach ($queries as $sql) @mysqli_query($koneksi, $sql);

        $defaults = [
            'school_name' => ['SMK TUNAS HARAPAN', 'text'],
            'school_short' => ['Batang Serangan, Langkat', 'text'],
            'school_tagline' => ['Membangun Generasi Terampil, Berkarakter, Mandiri, dan Siap Menghadapi Dunia Kerja.', 'text'],
            'school_address' => ['Batang Serangan, Kabupaten Langkat, Sumatera Utara', 'text'],
            'school_email' => ['info@smktunasharapan.sch.id', 'text'],
            'school_phone' => ['0812-3456-7890', 'text'],
            'school_whatsapp' => ['6281234567890', 'text'],
            'school_maps' => ['https://maps.google.com/', 'url'],
            'school_instagram' => ['https://instagram.com/', 'url'],
            'school_facebook' => ['https://facebook.com/', 'url'],
            'school_tiktok' => ['https://www.tiktok.com/', 'url'],
            'school_youtube' => ['https://youtube.com/', 'url'],
            'school_logo' => ['images/logo-smk-tunas-harapan.svg', 'image'],
            'hero_image' => ['images/gerbang.jpg', 'image'],
            'hero_title' => ['SMK TUNAS HARAPAN', 'text'],
            'hero_subtitle' => ['Batang Serangan • Langkat', 'text'],
            'hero_button1' => ['Jelajahi Sekolah', 'text'],
            'hero_button2' => ['Lihat Program Keahlian', 'text'],
            'running_text' => ['Selamat datang di Sistem Informasi SMK Tunas Harapan Batang Serangan', 'text'],
            'running_text_highlight' => ['INFORMASI & KEGIATAN SEKOLAH', 'text'],
            'intro_title' => ['Sekolah Kejuruan untuk Generasi Siap Berkarya', 'text'],
            'intro_text' => ['SMK Tunas Harapan Batang Serangan mengembangkan kompetensi akademik, keterampilan kejuruan, karakter, dan kesiapan peserta didik memasuki dunia kerja maupun pendidikan lanjutan.', 'textarea'],
            'home_quote' => ['"Jangan pernah berhenti belajar, karena kehidupan tidak pernah berhenti mengajarkan."', 'textarea'],
            'footer_description' => ['Sistem Informasi Sekolah Kejuruan', 'text'],
            'footer_copyright' => ['Semua hak dilindungi.', 'text'],
        ];
        foreach ($defaults as $key => [$value, $type]) {
            $stmt = mysqli_prepare($koneksi, "INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_type) VALUES (?, ?, ?)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sss', $key, $value, $type);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }

        $section_defaults = [
            'profile' => ['Profil Sekolah', 'SMK Tunas Harapan Batang Serangan merupakan satuan pendidikan kejuruan yang berfokus pada pengembangan kompetensi, karakter, kreativitas, dan kesiapan kerja peserta didik.', 'images/gerbang.jpg'],
            'vision' => ['Visi', 'Menjadi sekolah kejuruan yang unggul dalam kompetensi, karakter, inovasi, dan kesiapan menghadapi dunia kerja.', ''],
            'mission' => ['Misi', "Menyelenggarakan pembelajaran berbasis kompetensi.\nMengembangkan keterampilan sesuai kebutuhan dunia kerja.\nMendorong kreativitas, kedisiplinan, dan tanggung jawab.\nMembangun kerja sama dengan dunia usaha dan dunia industri.", ''],
            'about_intro' => ['Tentang SMK Tunas Harapan', 'Mewujudkan lingkungan belajar yang aman, aktif, produktif, dan mendukung pengembangan kompetensi peserta didik.', 'images/gerbang.jpg']
        ];
        foreach ($section_defaults as $key => [$title, $content, $image]) {
            $stmt = mysqli_prepare($koneksi, "INSERT IGNORE INTO site_sections (section_key, title, content, image) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssss', $key, $title, $content, $image);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }

        $feature_defaults = [
            ['Pembelajaran Berbasis Kompetensi', 'Pembelajaran mengutamakan penguasaan pengetahuan, keterampilan, dan sikap sesuai bidang keahlian.', 'fa-screwdriver-wrench', 1],
            ['Karakter & Disiplin', 'Membangun budaya kerja, disiplin, tanggung jawab, dan etika profesional sejak di lingkungan sekolah.', 'fa-user-shield', 2],
            ['Kesiapan Dunia Kerja', 'Membekali siswa dengan keterampilan praktis, kreativitas, dan pengalaman yang relevan dengan kebutuhan industri.', 'fa-briefcase', 3]
        ];
        $check = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM site_features");
        $feature_count = $check ? (int)(mysqli_fetch_assoc($check)['total'] ?? 0) : 0;
        if ($feature_count === 0) {
            foreach ($feature_defaults as $row) {
                $stmt = mysqli_prepare($koneksi, "INSERT INTO site_features (title, description, icon, sort_order) VALUES (?, ?, ?, ?)");
                if ($stmt) { mysqli_stmt_bind_param($stmt, 'sssi', $row[0], $row[1], $row[2], $row[3]); mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt); }
            }
        }

        $stat_defaults = [
            ['students', 'Peserta Didik', '300+', 'fa-graduation-cap', 1],
            ['teachers', 'Tenaga Pendidik', '27+', 'fa-user-tie', 2],
            ['facilities', 'Fasilitas', '10+', 'fa-school', 3],
            ['partnership', 'Mitra & Kegiatan', '10+', 'fa-handshake', 4]
        ];
        foreach ($stat_defaults as $row) {
            $stmt = mysqli_prepare($koneksi, "INSERT IGNORE INTO site_stats (stat_key, label, value, icon, sort_order) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) { mysqli_stmt_bind_param($stmt, 'ssssi', $row[0], $row[1], $row[2], $row[3], $row[4]); mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt); }
        }

        $program_check = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM site_programs");
        $program_count = $program_check ? (int)(mysqli_fetch_assoc($program_check)['total'] ?? 0) : 0;
        if ($program_count === 0) {
            $program_defaults = [
                ['Teknik Komputer dan Jaringan','Mempelajari komputer, jaringan, perangkat keras, sistem operasi, dan layanan jaringan.','Teknologi & Infrastruktur','fa-network-wired',1],
                ['Manajemen Perkantoran dan Layanan Bisnis','Mengembangkan keterampilan administrasi, dokumen, layanan pelanggan, dan komunikasi profesional.','Administrasi & Bisnis','fa-briefcase',2],
                ['Akuntansi dan Keuangan Lembaga','Mengenal pencatatan transaksi, pengelolaan keuangan, dan administrasi akuntansi.','Keuangan & Administrasi','fa-calculator',3],
                ['Teknik Bisnis Sepeda Motor','Mempelajari dasar perawatan, pemeriksaan, servis, dan pekerjaan kendaraan roda dua.','Teknik & Otomotif','fa-motorcycle',4]
            ];
            foreach($program_defaults as $pr){$st=mysqli_prepare($koneksi,"INSERT INTO site_programs(nama,deskripsi,kategori,icon,sort_order,status) VALUES(?,?,?,?,?,'Aktif')");if($st){mysqli_stmt_bind_param($st,'ssssi',$pr[0],$pr[1],$pr[2],$pr[3],$pr[4]);mysqli_stmt_execute($st);mysqli_stmt_close($st);}}
        }

        @mysqli_query($koneksi, "INSERT INTO site_gallery (title, description, image, category, status) SELECT 'Drumband', 'Kegiatan drumband melatih kekompakan dan disiplin siswa.', 'images/gerbang.jpg', 'Ekstrakurikuler', 'Aktif' WHERE NOT EXISTS (SELECT 1 FROM site_gallery)");
    }
}
run_site_cms_setup($koneksi);
// Sinkronisasi nilai lama agar CMS tidak kembali menampilkan label PPDB yang sudah tidak digunakan.
@mysqli_query($koneksi, "UPDATE site_settings SET setting_value='Lihat Program Keahlian' WHERE setting_key='hero_button2' AND setting_value LIKE '%PPDB%'");
@mysqli_query($koneksi, "UPDATE site_settings SET setting_value='INFORMASI & KEGIATAN SEKOLAH' WHERE setting_key='running_text_highlight' AND setting_value LIKE '%PPDB%'");
