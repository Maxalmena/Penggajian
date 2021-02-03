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

		if ($nip=='' || $username=='' || $_POST['Password']=='' || $role=='' || $nama=='' ||
		 	$jabatan=='' || $tempat=='' || $tanggal==''  || $alamat=='' || $notelp=='') {
			header('location:Data_Pegawai.php?view=add&e=belumlengkap');
		}else{
			//proses penyimpanan data
			$save = mysqli_query($connect, "INSERT INTO pegawai(nip, username, password, role, nama_pegawai,
			 kode_jabatan, tempat_lahir, tanggal_lahir, alamat, no_telp) 
			VALUES ('$nip', '$username', '$password', '$role', '$nama', '$jabatan', '$tempat', '$tanggal', 
				'$alamat', '$notelp')");

			if ($save) {
				header('location:Data_Pegawai.php?e=success');
			}else{
				header('location:Data_Pegawai.php?e=fail');
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

		if ($username=='' || $role=='' || $nama=='' || $jabatan=='' || $tempat=='' || 
			$tanggal==''  || $alamat=='' || $notelp=='') {
			header('location:Data_Pegawai.php?view=edit&e=belumlengkap');
		}else{
			if ($_POST['Password']=='') {
				$update = mysqli_query($connect, "UPDATE pegawai SET username='$username', role='$role',  
					nama_pegawai='$nama', jabatan='$jabatan', tempat_lahir='$tempat', tanggal_lahir='$tanggal', 
					alamat='$alamat', no_telp='$notelp' 
					WHERE nip='$nip' ");
			}else{
				$update = mysqli_query($connect, "UPDATE pegawai SET username='$username', 
					password='$password', role='$role', nama_pegawai='$nama', jabatan='$jabatan', tempat_lahir='$tempat', 
					tanggal_lahir='$tanggal', alamat='$alamat', no_telp='$notelp' 
					WHERE nip='$nip'");
			}

			if ($update) {
				header('location:Data_Pegawai.php?e=success');
			}else{
				header('location:Data_Pegawai.php?e=fail');
			}
		}
	}
	// act delete
	elseif ($_GET['act'] == 'delete') {
		$clear = mysqli_query($connect, "DELETE FROM pegawai WHERE nip='$_GET[id]' AND role!='admin' ");

		if ($clear) {
			header('location:Data_Pegawai.php?e=success');
		}else{
			header('location:Data_Pegawai.php?e=fail');
		}
	}
}

?>