<?php
session_start();
require_once 'autoload.php';

if (!isset($_SESSION['eposta'])) {
    header("Location: girisyap.php");
    exit();
}

$kullanici = new Kullanici();
$eposta = $_SESSION['eposta'];

$sql = "SELECT * FROM kullanicilar WHERE eposta = '$eposta'";
$result = $kullanici->veriAl()->sorgu($sql);
$userData = $result->fetch_assoc();

if (isset($_POST['guncelle'])) {
    $tc = $_POST['tc'];
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $adres = $_POST['adres'];

    $mesaj = $kullanici->veriGuncelle($tc, $ad, $soyad, $telefon, $eposta, $adres);
    
    if ($mesaj) {
        echo '<script>alert("Bilgiler güncellendi."); window.location.href = "profil.php";</script>';
    } else {
        echo '<script>alert("Hata! Bilgiler güncellenemedi."); window.location.href = "profil.php";</script>';
    }
}

if (isset($_POST['cikisyap'])) {
    $kullanici->kullanicicikis();
    echo '<script>alert("Çıkış başarılı."); window.location.href = "girisyap.php";</script>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body class="body-profil">
    
<div class="container">
    <h1>Profil</h1>
    <form action="profil.php" method="POST" onsubmit="return GuncellemeOnay()">
        <label><b>TC Kimlik Numarası</b></label>
        <input type="text" name="tc" value="<?php echo $userData['tc_no']; ?>" required>
        
        <label><b>Ad</b></label>
        <input type="text" name="ad" value="<?php echo $userData['ad']; ?>" required>
        
        <label><b>Soyad</b></label>
        <input type="text" name="soyad" value="<?php echo $userData['soyad']; ?>" required>
        
        <label><b>Telefon Numarası</b></label>
        <input type="text" name="telefon" value="<?php echo $userData['tel_no']; ?>" required>
        
        <label><b>Adres</b></label>
        <input type="text" name="adres" value="<?php echo $userData['adres']; ?>" required>
        
        <button type="submit" name="guncelle" class="updatebtn">Bilgileri Güncelle</button>
    </form>

    <form action="" method="POST">
    <button type="submit" class="cikisbtn" name="cikisyap">Çıkış Yap</button>

    </form>
</form>
</div>

<script>
function GuncellemeOnay() {
    return confirm("Bilgilerinizi güncellemek istediğinize emin misiniz?");
}
</script>

</body>
</html>
