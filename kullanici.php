<?php
require_once 'Veritabani.php';

class kullanici {
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

?>