<?php
// buat class induk: komputer
class komputer {
  
   public $merk;
   public $processor;
   public $memory;
  
   private function beli_komputer() {
     return "Beli komputer baru";
   }
   protected function maksa_beli() {
    return $this->beli_komputer();
   }
   
}
  
// turunkan class komputer ke laptop
class laptop extends komputer {
  
  public function beli_laptop() {
    return $this->beli_komputer();
  }
  
  public function maksa_beli_laptop(){
      return $this->maksa_beli();
  }
  
  public function lihat_spec() {
     return "merk: $this->merk, processor: $this->processor, 
     memory: $this->memory";
  }
}
  
// $komputer_baru = new komputer();
// $komputer_baru->merk = "VIVO";
// $komputer_baru->processor ="intel core i5";
// $komputer_baru->memory = "16 GB";
// echo $komputer_baru->beli_komputer();
echo "<br />";
// echo $komputer_baru->lihat_spec();
// buat objek dari class laptop (instansiasi)
$laptop_baru = new laptop();
  
// isi property objek
$laptop_baru->merk = "acer";
$laptop_baru->processor ="intel core i5";
$laptop_baru->memory = "2 GB";
  
//panggil method objek
echo $laptop_baru->maksa_beli_laptop();
echo "<br />";
echo $laptop_baru->lihat_spec();
?>