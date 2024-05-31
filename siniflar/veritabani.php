<?php
class veritabani {
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

?>