<?php
	 include "../config/config.php";
	 $sql="SELECT *FROM t_absen where nip='$_POST[nip]' and bulan='$_POST[bulan]' and tahun='$_POST[tahun]'";
	 $cek=mysql_num_rows(mysql_query($sql));
	 if ($cek>0) {
	 	?>
	 	<script type="text/javascript">
	 	alert('Absensi pada bulan ini telah di lakukan!');
	 	window.location.href="../index.php?p=absen";
	 	</script>
	 	<?php
	 }else{
		$sql="INSERT INTO `t_absen` (`id`, `tanggal`, `bulan`, `tahun`, `nip`, `hadir`, `sakit`, `ijin`, `tanpa_keterangan`)
		VALUES (NULL,CURDATE(),'$_POST[bulan]','$_POST[tahun]','$_POST[nip]','$_POST[hadir]','$_POST[sakit]','$_POST[ijin]','$_POST[tanpa_keterangan]')";
		mysql_query($sql) or die("Gagal Menyimpan");
		header ("location:../index.php?p=absen");
	 	
	 }
?>