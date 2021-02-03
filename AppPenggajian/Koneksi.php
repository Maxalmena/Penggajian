<?php
$connect = mysqli_connect("localhost", "root", "" , "apppenggajian");

if (!$connect) {
	echo "Koneksi ke MySQL Gagal";
}
?>