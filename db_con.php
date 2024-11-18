<?php
// db_con.php

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "1qaz";
$dbname = "kuafor_randevu_sistemi";

// Bağlantı kurma
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if (!$conn) {
    die("Bağlantı başarısız: " . mysqli_connect_error());
}
