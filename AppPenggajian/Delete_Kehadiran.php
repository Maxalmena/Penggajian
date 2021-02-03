<?php

session_start();
include "Koneksi.php";

if (!isset($_SESSION['login'])) {
	header('location:Login.php');
}

//JIKA ADA get act
if (isset($_GET['act'])) {
	//act insert
	if($_GET['act']=='insert'){
		$bulan 		= $_POST['Bulan'];
		$nip 		= $_POST['NIP'];
		$masuk		= $_POST['Masuk'];
		$sakit		= $_POST['Sakit'];
		$izin		= $_POST['Izin'];
		$alpha		= $_POST['Alpha'];
		$lembur		= $_POST['Lembur'];
		$potongan	= $_POST['Potongan'];
		$pinjaman	= $_POST['Pinjaman'];

		$count = count($nip);

		$sql = "INSERT INTO master_gaji(bulan, nip, masuk, sakit, izin, alpha, lembur, potongan, pinjaman) VALUES ";

		for($i=0; $i < $count; $i++){
			$sql .= "('{$bulan[$i]}', '{$nip[$i]}', '{$masuk[$i]}', '{$sakit[$i]}', '{$izin[$i]}', '{$alpha[$i]}', 
				'{$lembur[$i]}', '{$potongan[$i]}', '{$pinjaman[$i]}')"; 
			$sql .= " , "			;
		}

		$sql = rtrim($sql, " , ");

		$save = mysqli_query($connect, $sql);
			if ($save) {
				header('location:Data_Kehadiran.php?e=success');
			}else{
				header('location:Data_Kehadiran.php?e=fail');
			}
	}
	// act update
	elseif ($_GET['act'] == 'update') {
		//Menyimpan kiriman form ke variable
		$bulan 		= $_POST['Bulan'];
		$nip 		= $_POST['NIP'];
		$masuk		= $_POST['Masuk'];
		$sakit		= $_POST['Sakit'];
		$izin		= $_POST['Izin'];
		$alpha		= $_POST['Alpha'];
		$lembur		= $_POST['Lembur'];
		$potongan	= $_POST['Potongan'];
		$pinjaman	= $_POST['Pinjaman'];

		$count = count($nip);

		for($i=0; $i < $count; $i++){
			$update = mysqli_query($connect, "UPDATE master_gaji SET masuk='$masuk[$i]', sakit='$sakit[$i]', izin='$izin[$i]', 
				alpha = '$alpha[$i]' , lembur = '$lembur[$i]', potongan = '$potongan[$i]', pinjaman = '$pinjaman[$i]' 
				WHERE bulan = '$bulan[$i]' AND nip = '$nip[$i]' ");
		}



			if ($update) {
				header('location:Data_Kehadiran.php?e=success');
			}else{
				header('location:Data_Kehadiran.php?e=fail');
			}
	}
	// act delete
	elseif ($_GET['act'] == 'delete') {
		$clear = mysqli_query($connect, "DELETE FROM pegawai WHERE nip='$_GET[id]'");

		if ($delete) {
				header('location:Data_Kehadiran.php?e=success');
			}else{
				header('location:Data_Kehadiran.php?e=fail');
			}
	}
}

?>