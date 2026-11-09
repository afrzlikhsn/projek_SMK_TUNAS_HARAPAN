<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Siswa - SMK Tunas Harapan</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      .navbar {
        background-color: #221192;
      }

      .navbar a:hover {
        color: #ffd700 !important;
        text-decoration: underline;
      }

      body {
        padding-top: 60px;
      }

      footer {
        margin-top: 40px;
        padding: 20px 0;
        background: #12b52a;
        text-align: center;
      }
    </style>
      <link rel="stylesheet" href="assets/css/site.css">

</head>
  <body>
    <!-- Navbar -->
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <!-- Akhir Navbar -->

    <!-- Form Pendaftaran -->
    <div class="container">
      <div class="panel">
        <div class="panel-body">
          <h2 class="text-center text-primary">Formulir Pendaftaran Siswa</h2>
          <form action="proses_daftar.php" method="post">
            <div class="form-group">
              <label for="nama">Nama Lengkap</label>
              <input
                type="text"
                class="form-control"
                id="nama"
                name="nama"
                placeholder="Masukkan nama lengkap siswa"
                required
              />
            </div>
            <div class="form-group">
              <label for="kelas">Tingkatan Kelas</label>
              <input
                type="text"
                class="form-control"
                id="kelas"
                name="kelas"
                placeholder="Contoh: 1A, 2B, dll"
                required
              />
            </div>
            <div class="form-group">
              <label for="alamat">Alamat Rumah</label>
              <textarea
                class="form-control"
                id="alamat"
                name="alamat"
                rows="3"
                placeholder="Masukkan alamat lengkap siswa"
                required
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nama_ortu">Nama Orang Tua/Wali</label>
              <input
                type="text"
                class="form-control"
                id="nama_ortu"
                name="nama_ortu"
                placeholder="Masukkan nama orang tua atau wali"
                required
              />
            </div>
            <div class="form-group">
              <label for="nohp">No. HP Orang Tua/Wali</label>
              <input
                type="tel"
                class="form-control"
                id="nohp"
                name="nohp"
                placeholder="08xxxxxxxxxx"
                required
              />
            </div>
            <button type="submit" class="btn btn-success">
              Kirim Pendaftaran
            </button>
            <button type="reset" class="btn btn-danger">Reset</button>
          </form>
        </div>
      </div>
    </div>
    <!-- Akhir Form Pendaftaran -->

    <!-- footer -->
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <!-- akhir -->

    <!-- Scripts -->
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
