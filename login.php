<?php
session_start();

// Veritabanı bağlantısı
include 'db_con.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = mysqli_real_escape_string($conn, $_POST['ad']);
    $soyad = mysqli_real_escape_string($conn, $_POST['soyad']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Kullanıcıyı veritabanında arama
    $sql = "SELECT * FROM musteriler WHERE ad = '$ad' AND soyad = '$soyad'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Şifreyi doğrulamak için düz metin karşılaştırma yapıyoruz
        if ($password == $user['sifre']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['ad'] . ' ' . $user['soyad']; // Kullanıcı adını sakla
            header("Location: index.php");
            exit;
        } else {
            echo "Hatalı şifre!";
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }
}

// Bağlantıyı kapat
if (isset($conn)) {
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kuaför Randevu Sistemi - Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Giriş Yap</h2>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="ad" class="form-label">Ad</label>
                <input type="text" class="form-control" id="ad" name="ad" required />
            </div>
            <div class="mb-3">
                <label for="soyad" class="form-label">Soyad</label>
                <input type="text" class="form-control" id="soyad" name="soyad" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required />
            </div>
            <button type="submit" class="btn btn-primary">Giriş Yap</button>
        </form>
        <p class="mt-3">Hesabınız yok mu? <a href="register.php">Kayıt Ol</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>