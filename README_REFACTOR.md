# Websekolah — Refactor V2

Perubahan utama pada versi ini:

- Navbar publik dipusatkan di `includes/navbar.php`.
- Footer publik dipusatkan di `includes/footer.php`.
- Sidebar admin dipusatkan di `includes/admin_sidebar.php`.
- CSS navbar/footer dipusatkan di `assets/css/site.css`.
- CSS sidebar admin dipusatkan di `assets/css/admin.css`.
- Halaman publik yang memakai navbar sudah diarahkan ke komponen navbar baru.
- Halaman publik dengan footer sudah diarahkan ke footer baru.
- Halaman admin utama sudah diarahkan ke sidebar admin baru.
- Semua file PHP yang dimigrasikan sudah dicek dengan `php -l` dan tidak memiliki error sintaks.

## Cara memasang

1. Backup folder `guruu` lama.
2. Ekstrak isi ZIP ini ke `C:\xampp\htdocs\guruu`.
3. Pastikan database di `koneksi.php` tetap sesuai dengan database yang dipakai.
4. Jalankan Apache dan MySQL dari XAMPP.
5. Buka `http://localhost/guruu/`.

## Catatan

Fungsi PHP dan query database tidak dirombak dalam refactor awal ini. Fokus perubahan adalah merapikan struktur komponen tampilan agar navbar, footer, dan sidebar tidak perlu ditulis berulang-ulang.
