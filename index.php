<?php session_start(); ?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kuaför Randevu Sistemi - Ana Sayfa</title>
  <!-- Bootstrap 5 CDN -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Özel Stil -->
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Navigasyon Menüsü">
    <a class="navbar-brand" href="#">Kuaför Randevu</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Ana Sayfa</a>
        </li>

        <!-- Eğer kullanıcı giriş yapmışsa, hoş geldiniz mesajı ve çıkış linki gösterilecek -->
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <span class="nav-link">Hoşgeldiniz, <?php echo $_SESSION['user_name']; ?>!</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_panel.php">Admin Paneli</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Çıkış Yap</a>
          </li>
        <?php else: ?>
          <!-- Eğer kullanıcı giriş yapmamışsa, giriş ve kayıt linkleri gösterilecek -->
          <li class="nav-item">
            <a class="nav-link" href="register.php">Kayıt Ol</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Giriş Yap</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- Hizmetler Bölümü -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">Kuaför Hizmetleri</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <!-- Hizmet Kartları -->
      <div class="col">
        <div class="card">
          <img
            src="image/sac-yikama.jpg"
            class="card-img-top"
            alt="Saç Yıkama" />
          <div class="card-body">
            <h5 class="card-title">Saç Yıkama</h5>
            <p class="card-text">Fiyat: 50 TL, Süre: 30 dakika</p>
            <a href="randevu.php?hizmet_id=1" class="btn btn-primary">Randevu Al</a>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <img src="image/kesim.jpg" class="card-img-top" alt="Saç Kesimi" />
          <div class="card-body">
            <h5 class="card-title">Saç Kesimi</h5>
            <p class="card-text">Fiyat: 100 TL, Süre: 60 dakika</p>
            <a href="randevu.php?hizmet_id=2" class="btn btn-primary">Randevu Al</a>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <img
            src="image/sac-boyama.jpg"
            class="card-img-top"
            alt="Saç Boyama" />
          <div class="card-body">
            <h5 class="card-title">Saç Boyama</h5>
            <p class="card-text">Fiyat: 90 TL, Süre: 90 dakika</p>
            <a href="randevu.php?hizmet_id=3" class="btn btn-primary">Randevu Al</a>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <img src="image/manikur.webp" class="card-img-top" alt="Manikür" />
          <div class="card-body">
            <h5 class="card-title">Manikür</h5>
            <p class="card-text">Fiyat: 40 TL, Süre: 30 dakika</p>
            <a href="randevu.php?hizmet_id=4" class="btn btn-primary">Randevu Al</a>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <img src="image/bakım.jpg" class="card-img-top" alt="Cilt Bakımı" />
          <div class="card-body">
            <h5 class="card-title">Cilt Bakımı</h5>
            <p class="card-text">Fiyat: 120 TL, Süre: 75 dakika</p>
            <a href="randevu.php?hizmet_id=5" class="btn btn-primary">Randevu Al</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer text-center">
    <p>&copy; 2024 Kuaför Randevu Sistemi | Tüm Hakları Saklıdır</p>
  </footer>

  <!-- Bootstrap 5 ve jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>