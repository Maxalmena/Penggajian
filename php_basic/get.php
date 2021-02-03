<?php
    if (!empty($_GET["nama"]) || !empty($_GET["umur"])){
        $nama = $_GET["nama"];
        $umur = $_GET["umur"];
        echo "Nama ", $nama, " umur ", $umur, " tahun";
    }
?>

<form action="#">
    Nama : <input type="text" name="nama"><br>
    Umur : <input type="text" name="umur"><br>
    <input type="submit" value="submit">
</form>