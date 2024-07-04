<?php
require_once '../autoload.php';

class veriKontrol {

public function veriKontrol($tc, $ad, $soyad, $tel, $eposta, $adres) {
    if (empty($tc)) return "TC Kimlik Numarası boş olamaz.";
    if (empty($ad)) return "Ad boş olamaz.";
    if (empty($soyad)) return "Soyad boş olamaz.";
    if (empty($tel)) return "Telefon Numarası boş olamaz.";
    if (empty($eposta)) return "E-posta boş olamaz.";

    if ((strlen($tc) != 11) || (!is_numeric($tc))) return "TC Kimlik numaranızı geçerli değildir.";
    if ((strlen($tel) != 10) || (!is_numeric($tel))) return "Telefon numaranızı geçerli değildir.";

    $gecersizKarakterler = '/[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]+/';
    if (preg_match($gecersizKarakterler, $ad) || preg_match($gecersizKarakterler, $soyad)) {
        return "İsim bilgilerinizde geçersiz karakterler bulunmaktadır.";
    }
    if((strlen($ad)>30) || strlen($soyad)>30) return "İsim bilgileriniz çok uzundur. Kontrol ediniz.";

    if ((strlen($adres) > 100)) return "Adresiniz çok uzundur. Kontrol ediniz.";

    if (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) return "Geçersiz e-posta adresi.";

    return true;
    }
}

?>