# SMK Tunas Harapan — Redesign PKL

Versi ini menggunakan alur kerja project sebelumnya sebagai dasar, tetapi tampilan publik dan administrator dibuat ulang dengan identitas visual berbeda.

## Perubahan utama
- Tema baru: Midnight Navy, Terracotta, Sand, dan Gold.
- Navbar publik, hero, kartu, statistik, footer, dan halaman login dibuat ulang.
- Menu publik tidak lagi menampilkan PPDB.
- Menu publik: Beranda, Profil, Program Keahlian, Publikasi, Kalender, Galeri, Capaian, Kontak.
- Menu admin: Ringkasan, Tenaga Pendidik, Kurikulum, Publikasi, Capaian Siswa, Kalender Kegiatan, Sarana Sekolah, Galeri Sekolah, Kotak Pesan, Identitas & Tampilan.
- Alur CRUD tetap dipertahankan agar fitur pengelolaan data tidak berubah secara mendasar.
- File PPDB dan menu PPDB dihapus dari paket aplikasi.
- Database `ppdb_pendaftar` tetap boleh dipertahankan jika database lama sudah terlanjur dibuat; tabel tersebut tidak ditampilkan oleh aplikasi versi ini.
