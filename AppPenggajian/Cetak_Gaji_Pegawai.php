<?php
session_start();
if (isset($_SESSION['login'])) {
	include "Koneksi.php";
	include "Fungsi.php";
?>
<!DOCTYPE html>
<head>
	<title>CETAK GAJI PEGAWAI</title>
	<style type="text/css">
		body{
			font-family: "Times New Roman";
		}
		@media print{
			.no-print{
				display: none;
			}
		}

		table{
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<h3 align="center">Gaji Pegawai<br>Slip Gaji Pegawai</h3>
	<hr>
	<?php
		if ((isset($_GET['Bulan']) && $_GET['Bulan'] != '') && (isset($_GET['Tahun']) && $_GET['Tahun'] != '')) {
			$bulan = $_GET['Bulan'];
			$tahun = $_GET['Tahun'];
			$bulanTahun = $bulan.$tahun;
		}else{
			$bulan = date('m');
			$tahun = date('Y');
			$bulanTahun = $bulan.$tahun;
		}
	?>
	<table>
		<tr>
			<td>Bulan</td>
			<td>:</td>
			<td><?php echo Bulan($bulan); ?></td>
		</tr>
		<tr>
			<td>Tahun</td>
			<td>:</td>
			<td><?php echo $tahun; ?></td>
		</tr>
	</table>

	<table class="table table-striped">
			<tr>
				<th>NIP</th>
			</tr>
			<tr>
				<th>Nama</th>
			</tr>
			<tr>
				<th>Jabatan</th>
			</tr>
			<tr>
				<th>Alamat</th>
			</tr>
			<tr>
				<th>Gaji Pokok</th>
			</tr>
			<tr>
				<th>Uang Kehadiran</th>
			</tr>
			<tr>
				<th>Uang Makan</th>
			</tr>
			<tr>
				<th>Uang Transport</th>
			</tr>
			<tr>
				<th>Uang Pulsa</th>
			</tr>
			<tr>
				<th>Uang Lembur</th>
			</tr>
			<tr>
				<th>Tunjangan Simpanan Berencana</th>
			</tr>
			<tr>
				<th>Tunjangan Service Kendaraan</th>
			</tr>
			<tr>
				<th>Insentive Pinjaman</th>
			</tr>
			<tr>
				<th>Insentive Simpanan Berjangka</th>
			</tr>
			<tr>
				<th>Bonus Tahunan</th>
			</tr>
			<tr>
				<th>THR</th>
			</tr>
			<tr>
				<th>Tunj BPJS Kesehatan</th>
			</tr>
			<tr>
				<th>Tunj BPJS Ketenagakerjaan</th>
			</tr>
			<tr>
				<th>Tunj BPJS Jaminan Kematian</th>
			</tr>
			<tr>
				<th>Tunj BPJS Kecelakaan Kerja</th>
			</tr>
			<tr>
				<th>Bonus/Tunjangan Lain-Lain</th>
			</tr>
			<tr>
				<th>Gaji Bersih</th>
			</tr>
			<tr>
				<th>Potongan</th>
			</tr>
			<tr>
				<th>Pinjaman</th>
			</tr>
			<tr>
				<th>Total Gaji</th>
			</tr>
		<tbody>
			<?php
				$sql = mysqli_query($connect, "SELECT pegawai.nip, pegawai.nama_pegawai, 
							jabatan.nama_jabatan, jabatan.gaji_pokok, 
							master_gaji.masuk*uang_kehadiran AS uangkehadiran, 
							master_gaji.masuk*uang_makan AS uangmakan, 
							master_gaji.masuk*uang_transport AS uangtransport, uang_pulsa AS uangpulsa,
							master_gaji.lembur*uang_lembur AS uanglembur, 
							tunjangan_simpanan_berencana AS tunjangansimpanan, 
							tunjangan_servis_kendaraan AS tunjanganservis,
							insentive_pinjaman AS insentivepinjaman,
							insentive_simpanan AS insentivesimpanan,
							bonus_tahunan AS bonustahunan, thr AS thr, 
							tunjangan_bpjs_kesehatan AS bpjskes, tunjangan_bpjs_ketenagakerjaan AS bpjsket, 
							tunjangan_bpjs_jaminan_kematian AS bpjsjk, tunjangan_bpjs_kecelakaan_kerja AS bpjskk, 
							bonus_tunjangan_lain AS bonustunjanganlain, 
							(gaji_pokok + (SELECT uangkehadiran) + (SELECT uangmakan) + (SELECT uangtransport) + 
								(SELECT uangpulsa) + (SELECT uanglembur) + (SELECT tunjangansimpanan) + 
								(SELECT tunjanganservis) + (SELECT insentivepinjaman) + (SELECT insentivesimpanan) + 
								(SELECT bonustahunan) + (SELECT thr) + (SELECT bpjskes) + (SELECT bpjsket) + 
								(SELECT bpjsjk) + (SELECT bpjskk) + (SELECT bonustunjanganlain)) AS gajibersih, 
							potongan.total_potongan, pinjaman, 
							(SELECT gajibersih) - total_potongan - pinjaman AS totalgaji 
							FROM pegawai 
							INNER JOIN master_gaji ON pegawai.nip = master_gaji.nip 
							INNER JOIN potongan ON pegawai.nip = potongan.nip 
							INNER JOIN jabatan ON pegawai.kode_jabatan = jabatan.kode_jabatan 
							WHERE master_gaji.bulan = '$bulanTahun' ORDER BY pegawai.nip ASC ");
								
				$no=1;
				while($d = mysqli_fetch_array($sql)) {
					echo "
						<tr>
							<td>$d[nip]</td>
						</tr>
						<tr>
							<td>$d[nama_pegawai]</td>
						</tr>
						<tr>
							<td>$d[nama_jabatan]</td>
						</tr>
						<tr>
							<td>$d[alamat]</td>
						</tr>
						<tr>
							<td>".Rp($d['gaji_pokok'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['uangkehadiran'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['uangmakan'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['uangtransport'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['uangpulsa'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['uanglembur'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['tunjangansimpanan'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['tunjanganservis'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['insentivepinjaman'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['insentivesimpanan'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bonustahunan'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['thr'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bpjskes'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bpjsket'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bpjsjk'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bpjskk'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['bonustunjanganlain'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['gajibersih'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['total_potongan'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['pinjaman'])."</td>
						</tr>
						<tr>
							<td>".Rp($d['totalgaji'])."</td>
						</tr>";
				$no++;
			}
		?>
		</tbody>
	</table>

	<table width="100%">
		<tr>
			<td></td>
			<td width="200px">
				<br>
				<br>
				<p align="right"><?php echo Tgl(date("Y-m-d")); ?><br>Human Capital</p>
				<br>
				<br>
				<br>
				<br>
				<p>_____________________________________</p>

			</td>
		</tr>
	</table>

	<a href="#" class="no-print" onclick="window.print();">Cetak/Print Gaji</a>
	<br>
	<a href="Data_Penggajian.php" class="no-print">Back</a>

</body>
</html>

<?php
}else {
	header('location:Login.php');
}
?>