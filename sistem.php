<?php
session_start();
require_once 'autoload.php';


if (!isset($_SESSION['yonetici_eposta'])) {
    header("Location: yoneticigirisyap.php");
    exit();
}

$vt = new Veritabani(); 
$yonetici = new yonetici();
$kullanici = new Kullanici();

$sql = "SELECT * FROM kullanicilar"; 
$result = $vt->sorgu($sql); 

if (isset($_POST['guncelle'])) {
    $tc = $_POST['tc'];
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];
    $adres = $_POST['adres'];

    $orijinleposta = $_POST['orijinleposta'];
    if ($eposta !== $orijinleposta) {
        echo '<script>alert("E-posta değiştirilemez."); window.location.href = "sistem.php";</script>';
        exit(); 
    }

    $mesaj = $kullanici->veriGuncelle($tc, $ad, $soyad, $telefon, $eposta, $adres);
    
    if ($mesaj) {
        echo '<script>alert("Bilgiler güncellendi."); window.location.href = "sistem.php";</script>';
    } else {
        echo '<script>alert("Hata! Bilgiler güncellenemedi."); window.location.href = "sistem.php";</script>';
    }
}

if (isset($_POST['aktiflik_guncelle'])) {
    $eposta = $_POST['eposta'];
    $aktiflik = isset($_POST['aktiflik']) ? 1 : 0;

    $mesaj = $kullanici->aktiflikGuncelle($eposta, $aktiflik);

    if ($mesaj) {
        echo '<script>alert("Aktiflik durumu güncellendi."); window.location.href = "sistem.php";</script>';
    } else {
        echo '<script>alert("Aktiflik durumu güncellenemedi!"); window.location.href = "sistem.php";</script>';
    }
}

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
            echo "<input type='hidden' name='orijinleposta' value='".$row["eposta"]."'>";
            echo "<input type='email' name='eposta' value='".$row["eposta"]."' readonly>";

            echo "<label><b>Adres</b></label>";
           echo "<textarea name='adres' required>".$row["adres"]."</textarea>";
            
            echo "<button type='submit' name='guncelle' class='updatebtn'>Bilgileri Güncelle</button>";
            echo "</form>";

            echo "<form class='aktiflik-form' action='sistem.php' method='POST'>";
            echo "<input type='hidden' name='eposta' value='".$row["eposta"]."'>";
            echo "<label><b>Aktiflik Durumu</b></label>";
            echo "<input type='checkbox' name='aktiflik' ".($row['aktiflik'] ? 'checked' : '').">";
            echo "<button type='submit' name='aktiflik_guncelle' class='updatebtn'>Aktiflik Durumunu Güncelle</button>";
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
