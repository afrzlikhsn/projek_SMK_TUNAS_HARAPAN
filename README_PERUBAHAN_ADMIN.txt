PERUBAHAN WEBSITE SMK TUNAS HARAPAN

1. Menu "Admin" di navbar publik dihapus.
2. Link "Panel Administrator" di footer publik dihapus.
3. Menu "Mata Pelajaran" di sidebar administrator dihapus.
4. Bagian "Mata Pelajaran" dari Dashboard Admin dihapus.
5. Halaman datamapel.php tetap ada dan sekarang hanya bisa diakses setelah login admin.
6. Panel admin tetap berada dalam hosting yang sama. Akses admin langsung melalui:
   login_admin.php

Tidak ada data database yang dihapus oleh perubahan ini.


7. KONEKSI DATABASE
   - XAMPP lokal tetap menggunakan localhost, root, tanpa password, database smktunasharapan.
   - Koneksi sekarang dapat memakai DB_HOST, DB_USER, DB_PASS, DB_NAME.
   - Untuk hosting, salin config/database.example.php menjadi config/database.php lalu isi kredensial MySQL hosting.
   - Database SQL tetap harus di-import ke MySQL/MariaDB tujuan.

8. KEAMANAN LOGIN ADMIN
   - Password administrator sekarang menggunakan password_hash/password_verify.
   - Password lama yang masih berupa teks akan otomatis diubah menjadi hash ketika berhasil login.
   - File SQL baru juga sudah memakai password hash.

9. MENU KELOLA ADMINISTRATOR
   - Menu "Kelola Administrator" tersedia setelah login.
   - Admin dapat mengganti username.
   - Admin dapat mengganti password.
   - Admin dapat menambah administrator baru.
   - Admin dapat menghapus administrator lain.
   - Akun yang sedang dipakai tidak dapat menghapus dirinya sendiri.
   - Minimal satu administrator harus tetap ada.

10. AKUN AWAL
   - Username: admin
     Password: admin123
   - Username: operator
     Password: op123456
   Sebaiknya segera ganti password setelah login.
