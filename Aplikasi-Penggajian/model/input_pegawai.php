<?php
	 include "../config/config.php";
	 $tgl = date("Y-m-d",strtotime($_POST['tgl_lhr']));
	$sql="INSERT INTO `t_pegawai`(
	`nip`,
	`nama_pegawai`,
	`tgl_lhr`,
	`alamat`,
	`tlp`,
	`id_jabatan`)
	VALUES ('$_POST[nip]','$_POST[nama_pegawai]','".$tgl."','$_POST[alamat]','$_POST[tlp]','$_POST[id_jabatan]')";
	mysql_query($sql) or die("Gagal Menyimpan");
	header ("location:../index.php?p=data_pegawai");
?>