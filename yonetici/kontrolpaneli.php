<?php
session_start();
require_once '../autoload.php';

if (!isset($_SESSION['yonetici_eposta'])) {
    header("Location: yoneticigirisyap.php");
    exit();
}

$vt = new Veritabani(); 
$yonetici = new Yonetici();
$kullanici = new Kullanici();

$sql = "SELECT * FROM kullanicilar"; 
$result = $vt->sorgu($sql); 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcıları Güncelle</title>
    <link rel="stylesheet" href="../mystyle.css">
</head>
<body class="body-profil">
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
</body>
</html>
