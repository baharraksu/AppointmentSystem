<?php
// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "1qaz";  // Şifrenizi burada uygun şekilde girin
$dbname = "kuafor_randevu_sistemi";

// Bağlantıyı oluştur
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if (!$conn) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}
