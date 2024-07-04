<?php
session_start();
require_once '../autoload.php';

$girilenEposta = '';
$kullanici = new Kullanici();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['girisyap'])) {
    $girilenEposta = $_POST['eposta'];
    $sonuc = $kullanici->kullaniciGiris($girilenEposta, $_POST['sifre']);

    if ($sonuc == 1) {
        $_SESSION['eposta'] = $girilenEposta;
        header("Location: tekprofil.php");
        exit();
    } else if($sonuc == 0) {
        echo '<script>alert("Bilgilerinizi kontrol ediniz.");</script>';
    } else if($sonuc == 3){
        echo '<script>alert("Hesabınız askıya alınmıştır.");</script>';
    }
}

if (isset($_SESSION['eposta'])) {
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
        $aktiflik = isset($_POST['aktiflik']) ? $_POST['aktiflik'] : 1;

        $mesaj = $kullanici->veriGuncelle($tc, $ad, $soyad, $telefon, $eposta, $adres, $aktiflik);
        
        if ($mesaj == 1) {
            echo '<script>alert("Bilgiler güncellendi."); window.location.href = "tekprofil.php";</script>';
        } else if ($mesaj == 0) {
            echo '<script>alert("Hata! Bilgiler güncellenemedi."); window.location.href = "tekprofil.php";</script>';
        } else {
            echo '<script>alert("'.$mesaj.'");</script>';
        }
    }

    if (isset($_POST['cikisyap'])) {
        session_destroy();
        echo '<script>alert("Çıkış başarılı."); window.location.href = "tekprofil.php";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($_SESSION['eposta']) ? 'Profil' : 'Giriş Yap'; ?></title>
    <link rel="stylesheet" href="../mystyle.css">
</head>
<body class="body-girisyap">
<?php if (!isset($_SESSION['eposta'])): ?>
    <form action="tekprofil.php" method="POST">
        <div class="container">
            <div class="header">
                <h2>Kullanıcı Girişi 👥</h2>
            </div>
            <hr>
            <label><b>E-posta</b></label>
            <input type="email" placeholder="xxx@xxx.com" name="eposta" id="eposta" value="<?php echo htmlspecialchars($girilenEposta); ?>" required>

            <label><b>Şifre</b></label>
            <input type="password" name="sifre" id="sifre" required>

            <hr>
        </div> 

        <button type="submit" class="registerbtn" name="girisyap">Giriş Yap</button>
    </form>
<?php else: ?>
    <div class="container">
        <h1>Profil</h1>
        <form action="tekprofil.php" method="POST" onsubmit="return GuncellemeOnay()">
            <label><b>TC Kimlik Numarası</b></label>
            <input type="text" name="tc" value="<?php echo $userData['tc_no']; ?>" maxlength="11" required>
            
            <label><b>Ad</b></label>
            <input type="text" name="ad" value="<?php echo $userData['ad']; ?>" maxlength="30" required>
            
            <label><b>Soyad</b></label>
            <input type="text" name="soyad" value="<?php echo $userData['soyad']; ?>" maxlength="30" required>
            
            <label><b>Telefon Numarası</b></label>
            <input type="text" name="telefon" value="<?php echo $userData['tel_no']; ?>" maxlength="11" required>
            
            <label><b>Adres</b></label>
            <textarea name="adres" maxlength="100"><?php echo $userData['adres']; ?></textarea>
            
            <button type="submit" name="guncelle" class="updatebtn">Bilgileri Güncelle</button>
        </form>

        <form action="" method="POST">
            <button type="submit" class="cikisbtn" name="cikisyap">Çıkış Yap</button>
        </form>
    </div>
<?php endif; ?>

<script>
function GuncellemeOnay() {
    return confirm("Bilgilerinizi güncellemek istediğinize emin misiniz?");
}
</script>

</body>
</html>
