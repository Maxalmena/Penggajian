<?php
//FUNGSI UNTUK MEMBUAT FORMAT RUPIAH
function Rp($angka){
	$rupiah = "Rp " . number_format($angka, 0, ',', '.');
	return $rupiah;
}

//FUNGSI UNTUK MEMBUAT BULAN INDONESIA
function Bulan($Bulan){
	switch ($Bulan) {
		case '1':
			$bulan = "Januari";
			break;
		
		case '2':
			$bulan = "Februari";
			break;
		
		case '3':
			$bulan = "Maret";
			break;
		
		case '4':
			$bulan = "April";
			break;
		
		case '5':
			$bulan = "Mei";
			break;
		
		case '6':
			$bulan = "Juni";
			break;
		
		case '7':
			$bulan = "Juli";
			break;
		
		case '8':
			$bulan = "Agustus";
			break;
		
		case '9':
			$bulan = "September";
			break;
		
		case '10':
			$bulan = "Oktober";
			break;
		
		case '11':
			$bulan = "November";
			break;
		
		case '12':
			$bulan = "Desember";
			break;
		
		default:
			$bulan = "Tidak ada Bulan yang dipilih";
			break;
	}
	return $bulan;
}

//FUNGSI MEMBUAT FORMAT TANGGAL DI INDONESIA
function Tgl($tgl){
	// 2020-12-25
	$tanggal = substr($tgl, 8, 2);//8 itu maksudnya dimulai diambil dari karakter ke 8 dan 2 adalah banyaknya karakter yg digunakan
	$bulan = Bulan(substr($tgl, 5, 2));//5 maksudnya dimulai dari karakter ke 5 dan 2 adalah banyaknya karakter yg digunakan
	$tahun = substr($tgl, 0, 4);// 0 maksudnya dimulai dari karakter ke 0 dan 4 adalah banyaknya karakter yg digunakan

	return $tanggal.' '.$bulan.' '.$tahun;
}

?>