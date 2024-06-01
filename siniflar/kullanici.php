<?php
require_once 'autoload.php';

class kullanici {
  private $db;

  public function __construct() {
      $this->db = new Veritabani();
  }

  public function veriEkle($tc, $ad, $soyad, $tel, $eposta, $sifre, $adres) {
    if (empty($tc)) return "TC Kimlik Numarası boş olamaz.";
    if (empty($ad)) return "Ad boş olamaz.";
    if (empty($soyad)) return "Soyad boş olamaz.";
    if (empty($tel)) return "Telefon Numarası boş olamaz.";
    if (empty($eposta)) return "E-posta boş olamaz.";
    if (empty($sifre)) return "Şifre boş olamaz.";
    if (empty($adres)) return "Adres boş olamaz.";
    if (strlen($tc) != 11) return "TC Kimlik Numaranızı kontrol ediniz.";
    if (strlen($tel) != 10) return "Telefon Numarasnızı kontrol ediniz.";

    $hashedsifre = password_hash($sifre, PASSWORD_BCRYPT);

      $sql = "INSERT INTO kullanicilar (tc_no, ad, soyad, tel_no, eposta, sifre, adres) 
              VALUES ('$tc', '$ad', '$soyad', '$tel', '$eposta', '$hashedsifre', '$adres')";
      if ($this->db->sorgu($sql)) {
          return "Kayıt başarılı!";
      } else {
          return "Kayıt başarısız: " . $this->db->baglanti->error;
      }
  }
  
  public function kullaniciGiris($eposta, $sifre) {
    if (empty($eposta)) return "E-posta boş olamaz.";
    if (empty($sifre)) return "Şifre boş olamaz.";

    $sql = "SELECT * FROM kullanicilar WHERE eposta = '$eposta'";
    $result = $this->db->sorgu($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedsifre = $row['sifre'];

        if (password_verify($sifre, $hashedsifre)) {
            $_SESSION['eposta'] = $eposta;
            return "Giriş başarılı!";
        } else {
            return "Şifre hatalı.";
        }
    } else {
        return "E-posta hatalı.";
    }
    }

   public function veriAl() {
    return $this->db;
    }
    public function veriGuncelle($tc, $ad, $soyad, $tel, $eposta, $adres) {

    $sql = "UPDATE kullanicilar SET 
            tc_no = '$tc', 
            ad = '$ad', 
            soyad = '$soyad', 
            tel_no = '$tel', 
            adres = '$adres' 
            WHERE eposta = '$eposta'";
    return $this->db->sorgu($sql);
}
}

?>