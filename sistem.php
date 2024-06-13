<?php
session_start();
require_once 'autoload.php';

if (!isset($_SESSION['yonetici_eposta'])) {
    header("Location: sistem.php");
    exit();
}

$kullanici = new Kullanici();
$vt = new Veritabani(); 

if (isset($_POST['guncelle'])) {
    $tc = $_POST['tc'];
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];
    $adres = $_POST['adres'];

    $mesaj = $kullanici->veriGuncelle($tc, $ad, $soyad, $telefon, $eposta, $adres);
    
    if ($mesaj) {
        echo '<script>alert("Bilgiler güncellendi."); window.location.href = "sistem.php";</script>';
    } else {
        echo '<script>alert("Hata! Bilgiler güncellenemedi."); window.location.href = "sistem.php";</script>';
    }
}

$sql = "SELECT * FROM kullanicilar"; 
$result = $vt->sorgu($sql); 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcıları Güncelle</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body class="body-profil">
<div class="container">
    <h1>Kullanıcıları Güncelle</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<form class='user-form' action='sistem.php' method='POST' onsubmit='return GuncellemeOnay()'>";
            echo "<label><b>TC Kimlik Numarası</b></label>";
            echo "<input type='text' name='tc' value='".$row["tc_no"]."' required>";
            
            echo "<label><b>Ad</b></label>";
            echo "<input type='text' name='ad' value='".$row["ad"]."' required>";
            
            echo "<label><b>Soyad</b></label>";
            echo "<input type='text' name='soyad' value='".$row["soyad"]."' required>";
            
            echo "<label><b>Telefon Numarası</b></label>";
            echo "<input type='text' name='telefon' value='".$row["tel_no"]."' required>";
            
            echo "<label><b>E-posta</b></label>";
            echo "<input type='email' name='eposta' value='".$row["eposta"]."' readonly>";
            
            echo "<label><b>Adres</b></label>";
            echo "<input type='text' name='adres' value='".$row["adres"]."' required>";
            
            echo "<button type='submit' name='guncelle' class='updatebtn'>Bilgileri Güncelle</button>";
            echo "</form>";
            echo "<hr>";
        }
    } else {
        echo "Kullanıcı bulunamadı.";
    }
    ?>
</div>

<script>
function GuncellemeOnay() {
    return confirm("Bilgileri güncellemek istediğinize emin misiniz?");
}
</script>

</body>
</html>
