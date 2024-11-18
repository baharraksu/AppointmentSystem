<?php
session_start(); // Oturum başlatma

// Admin giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Admin giriş sayfasına yönlendir
    exit();
}

// Veritabanı bağlantısını dahil et
include('db_con.php');

// Randevuların listelenmesi
$query = "SELECT r.id, r.musteri_id, r.hizmet_id, r.randevu_saati, r.baslangic_zamani, r.bitis_zamani, r.durum, m.ad AS musteri_ad, h.ad AS hizmet_ad
          FROM randevular r
          JOIN musteriler m ON r.musteri_id = m.id
          JOIN hizmetler h ON r.hizmet_id = h.id";
$result = mysqli_query($conn, $query);

// Randevu durumu güncelleme işlemi
if (isset($_POST['update_status'])) {
    $randevu_id = $_POST['randevu_id'];
    $durum = $_POST['durum'];

    // Durumu güncelleme
    $update_query = "UPDATE randevular SET durum = '$durum' WHERE id = $randevu_id";
    if (mysqli_query($conn, $update_query)) {
        $message = "Randevu durumu başarıyla güncellendi.";
    } else {
        $message = "Bir hata oluştu, lütfen tekrar deneyin.";
    }
}

// Randevu silme işlemi
if (isset($_GET['delete_id'])) {
    $randevu_id = $_GET['delete_id'];

    // Randevuyu silme
    $delete_query = "DELETE FROM randevular WHERE id = $randevu_id";
    if (mysqli_query($conn, $delete_query)) {
        $message = "Randevu başarıyla silindi.";
    } else {
        $message = "Bir hata oluştu, lütfen tekrar deneyin.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Randevular</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Paneli - Randevular</h1>

        <!-- Mesajı göster -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Randevuların Listesi -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Müşteri Adı</th>
                    <th>Hizmet Adı</th>
                    <th>Randevu Saati</th>
                    <th>Başlangıç Zamanı</th>
                    <th>Bitiş Zamanı</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['musteri_ad'] ?></td>
                        <td><?= $row['hizmet_ad'] ?></td>
                        <td><?= $row['randevu_saati'] ?></td>
                        <td><?= $row['baslangic_zamani'] ?></td>
                        <td><?= $row['bitis_zamani'] ?></td>
                        <td>
                            <form method="POST" action="admin_panel.php">
                                <input type="hidden" name="randevu_id" value="<?= $row['id'] ?>">
                                <select name="durum" class="form-control">
                                    <option value="Bekliyor" <?= $row['durum'] == 'Bekliyor' ? 'selected' : '' ?>>Bekliyor</option>
                                    <option value="Tamamlandı" <?= $row['durum'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                    <option value="İptal" <?= $row['durum'] == 'İptal' ? 'selected' : '' ?>>İptal</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-primary mt-2">Durumu Güncelle</button>
                            </form>
                        </td>
                        <td>
                            <a href="admin_panel.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Randevuyu silmek istediğinizden emin misiniz?')">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS, Popper.js, jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Veritabanı bağlantısını kapat
mysqli_close($conn);
?>