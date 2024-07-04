<?php
session_start();
require_once '../autoload.php';

$vt = new Veritabani(); 
$yonetici = new Yonetici();
$kullanici = new Kullanici();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['girisyap'])) {
    $sonuc = $yonetici->yoneticiGiris($_POST['eposta'], $_POST['sifre']);

    if ($sonuc == 1) {
        $_SESSION['yonetici_eposta'] = $_POST['eposta'];
        echo '<script>alert("Giriş başarılı!"); window.location.href = "tekyonetici.php";</script>';
        exit();
    } else {
        echo '<script>alert("Giriş bilgilerinizi kontrol ediniz.");</script>';
    }
}

$yonetici_oturum = isset($_SESSION['yonetici_eposta']);

if ($yonetici_oturum) {
    $sql = "SELECT * FROM kullanicilar"; 
    $result = $vt->sorgu($sql); 
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $yonetici_oturum ? "Kullanıcıları Güncelle" : "Yönetici Giriş"; ?></title>
    <link rel="stylesheet" href="../mystyle.css">
</head>
<body class="<?php echo $yonetici_oturum ? "body-profil" : "body-girisyap"; ?>">
<?php if ($yonetici_oturum): ?>
    <div class="container">
        <h1>Kullanıcıları Güncelle</h1>
        <div class="table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>TC Kimlik Numarası</th>
                        <th>Ad</th>
                        <th>Soyad</th>
                        <th>Telefon Numarası</th>
                        <th>E-posta</th>
                        <th>Adres</th>
                        <th>Aktiflik Durumu</th>
                        <th>Düzenle</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["tc_no"]."</td>";
                        echo "<td>".$row["ad"]."</td>";
                        echo "<td>".$row["soyad"]."</td>";
                        echo "<td>".$row["tel_no"]."</td>";
                        echo "<td>".$row["eposta"]."</td>";
                        echo "<td>".$row["adres"]."</td>";
                        echo "<td>".($row['aktiflik'] ? 'Aktif' : 'Erişim engelli')."</td>";
                        echo "<td><a href='kullanicibilgi.php?eposta=".$row['eposta']."' class='editbtn'>Düzenle</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Kullanıcı bulunamadı.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <form action="tekyonetici.php" method="POST">
        <div class="container">
            <div class="header">
                <h2>Yönetici Girişi 💼</h2>
            </div>
            <hr>
            <label><b>E-posta</b></label>
            <input type="email" placeholder="xxx@xxx.com" name="eposta" id="eposta" required>
            <label><b>Şifre</b></label>
            <input type="password" name="sifre" id="sifre" required>
            <hr>
            <button type="submit" class="registerbtn" name="girisyap">Giriş Yap</button>
        </div>
    </form>
<?php endif; ?>
</body>
</html>
