<?php
session_start();

// Veritabanı bağlantısı
include 'db_con.php'; // db_con.php dosyasının yolu doğru olmalı

// Kayıt işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kullanıcıdan gelen verileri al ve güvenli hale getir
    $ad = mysqli_real_escape_string($conn, $_POST['ad']);
    $soyad = mysqli_real_escape_string($conn, $_POST['soyad']);
    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Veritabanına kaydetmek için SQL sorgusu
    $sql = "INSERT INTO musteriler (ad, soyad, telefon, sifre) VALUES ('$ad', '$soyad', '$telefon', '$password')";

    // Sorguyu çalıştır
    if (mysqli_query($conn, $sql)) {
        // Kayıt işlemi başarılı, login sayfasına yönlendir
        header("Location: login.php");
        exit;
    } else {
        echo "Hata oluştu: " . mysqli_error($conn);
    }
}

// Bağlantıyı kapat
if (isset($conn)) {
    mysqli_close($conn); // Bağlantıyı güvenli bir şekilde kapat
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kuaför Randevu Sistemi - Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Kayıt Ol</h2>
        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="ad" class="form-label">Ad</label>
                <input type="text" class="form-control" id="ad" name="ad" required />
            </div>
            <div class="mb-3">
                <label for="soyad" class="form-label">Soyad</label>
                <input type="text" class="form-control" id="soyad" name="soyad" required />
            </div>
            <div class="mb-3">
                <label for="telefon" class="form-label">Telefon Numarası</label>
                <input type="text" class="form-control" id="telefon" name="telefon" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>
        <p class="mt-3">Zaten üyeliğiniz var mı? <a href="login.php">Giriş yapın</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>