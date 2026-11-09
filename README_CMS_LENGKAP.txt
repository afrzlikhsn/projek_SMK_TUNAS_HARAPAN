PEMBARUAN WEBSITE SMK TUNAS HARAPAN - CMS LENGKAP
================================================

Versi ini mempertahankan fitur lama (guru, berita, prestasi, agenda, fasilitas, PPDB, pesan, absensi) dan menambahkan CMS untuk mengelola konten website.

FITUR BARU
----------
1. Menu Admin > Konten Website
   - Identitas sekolah
   - Logo sekolah
   - Foto hero
   - Judul/subjudul hero
   - Tombol hero
   - Running text
   - Intro Beranda
   - Status PPDB
   - Kontak, WhatsApp, Google Maps
   - Instagram, Facebook, YouTube
   - Footer
2. Profil, Visi & Misi dapat diedit dari Admin.
3. Keunggulan sekolah dapat tambah/edit/hapus/aktif-nonaktif/atur urutan.
4. Statistik Beranda dapat tambah/edit/hapus/aktif-nonaktif/atur urutan.
5. Kegiatan & Galeri dapat tambah/edit/hapus, upload foto, kategori, tanggal dan status.
6. Beranda dibuat dinamis mengikuti data CMS.
7. Halaman Tentang dibuat dinamis mengikuti data CMS.
8. Kontak dan footer mengambil data dari CMS.
9. Dashboard Admin ditambah akses cepat Konten Website dan Galeri.
10. Data publik guru tidak lagi menampilkan NIP/NIK, alamat dan tanggal lahir.

CARA INSTALL
------------
1. Backup folder website lama terlebih dahulu.
2. Extract ZIP ini ke folder htdocs.
   Contoh: C:\xampp\htdocs\guru\
3. Pastikan nama folder sama dengan folder project lama jika ingin URL lama tetap digunakan.
4. Pastikan database bernama: smktunasharapan
5. Jalankan Apache dan MySQL dari XAMPP.
6. Buka website:
   http://localhost/guru/
7. Login Admin menggunakan akun admin lama.
8. Masuk ke:
   Konten Website
9. Sistem akan membuat tabel CMS baru secara otomatis saat koneksi database pertama kali dijalankan.

TABEL BARU YANG DIBUAT OTOMATIS
-------------------------------
- site_settings
- site_sections
- site_features
- site_stats
- site_gallery

Tabel lama tidak dihapus.

UPLOAD FOTO
-----------
Foto CMS disimpan di:
uploads/site/

Format: JPG, JPEG, PNG, WEBP
Ukuran maksimum: 4 MB per file.

JIKA ERROR
----------
- Pastikan MySQL aktif.
- Pastikan database smktunasharapan tersedia.
- Pastikan folder project dapat ditulis PHP agar upload foto berhasil.
- Jika project berada di subfolder berbeda, gunakan URL sesuai nama folder tersebut.

CATATAN
-------
Versi ini tidak memerlukan import SQL tambahan untuk tabel CMS karena migrasi dibuat otomatis melalui koneksi.php.
