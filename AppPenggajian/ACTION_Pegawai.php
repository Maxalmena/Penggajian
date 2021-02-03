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
		//PROSES MENYIMPAN DATA

		//Menyimpan kiriman form ke variable
		$nip 			= $_POST['NIP'];
		$username 		= $_POST['Username'];
		$password 		= md5($_POST['Password']);
		$role 			= $_POST['Role'];
		$nama 			= $_POST['NamaPegawai'];
		$jabatan 		= $_POST['Jabatan'];
		$tempat 		= $_POST['TempatLahir'];
		$tanggal 		= $_POST['TanggalLahir'];
		$alamat 		= $_POST['Alamat'];
		$notelp 		= $_POST['NoTelp'];

		if ($nip=='' || $username=='' || $password=='' || $role=='' || $nama=='' ||
		 	$jabatan=='' || $tempat=='' || $tanggal==''  || $alamat=='' || $notelp=='') {
			header('location:Profile_Pegawai.php?view=add&e=belumlengkap');
		}else{
			//proses penyimpanan data
			$save = mysqli_query($connect, "INSERT INTO pegawai(nip, username, password, role, nama_pegawai,
			 kode_jabatan, tempat_lahir, tanggal_lahir, alamat, no_telp) 
			VALUES ('$nip', '$username', '$password', '$role', '$nama', '$jabatan', '$tempat', '$tanggal', 
				'$alamat', '$notelp')");

			if ($save) {
				header('location:Profile_Pegawai.php?e=success');
			}else{
				header('location:Profile_Pegawai.php?e=fail');
			}
		}
	}
	// act update
	elseif ($_GET['act'] == 'update') {
		//Menyimpan kiriman form ke variable
		$nip 			= $_POST['NIP'];
		$username 		= $_POST['Username'];
		$password 		= md5($_POST['Password']);
		$role 			= $_POST['Role'];
		$nama 			= $_POST['NamaPegawai'];
		$jabatan 		= $_POST['Jabatan'];
		$tempat 		= $_POST['TempatLahir'];
		$tanggal 		= $_POST['TanggalLahir'];
		$alamat 		= $_POST['Alamat'];
		$notelp 		= $_POST['NoTelp'];

		if ($nip=='' || $username=='' || $role=='' || $nama=='' || $jabatan=='' || $tempat=='' || 
			$tanggal==''  || $alamat=='' || $notelp=='') {
			header('location:Profile_Pegawai.php?view=edit&e=belumlengkap');
		}else{
			if ($password=='') {
				$update = mysqli_query($connect, "UPDATE pegawai SET nip='$nip', username='$username', role='$role',  
					nama_pegawai='$nama', jabatan='$jabatan', tempat_lahir='$tempat', tanggal_lahir='tanggal', 
					alamat='$alamat', no_telp='$notelp' ");
			}else{
				$update = mysqli_query($connect, "UPDATE pegawai SET nip='$nip', username='$username', 
					password='$password', role='$role', nama_pegawai='$nama', jabatan='$jabatan', tempat_lahir='$tempat', 
					tanggal_lahir='$tanggal', alamat='$alamat', no_telp='$notelp' ");
			}

			if ($update) {
				header('location:Profile_Pegawai.php?e=success');
			}else{
				header('location:Profile_Pegawai.php?e=fail');
			}
		}
	}
}

?>