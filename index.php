<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIMARA - Sistem Informasi Posyandu Remaja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }

    /* Animasi umum */
    .fade-section {
      opacity: 0;
      transform: translateY(40px);
      transition: opacity 1s ease, transform 1s ease;
    }
    .fade-section.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, #0d6efd, #4facfe);
      min-height: 80vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 56px;
    }
    .hero h1, .hero p {
      color: #fff;
    }
    .hero .btn-light {
      color: #0d6efd;
    }

    footer {
      margin-top: 0;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-light shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="#">SIMARA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
          <li class="nav-item"><a class="btn btn-primary ms-3" href="remaja/login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero text-white text-center fade-section">
    <div class="container py-5">
      <h1 class="fw-bold display-5">Selamat Datang di SIMARA</h1>
      <p class="lead mt-3">Sistem Informasi Posyandu Remaja berbasis web untuk memantau kesehatan remaja Indonesia.</p>
      <a href="remaja/register.php" class="btn btn-light btn-lg fw-semibold mt-4">Daftar Sekarang</a>
    </div>
  </section>

  <!-- Tentang -->
  <section id="tentang" class="py-5 text-center fade-section">
    <div class="container">
      <h2 class="fw-bold text-primary mb-3">Tentang SIMARA</h2>
      <p class="text-muted col-lg-8 mx-auto">
        SIMARA adalah sistem digital yang dirancang untuk membantu Posyandu Remaja mencatat, memantau,
        dan menganalisis data kesehatan remaja. Remaja dapat mengisi laporan mandiri, sementara kader
        dan admin puskesmas melakukan pemeriksaan terintegrasi.
      </p>
    </div>
  </section>

  <!-- Fitur -->
  <section id="fitur" class="py-5 bg-light text-center fade-section">
    <div class="container">
      <h2 class="fw-bold text-primary mb-5">Fitur Utama</h2>
      <div class="row g-4">
        <div class="col-md-4"><div class="card p-4 shadow-sm"><h5>Self Report Remaja</h5><p>Input IMT, pola makan, dan aktivitas olahraga.</p></div></div>
        <div class="col-md-4"><div class="card p-4 shadow-sm"><h5>Pemeriksaan Kader</h5><p>Pencatatan hasil pemeriksaan fisik remaja.</p></div></div>
        <div class="col-md-4"><div class="card p-4 shadow-sm"><h5>Dashboard Admin</h5><p>Pemantauan data kader dan laporan kesehatan remaja.</p></div></div>
      </div>
    </div>
  </section>

  <!-- Kontak -->
  <section id="kontak" class="py-5 text-center fade-section">
    <div class="container">
      <h2 class="fw-bold text-primary mb-3">Kontak Kami</h2>
      <p class="text-muted">Email: simara@puskesmas.go.id | Telepon: (021) 123-4567</p>
    </div>
  </section>

  <footer class="text-center bg-dark text-light py-3 fade-section">
    <p>© 2025 SIMARA - Posyandu Remaja Indonesia</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Saat halaman dimuat, animasikan semua fade-section
    window.addEventListener('load', () => {
      document.querySelectorAll('.fade-section').forEach((el, i) => {
        setTimeout(() => el.classList.add('show'), i * 200);
      });
    });
  </script>
</body>
</html>
