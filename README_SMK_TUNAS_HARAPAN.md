# Sistem Informasi SMK Tunas Harapan

Versi PKL dari project Sistem Informasi MIS Nurul Huda yang telah diadaptasi dan dibedakan untuk:

- **Nama sekolah:** SMK Tunas Harapan
- **Lokasi:** Batang Serangan, Kabupaten Langkat, Sumatera Utara
- **Database:** `smktunasharapan`
- **Teknologi:** PHP Native, MySQL/MariaDB, Bootstrap, JavaScript

## Perubahan utama

1. Identitas sekolah, alamat, konten, warna, dan logo dibuat khusus untuk SMK Tunas Harapan.
2. Tema visual menggunakan kombinasi hijau-teal, biru tua, dan aksen emas.
3. Menu publik **Data Guru** diganti menjadi **Program Keahlian**.
4. Ditambahkan halaman `program_keahlian.php`.
5. PPDB disesuaikan untuk SMK dengan pilihan kompetensi keahlian:
   - Teknik Komputer dan Jaringan
   - Manajemen Perkantoran dan Layanan Bisnis
   - Akuntansi dan Keuangan Lembaga
   - Teknik Bisnis Sepeda Motor
6. Bagian khusus MI seperti pilihan RA/TK/PAUD, validasi usia MI, dan dokumen PKH/KKS/KIP dihilangkan.
7. Database baru menggunakan nama `smktunasharapan` dengan data awal contoh yang sesuai konteks SMK.
8. Panel admin tetap mempertahankan alur pengelolaan berita, agenda, guru, mata pelajaran, fasilitas, prestasi, kegiatan, PPDB, pesan, dan konten website.

## Instalasi XAMPP

1. Salin folder project ke `htdocs`, misalnya:
   `C:/xampp/htdocs/smktunasharapan`
2. Buat database MySQL/MariaDB bernama:
   `smktunasharapan`
3. Import:
   `database/smktunasharapan.sql`
4. Pastikan `koneksi.php` menggunakan:
   - host: `localhost`
   - user: `root`
   - password: kosong (sesuaikan jika XAMPP memakai password)
   - database: `smktunasharapan`
5. Jalankan:
   `http://localhost/smktunasharapan/`

## Akun Admin Demo

- Username: `admin`
- Password: `admin123`

Untuk penggunaan nyata, ganti password akun demo setelah instalasi.

## Catatan

Data guru, berita, agenda, prestasi, dan PPDB yang ada di SQL adalah **data contoh**, bukan data resmi sekolah. Silakan diganti melalui panel admin.
