<?php
session_start(); // Oturum başlatma

// Admin bilgileri
$admin_username = "bahar";
$admin_password = "1234";

// Giriş işlemi
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Admin kontrolü
    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['admin_logged_in'] = true; // Admin girişi başarılı
        header("Location: admin_panel.php"); // Admin paneline yönlendir
        exit();
    } else {
        $error_message = "Admin adı veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Admin Girişi</h2>

        <!-- Hata mesajını göster -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

        <!-- Giriş Formu -->
        <form method="POST">
            <div class="form-group">
                <label for="username">Admin Adı</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Giriş Yap</button>
        </form>
    </div>
</body>

</html>