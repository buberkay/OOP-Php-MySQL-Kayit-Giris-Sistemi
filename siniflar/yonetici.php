<?php
require_once '../autoload.php';

class yonetici{
  private $db;

  public function __construct() {
      $this->db = new Veritabani();
  }

  public function yoneticiGiris($eposta, $sifre) {
    if (empty($eposta) || empty($sifre) || !filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        return 0;
    }

    $sql = "SELECT * FROM yoneticiler WHERE eposta = '$eposta'";
    $result = $this->db->sorgu($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedsifre = $row['sifre'];

        if (password_verify($sifre, $hashedsifre)) {
            $_SESSION['eposta'] = $eposta;
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

}
?>