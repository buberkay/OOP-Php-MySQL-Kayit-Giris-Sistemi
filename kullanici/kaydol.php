<?php

require_once '../autoload.php';

if (isset($_POST['kaydol'])) {
  $kullanici = new Kullanici();
  $sonuc = $kullanici->veriEkle($_POST['tc'], $_POST['ad'], $_POST['soyad'], $_POST['telefon'], $_POST['eposta'], $_POST['sifre'], $_POST['adres']);

  if ($sonuc == 1) {
      echo '<script>alert("Kayıt başarılı!");</script>';
  } else {
      echo '<script>alert("Kayıt başarısız!");</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Formu</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>
<body class="body-kaydol">
    
<form action="kaydol.php" method="POST">
  <div class="container">

    <hr>
    <label><b>TC Kimlik Numarası</b></label>
    <input type="text" placeholder="11111111111" name="tc" id="tc" maxlength="11" required>

    <label><b>Ad</b></label>
    <input type="text" name="ad" id="ad" maxlength="30" required>

    <label><b>Soyad</b></label>
    <input type="text" name="soyad" id="soyad" maxlength="30" required>

    <label><b>Telefon Numarası</b></label>
    <input type="text" placeholder="5555555555" name="telefon" id="telefon" maxlength="11" required>

    <label><b>E-posta</b></label>
    <input type="email" placeholder="xxx@xxx.com" name="eposta" id="eposta" required>
    
    <label><b>Şifre</b></label>
    <input type="password" name="sifre" id="sifre" required>

    <label><b>Adres</b></label>
    <textarea name="adres" id="adres" maxlength="100" ></textarea>
    <hr>

  </div> 
  <button type="submit" class="registerbtn" name="kaydol">Kaydol</button>
</form>

</body>
</html>