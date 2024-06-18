<?php

require_once 'autoload.php';

if (isset($_POST['kaydol'])) {
  $kullanici = new Kullanici();
  $mesaj = $kullanici->veriEkle($_POST['tc'], $_POST['ad'], $_POST['soyad'], $_POST['telefon'], $_POST['eposta'], $_POST['sifre'], $_POST['adres']);
  echo '<script>alert("'.$mesaj.'");</script>';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Formu</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body class="body-kaydol">
    
<form action="kaydol.php" method="POST">
  <div class="container">

    <hr>
    <label><b>TC Kimlik Numarası</b></label>
    <input type="text" placeholder="11111111111" name="tc" id="tc" required>

    <label><b>Ad</b></label>
    <input type="text" name="ad" id="ad" required>

    <label><b>Soyad</b></label>
    <input type="text" name="soyad" id="soyad" required>

    <label><b>Telefon Numarası</b></label>
    <input type="text" placeholder="5555555555" name="telefon" id="telefon" required>

    <label><b>E-posta</b></label>
    <input type="email" placeholder="xxx@xxx.com" name="eposta" id="eposta" required>
    
    <label><b>Şifre</b></label>
    <input type="password" name="sifre" id="sifre" required>

    <label><b>Adres</b></label>
    <textarea name="adres" id="adres" required></textarea>
    <hr>

  </div> 
  <button type="submit" class="registerbtn" name="kaydol">Kaydol</button>
</form>

</body>
</html>