<?php
require_once '../autoload.php';

class kullanici {
  private $db;

  public function __construct() {
      $this->db = new Veritabani();
  }

  private function veriKontrol($tc, $ad, $soyad, $tel, $eposta, $adres) {
    if (empty($tc)) return "TC Kimlik Numarası boş olamaz.";
    if (empty($ad)) return "Ad boş olamaz.";
    if (empty($soyad)) return "Soyad boş olamaz.";
    if (empty($tel)) return "Telefon Numarası boş olamaz.";
    if (empty($eposta)) return "E-posta boş olamaz.";
    if (empty($adres)) return "Adres boş olamaz.";

    if ((strlen($tc) != 11) || (!is_numeric($tc))) return "TC Kimlik numaranızı geçerli değildir.";
    if ((strlen($tel) != 10) || (!is_numeric($tel))) return "Telefon numaranızı geçerli değildir.";

    $gecersizKarakterler = '/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+/';
    if (preg_match($gecersizKarakterler, $ad) || preg_match($gecersizKarakterler, $soyad)) {
        return "İsim bilgilerinizde geçersiz karakterler bulunmaktadır.";
    }
    if((strlen($ad)>20) || strlen($soyad)>20) return "İsim bilgileriniz çok uzundur. Kontrol ediniz.";

    if ((strlen($adres) > 80)) return "Adresiniz çok uzundur. Kontrol ediniz.";

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) return "Geçersiz e-posta adresi.";

    return true;
    }

  public function veriEkle($tc, $ad, $soyad, $tel, $eposta, $sifre, $adres) {

    $kontrol = $this->veriKontrol($tc, $ad, $soyad, $tel, $eposta, $adres);
    if ($kontrol !== true) return $kontrol;
    if (empty($sifre)) return "Şifre boş olamaz.";

    $hashedsifre = password_hash($sifre, PASSWORD_BCRYPT);

    $sql = "INSERT INTO kullanicilar (tc_no, ad, soyad, tel_no, eposta, sifre, adres) 
    VALUES ('$tc', '$ad', '$soyad', '$tel', '$eposta', '$hashedsifre', '$adres')";
    if ($this->db->sorgu($sql)) {
      return 1;
    } else {
      return 0;
      }
  }
  
  public function veriGuncelle($tc, $ad, $soyad, $tel, $eposta, $adres) {
    $kontrol = $this->veriKontrol($tc, $ad, $soyad, $tel, $eposta, $adres);
    if ($kontrol !== true) return $kontrol;

    $sql = "UPDATE kullanicilar SET 
            tc_no = '$tc', 
            ad = '$ad', 
            soyad = '$soyad', 
            tel_no = '$tel', 
            adres = '$adres' 
            WHERE eposta = '$eposta'";
    if ($this->db->sorgu($sql)) {
        return 1;
    } else {
        return 0;
    }
}

public function aktiflikGuncelle($eposta, $aktiflik) {
    $aktiflik = $aktiflik ? 1 : 0;
    $sql = "UPDATE kullanicilar SET aktiflik = '$aktiflik' WHERE eposta = '$eposta'";
    if ($this->db->sorgu($sql)) {
        return 1;
    } else {
        return 0;
    }
}
  
    public function kullaniciGiris($eposta, $sifre) {
      if (empty($eposta)) return "E-posta boş olamaz.";
      if (empty($sifre)) return "Şifre boş olamaz.";
      if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) return "Geçersiz e-posta adresi.";
  
      $sql = "SELECT * FROM kullanicilar WHERE eposta = '$eposta'";
      $result = $this->db->sorgu($sql);
  
      if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          $hashedsifre = $row['sifre'];
          $aktiflik = $row['aktiflik'];
  
          if ($aktiflik == 1 && password_verify($sifre, $hashedsifre)) {
              $_SESSION['eposta'] = $eposta;
              return 1;
          } elseif ($aktiflik == 0) {
              return 3;  //hesap banlı
          } else {
              return 0;
          }
      } else {
          return 0;
      }
     }  

   public function veriAl() {
    return $this->db;
    }


    public function kullanicicikis() {
        session_destroy();
     }

}
?>