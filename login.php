<?php
session_start();
include('db_con.php'); // Veritabanı bağlantısını dahil ediyoruz

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kullanıcıdan gelen verileri alıyoruz
    $kullanici_ad = $_POST['kullanici_ad'];
    $sifre = $_POST['sifre'];

    // Veritabanı sorgusunu PDO ile hazırlıyoruz
    $stmt = $pdo->prepare("SELECT * FROM giris WHERE kullanici_ad = :kullanici_ad AND sifre = :sifre");
    $stmt->bindParam(':kullanici_ad', $kullanici_ad);
    $stmt->bindParam(':sifre', $sifre);
    $stmt->execute();

    // Kullanıcı varsa
    if ($stmt->rowCount() > 0) {
        // Kullanıcıyı oturumda saklıyoruz
        $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['kullanici_id'] = $kullanici['id']; // Kullanıcı id'si oturuma ekleniyor
        $_SESSION['kullanici_ad'] = $kullanici['kullanici_ad']; // Kullanıcı adını saklıyoruz
        header('Location: index.html'); // Ana sayfaya yönlendiriyoruz
        exit;
    } else {
        // Hata mesajı
        $error_message = "Geçersiz kullanıcı adı veya şifre.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Giriş Yap</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="kullanici_ad">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="kullanici_ad" name="kullanici_ad" required>
            </div>
            <div class="form-group">
                <label for="sifre">Şifre</label>
                <input type="password" class="form-control" id="sifre" name="sifre" required>
            </div>
            <button type="submit" class="btn btn-primary">Giriş Yap</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>