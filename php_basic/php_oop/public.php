<?php
 
// buat class laptop
class laptop {
 
   // buat protected property
   public $pemilik="Anto";
 
   public function akses_pemilik() {
      return $this->pemilik;
   }
   protected function hidupkan_laptop() {
      return "Hidupkan Laptop";
   }
   public function paksa_hidup() {
    return $this->hidupkan_laptop();
   }
}
  
// buat objek dari class laptop (instansiasi)
$laptop_anto = new laptop();
  
// jalankan method akses_pemilik()
echo "Pemiliknya :". $laptop_anto->akses_pemilik(); // "Anto"
echo "<br>";
  
// echo $laptop_anto->hidupkan_laptop(); // "Hidupkan Laptop"
echo $laptop_anto->paksa_hidup(); // "Hidupkan Laptop"
?> 