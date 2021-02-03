<?php
include "config/config.php";
$tampil=mysql_query("select * from t_pegawai inner join t_jabatan on t_pegawai.id_jabatan=t_jabatan.id_jabatan and t_pegawai.nip='$_POST[nip]'");
$data=mysql_fetch_array($tampil);
$pegawai['nama_pegawai']=$data['nama_pegawai'];
echo json_encode($pegawai);
?>
