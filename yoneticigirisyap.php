<?php

require_once 'autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['girisyap'])) {
    $yonetici = new Yonetici();
    $mesaj = $yonetici->yoneticiGiris($_POST['eposta'], $_POST['sifre']);

    if ($mesaj == "Giriş başarılı!") {
        session_start();
        $_SESSION['yonetici_eposta'] = $_POST['eposta']; 
        echo '<script>alert("'.$mesaj.'"); window.location.href = "sistem.php";</script>';
        exit();
    } else {
        echo '<script>alert("'.$mesaj.'");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body class="body-girisyap">

<form action="yoneticigirisyap.php" method="POST">
  <div class="container">

  <div class="header">
  <h2>Yönetici Girişi</h2>
  </div>
    <hr>
    <label><b>E-posta</b></label>
    <input type="email" placeholder="xxx@xxx.com" name="eposta" id="eposta" required>
    <label><b>Şifre</b></label>
    <input type="password" name="sifre" id="sifre" required>
    <hr>
  </div> 
  <button type="submit" class="registerbtn" name="girisyap">Giriş Yap</button>
</form>
</body>
</html>
