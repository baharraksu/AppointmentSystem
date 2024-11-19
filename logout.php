<?php
session_start();
session_unset();  // Session verilerini temizle
session_destroy();  // Session'ı yok et
header("Location: login.php");  // Giriş sayfasına yönlendir
exit;
