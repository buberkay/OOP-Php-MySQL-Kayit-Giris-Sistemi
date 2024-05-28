<?php
session_start();
require_once 'autoload.php';

if (!isset($_SESSION['eposta'])) {
    header("Location: profil.php");
    exit();
}

$kullanici = new Kullanici();
$eposta = $_SESSION['eposta'];

$sql = "SELECT * FROM kullanicilar WHERE eposta = '$eposta'";
$result = $kullanici->veriAl()->sorgu($sql);
$userData = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
    
<div class="container">
    <h1>Profil</h1>
    <p><b>TC Kimlik Numarası:</b> <?php echo $userData['tc_no']; ?></p>
    <p><b>Ad:</b> <?php echo $userData['ad']; ?></p>
    <p><b>Soyad:</b> <?php echo $userData['soyad']; ?></p>
    <p><b>Telefon Numarası:</b> <?php echo $userData['tel_no']; ?></p>
    <p><b>E-posta:</b> <?php echo $userData['eposta']; ?></p>
    <p><b>Adres:</b> <?php echo $userData['adres']; ?></p>
</div>

</body>
</html>
