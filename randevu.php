<?php
include('db_con.php'); // Veritabanı bağlantısını dahil et

// Hizmetlerin listesini al
$hizmet_query = "SELECT * FROM hizmetler";
$hizmet_result = mysqli_query($conn, $hizmet_query); // Hizmetleri çek

// Randevuların listesini al
$randevu_query = "SELECT r.id, r.baslangic_zamani, r.bitis_zamani, h.ad AS hizmet_ad, m.ad AS musteri_ad, m.soyad AS musteri_soyad 
                  FROM randevular r
                  JOIN hizmetler h ON r.hizmet_id = h.id
                  JOIN musteriler m ON r.musteri_id = m.id";
$randevu_result = mysqli_query($conn, $randevu_query); // Randevuları al

// Eğer form gönderildiyse
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hizmet_ids = $_POST['hizmet_id']; // Seçilen hizmetlerin ID'leri
    $baslangic_zamani = $_POST['baslangic_zamani']; // Başlangıç zamanı
    $musteri_adi = $_POST['musteri_adi']; // Müşteri adı
    $musteri_soyadi = $_POST['musteri_soyadi']; // Müşteri soyadı
    $musteri_telefon = $_POST['musteri_telefon']; // Müşteri telefon

    // Hizmet süresi ve ücretlerini al
    $toplam_ucret = 0;
    $hizmet_sureler = [];
    foreach ($hizmet_ids as $hizmet_id) {
        $hizmet_sure_query = "SELECT sure, ucret FROM hizmetler WHERE id = '$hizmet_id'";
        $hizmet_sure_result = mysqli_query($conn, $hizmet_sure_query);
        $hizmet_sure = mysqli_fetch_assoc($hizmet_sure_result);
        $hizmet_sureler[] = $hizmet_sure['sure'];
        $toplam_ucret += $hizmet_sure['ucret'];
    }

    // Hizmetlerin toplam süresini hesapla
    $toplam_sure = array_sum($hizmet_sureler);

    // Bitiş zamanını hesapla
    $baslangic_tarih = new DateTime($baslangic_zamani);
    $baslangic_tarih->add(new DateInterval('PT' . $toplam_sure . 'M')); // Hizmet süresi kadar dakika ekle
    $bitis_zamani = $baslangic_tarih->format('Y-m-d H:i:s');

    // Aynı tarihe ve saate çakışan randevu var mı kontrol et
    $check_randevu_query = "SELECT * FROM randevular WHERE 
                            (baslangic_zamani BETWEEN '$baslangic_zamani' AND '$bitis_zamani') OR 
                            (bitis_zamani BETWEEN '$baslangic_zamani' AND '$bitis_zamani')";
    $check_randevu_result = mysqli_query($conn, $check_randevu_query);

    if (mysqli_num_rows($check_randevu_result) > 0) {
        echo "Bu saatte zaten bir randevu bulunmaktadır, lütfen başka bir zaman dilimi seçiniz.";
    } else {
        // Müşteri verilerini veritabanına ekle
        $musteri_query = "INSERT INTO musteriler (ad, soyad, telefon) 
                          VALUES ('$musteri_adi', '$musteri_soyadi', '$musteri_telefon')";
        mysqli_query($conn, $musteri_query); // Müşteri kaydını ekle

        // Eklenen müşterinin ID'sini al
        $musteri_id = mysqli_insert_id($conn);

        // Randevu kaydını ekle (musteri_adi, musteri_soyadi yerine musteri_id kullanılacak)
        foreach ($hizmet_ids as $hizmet_id) {
            $randevu_query = "INSERT INTO randevular (hizmet_id, baslangic_zamani, bitis_zamani, musteri_id) 
                              VALUES ('$hizmet_id', '$baslangic_zamani', '$bitis_zamani', '$musteri_id')";
            mysqli_query($conn, $randevu_query);
        }

        echo "Randevunuz başarıyla kaydedildi!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Al</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Randevu Al</h2>
        <form action="randevu.php" method="POST">
            <!-- Hizmet Seçimi -->
            <div class="form-group">
                <label for="hizmet_id">Hizmet Seçin</label>
                <select class="form-control" id="hizmet_id" name="hizmet_id[]" multiple required>
                    <?php while ($hizmet = mysqli_fetch_assoc($hizmet_result)): ?>
                        <option value="<?= $hizmet['id'] ?>"><?= $hizmet['ad'] ?> - <?= $hizmet['ucret'] ?> TL</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Müşteri Adı -->
            <div class="form-group">
                <label for="musteri_adi">Müşteri Adı</label>
                <input type="text" class="form-control" id="musteri_adi" name="musteri_adi" required>
            </div>

            <!-- Müşteri Soyadı -->
            <div class="form-group">
                <label for="musteri_soyadi">Müşteri Soyadı</label>
                <input type="text" class="form-control" id="musteri_soyadi" name="musteri_soyadi" required>
            </div>

            <!-- Müşteri Telefon -->
            <div class="form-group">
                <label for="musteri_telefon">Müşteri Telefon</label>
                <input type="text" class="form-control" id="musteri_telefon" name="musteri_telefon" required>
            </div>

            <!-- Randevu Başlangıç Zamanı -->
            <div class="form-group">
                <label for="baslangic_zamani">Başlangıç Zamanı</label>
                <input type="datetime-local" class="form-control" id="baslangic_zamani" name="baslangic_zamani" required>
            </div>

            <h4>Toplam Ücret: <span id="toplam_ucret">0</span> TL</h4>

            <!-- Onay butonu -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Randevuyu Onayla</button>
            </div>
        </form>

        <h3>Randevular</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Hizmet</th>
                    <th>Başlangıç Zamanı</th>
                    <th>Bitiş Zamanı</th>
                    <th>Müşteri</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($randevu = mysqli_fetch_assoc($randevu_result)): ?>
                    <tr>
                        <td><?= $randevu['hizmet_ad'] ?></td>
                        <td><?= $randevu['baslangic_zamani'] ?></td>
                        <td><?= $randevu['bitis_zamani'] ?></td>
                        <td><?= $randevu['musteri_ad'] ?> <?= $randevu['musteri_soyad'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hizmetlerin ücretlerini al ve toplam ücreti hesapla
        $('select[name="hizmet_id[]"]').on('change', function() {
            var toplamUcret = 0;
            $('select[name="hizmet_id[]"] option:selected').each(function() {
                var ucret = $(this).text().split(' - ')[1].replace(' TL', '');
                toplamUcret += parseFloat(ucret);
            });
            $('#toplam_ucret').text(toplamUcret);
        });
    </script>

</body>

</html>