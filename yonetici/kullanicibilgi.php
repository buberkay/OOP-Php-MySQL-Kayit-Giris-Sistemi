<?php
session_start();
require_once '../autoload.php';

if (!isset($_SESSION['yonetici_eposta'])) {
    header("Location: yoneticigirisyap.php");
    exit();
}

$vt = new Veritabani(); 
$kullanici = new Kullanici();

if (isset($_GET['eposta'])) {
    $eposta = $_GET['eposta'];
    $sql = "SELECT * FROM kullanicilar WHERE eposta = '$eposta'";
    $result = $vt->sorgu($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo '<script>alert("Kullanıcı bulunamadı."); window.location.href = "kontrolpaneli.php";</script>';
        exit();
    }
}

if (isset($_POST['guncelle'])) {
    $tc = $_POST['tc'];
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $eposta = $_POST['eposta'];
    $adres = $_POST['adres'];
    $aktiflik = $_POST['aktiflik'];

    $kontrolSql = "SELECT * FROM kullanicilar WHERE tc_no = '$tc'";
    $kontrolResult = $vt->sorgu($kontrolSql);
    if ($kontrolResult->num_rows == 1) {
        $kontrolRow = $kontrolResult->fetch_assoc();
        if ($kontrolRow['eposta'] !== $eposta) {
            echo '<script>alert("Hata! E-posta değiştirilemez."); window.location.href = "kontrolpaneli.php";</script>';
            exit();
        }
    } else {
        echo '<script>alert("Hata! Kullanıcı bulunamadı."); window.location.href = "kontrolpaneli.php";</script>';
        exit();
    }

    $mesaj = $kullanici->veriGuncelle($tc, $ad, $soyad, $telefon, $eposta, $adres, $aktiflik);

    if ($mesaj == 1) {
        echo '<script>alert("Bilgiler ve aktiflik durumu güncellendi."); window.location.href = "kontrolpaneli.php";</script>';
    } elseif ($mesaj == 0) {
        echo '<script>alert("Hata! Bilgiler güncellenemedi."); window.location.href = "kontrolpaneli.php";</script>';
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
    <title>Kullanıcı Bilgilerini Güncelle</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>
<body class="body-profil">
<div class="container">
    <h1>Kullanıcı Bilgilerini Güncelle</h1>
    <form class='user-form' action='kullanicibilgi.php' method='POST' onsubmit='return GuncellemeOnay()'>
        <label><b>TC Kimlik Numarası</b></label>
        <input type='text' name='tc' value='<?php echo $row["tc_no"]; ?>' maxlength="11" required>
        
        <label><b>Ad</b></label>
        <input type='text' name='ad' value='<?php echo $row["ad"]; ?>' maxlength="30" required>
        
        <label><b>Soyad</b></label>
        <input type='text' name='soyad' value='<?php echo $row["soyad"]; ?>' maxlength="30" required>
        
        <label><b>Telefon Numarası</b></label>
        <input type='text' name='telefon' value='<?php echo $row["tel_no"]; ?>' maxlength="11" required>
        
        <label><b>E-posta</b></label>
        <input type='email' name='eposta' value='<?php echo $row["eposta"]; ?>' readonly>

        <label><b>Adres</b></label>
        <textarea name='adres' maxlength="100" ><?php echo $row["adres"]; ?></textarea>

        <label><b>Aktiflik Durumu</b></label><br>
        <input type='radio' id='aktif' name='aktiflik' value='1' <?php echo $row['aktiflik'] ? 'checked' : ''; ?>>
        <label for='aktif'>Aktif</label><br>
        <input type='radio' id='engel' name='aktiflik' value='0' <?php echo !$row['aktiflik'] ? 'checked' : ''; ?>>
        <label for='engel'>Erişim engelli</label><br>
        
        <button type='submit' name='guncelle' class='updatebtn'>Bilgileri Güncelle</button>
    </form>
</div>

<script>
function GuncellemeOnay() {
    return confirm("Bilgileri güncellemek istediğinize emin misiniz?");
}
</script>

</body>
</html>