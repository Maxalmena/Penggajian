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
		$code							= $_POST['KodeJabatan'];
		$nama 							= $_POST['NamaJabatan'];
		$gaji 							= $_POST['GajiPokok'];
		$uangkehadiran 					= $_POST['UangKehadiran'];
		$uangmakan 						= $_POST['UangMakan'];
		$uangtransport 					= $_POST['UangTransport'];
		$uangpulsa 						= $_POST['UangPulsa'];
		$uanglembur 					= $_POST['UangLembur'];
		$tunjangansimpananberencana 	= $_POST['TunjanganSimpananBerencana'];
		$tunjanganserviskendaraan 		= $_POST['TunjanganServiceKendaraan'];
		$insentivepinjaman 				= $_POST['InsentivePinjaman'];
		$insentivesimpanan 				= $_POST['InsentiveSimpanan'];
		$bonustahunan 					= $_POST['BonusTahunan'];
		$thr 							= $_POST['THR'];
		$bpjskesehatan 					= $_POST['TunjanganBPJSKesehatan'];
		$bpjsketenagakerjaan 			= $_POST['TunjanganBPJSKetenagakerjaan'];
		$bpjsjaminankematian 			= $_POST['TunjanganBPJSJaminanKematian'];
		$bpjskecelakaankerja 			= $_POST['TunjanganBPJSKecelakaanKerja'];
		$bonustunjanganlain 			= $_POST['BonusTunjanganLain'];

		if ($code=='' || $nama=='' || $gaji=='' || $uangkehadiran=='' || $uangmakan=='' || $uangtransport=='' || 
			$uangpulsa=='' || $uanglembur=='' || $tunjangansimpananberencana=='' || $tunjanganserviskendaraan=='' || 
			$insentivepinjaman=='' || $insentivesimpanan=='' || $bonustahunan=='' || $thr=='' || 
			$bpjskesehatan=='' || $bpjsketenagakerjaan=='' || $bpjsjaminankematian=='' || 
			$bpjskecelakaankerja=='' || $bonustunjanganlain=='' ) {
			header('location:Data_Jabatan.php?view=add&e=belumlengkap');
		}else{
			//proses penyimpanan data
			$save = mysqli_query($connect, "INSERT INTO jabatan (kode_jabatan, nama_jabatan, gaji_pokok, uang_kehadiran, 
				uang_makan, uang_transport, uang_pulsa, uang_lembur, tunjangan_simpanan_berencana, 
				tunjangan_servis_kendaraan, insentive_pinjaman, insentive_simpanan, bonus_tahunan, thr, 
				tunjangan_bpjs_kesehatan, tunjangan_bpjs_ketenagakerjaan, tunjangan_bpjs_jaminan_kematian, 
				tunjangan_bpjs_kecelakaan_kerja, bonus_tunjangan_lain) 
				VALUES ('$code', '$nama', '$gaji', '$uangkehadiran', '$uangmakan', '$uangtransport', 
					'$uangpulsa', '$uanglembur', '$tunjangansimpananberencana', '$tunjanganserviskendaraan', 
					'$insentivepinjaman', '$insentivesimpanan', '$bonustahunan', '$thr',
					'$bpjskesehatan', '$bpjsketenagakerjaan', '$bpjsjaminankematian', '$bpjskecelakaankerja', 
					'$bonustunjanganlain')");

			if ($save) {
				header('location:Data_Jabatan.php?e=success');
			}else{
				header('location:Data_Jabatan.php?e=fail');
			}
		}
	}
	// act update
	elseif ($_GET['act'] == 'update') {
		//Menyimpan kiriman form ke variable
		$code							= $_POST['KodeJabatan'];
		$nama 							= $_POST['NamaJabatan'];
		$gaji 							= $_POST['GajiPokok'];
		$uangkehadiran 					= $_POST['UangKehadiran'];
		$uangmakan 						= $_POST['UangMakan'];
		$uangtransport 					= $_POST['UangTransport'];
		$uangpulsa 						= $_POST['UangPulsa'];
		$uanglembur 					= $_POST['UangLembur'];
		$tunjangansimpananberencana 	= $_POST['TunjanganSimpananBerencana'];
		$tunjanganserviskendaraan 		= $_POST['TunjanganServiceKendaraan'];
		$insentivepinjaman 				= $_POST['InsentivePinjaman'];
		$insentivesimpanan 				= $_POST['InsentiveSimpanan'];
		$bonustahunan 					= $_POST['BonusTahunan'];
		$thr 							= $_POST['THR'];
		$bpjskesehatan 					= $_POST['TunjanganBPJSKesehatan'];
		$bpjsketenagakerjaan 			= $_POST['TunjanganBPJSKetenagakerjaan'];
		$bpjsjaminankematian 			= $_POST['TunjanganBPJSJaminanKematian'];
		$bpjskecelakaankerja 			= $_POST['TunjanganBPJSKecelakaanKerja'];
		$bonustunjanganlain 			= $_POST['BonusTunjanganLain'];

		if ($code=='' || $nama=='' || $gaji=='' || $uangkehadiran=='' || $uangkehadirangmakan=='' || $uangtransport=='' || 
			$uangpulsa=='' || $uanglembur=='' || $tunjangansimpananberencana=='' || $tunjanganserviskendaraan=='' || 
			$insentivepinjaman=='' || $insentivesimpanan=='' || $bonustahunan=='' || $thr=='' || 
			$bpjskesehatan=='' || $bpjsketenagakerjaan=='' || $bpjsjaminankematian=='' || 
			$bpjskecelakaankerja=='' || $bonustunjanganlain=='') {
			header('location:Data_Jabatan.php?view=edit&e=belumlengkap');
		}else{
			//Proses Update
			$update = mysqli_query($connect, "UPDATE jabatan SET nama_jabatan='$nama', gaji_pokok='$gaji', 
				uang_kehadiran='$uangkehadiran', uang_makan='$uangmakan', uang_transport='$uangtransport', 
				uang_pulsa='$uangpulsa', uang_lembur='$uanglembur', 
				tunjangan_simpanan_berencana='$tunjangansimpananberencana', 
				tunjangan_servis_kendaraan='$tunjanganserviskendaraan', insentive_pinjaman='$insentivepinjaman', 
				insentive_simpanan='$insentivesimpanan', bonus_tahunan='$bonustahunan', thr='$thr', 
				tunjangan_bpjs_kesehatan='$bpjskesehatan', tunjangan_bpjs_ketenagakerjaan='$bpjsketenagakerjaan', 
				tunjangan_bpjs_jaminan_kematian='$bpjsjaminankematian', 
				tunjangan_bpjs_kecelakaan_kerja='$bpjskecelakaankerja', 
				bonus_tunjangan_lain='$bonustunjanganlain'
			WHERE kode_jabatan='$code'");

			if ($update) {
				header('location:Data_Jabatan.php?e=success');
			}else{
				header('location:Data_Jabatan.php?e=fail');
			}
		}
	}
	// act delete
	elseif ($_GET['act'] == 'delete') {
		$clear = mysqli_query($connect, "DELETE FROM jabatan WHERE kode_jabatan='$_GET[id]'");

		if ($clear) {
			header('location:Data_Jabatan.php?e=success');
		}else{
			header('location:Data_Jabatan.php?e=fail');
		}
	}
}

?>