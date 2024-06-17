<?php
require_once 'autoload.php';

class yonetici{
  private $db;

  public function __construct() {
      $this->db = new Veritabani();
  }

  public function yoneticiGiris($eposta, $sifre) {
    if (empty($eposta)) return "E-posta boş olamaz.";
    if (empty($sifre)) return "Şifre boş olamaz.";
    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) return "Geçersiz e-posta adresi.";

    $sql = "SELECT * FROM yoneticiler WHERE eposta = '$eposta'";
    $result = $this->db->sorgu($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedsifre = $row['sifre'];

        if (password_verify($sifre, $hashedsifre)) {
            $_SESSION['eposta'] = $eposta;
            return "Giriş başarılı!";
        } else {
            return "Giriş bilgilerinizi kontrol ediniz.";
        }
    } else {
        return "Giriş bilgilerinizi kontrol ediniz.";
    }
    }
}
?>