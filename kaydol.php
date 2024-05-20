<?php
class Veritabani {
  private $host = "localhost";
  private $port = "3307";
  private $kullaniciAdi = "root";
  private $parola = "sifre123"; 
  private $veritabaniAdi = "kullanici";
  private $baglanti;

  public function __construct() {
      $this->baglanti = new mysqli($this->host, $this->kullaniciAdi, $this->parola, $this->veritabaniAdi, $this->port);
      
      if ($this->baglanti->connect_error) {
          die("Bağlantı başarısız: " . $this->baglanti->connect_error);
      }
  }

  public function sorgu($sql) {
      return $this->baglanti->query($sql);
  }

  public function __destruct() {
      $this->baglanti->close();
  }
}

class Kullanici {
  private $db;

  public function __construct() {
      $this->db = new Veritabani();
  }

  public function veriEkle($tc, $ad, $soyad, $tel, $eposta, $adres) {
    if (empty($tc)) return "TC Kimlik Numarası boş olamaz.";
    if (empty($ad)) return "Ad boş olamaz.";
    if (empty($soyad)) return "Soyad boş olamaz.";
    if (empty($tel)) return "Telefon Numarası boş olamaz.";
    if (empty($eposta)) return "E-posta boş olamaz.";
    if (empty($adres)) return "Adres boş olamaz.";
    if (strlen($tc) != 11) return "TC Kimlik Numaranızı kontrol ediniz.";
    if (strlen($tel) != 10) return "Telefon Numarasnızı kontrol ediniz.";

      $sql = "INSERT INTO kullanicilar (tc_no, ad, soyad, tel_no, eposta, adres) 
              VALUES ('$tc', '$ad', '$soyad', '$tel', '$eposta', '$adres')";
      if ($this->db->sorgu($sql)) {
          return "Kayıt başarılı!";
      } else {
          return "Kayıt başarısız: " . $this->db->baglanti->error;
      }
  }
}

if (isset($_POST['kaydol'])) {
  $kullanici = new Kullanici();
  $mesaj = $kullanici->veriEkle($_POST['tc'], $_POST['ad'], $_POST['soyad'], $_POST['telefon'], $_POST['eposta'], $_POST['adres']);
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
<body>
    
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

    <label><b>Adres</b></label>
    <input type="text" name="adres" id="adres" required>
    <hr>

  </div> 
  <button type="submit" class="registerbtn" name="kaydol">Kaydol</button>
</form>

</body>
</html>