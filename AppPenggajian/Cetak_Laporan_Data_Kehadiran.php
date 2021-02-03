<?php
session_start();
if (isset($_SESSION['login'])) {
	include "Koneksi.php";
	include "Fungsi.php";
?>
<!DOCTYPE html>
<head>
	<title>CETAK DATA KEHADIRAN PEGAWAI</title>
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
	<h3 align="center">Kehadiran Pegawai<br>Data Kehadiran Pegawai</h3>
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

	<table border="1" cellpadding="4" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No.</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Golongan</th>
				<th>Masuk</th>
				<th>Sakit</th>
				<th>Izin</th>
				<th>Alpha</th>
				<th>Lembur</th>
				<th>Potongan</th>
				<th>Pinjaman</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = mysqli_query($connect, "SELECT pegawai.nip, pegawai.nama_pegawai, jabatan.nama_jabatan, golongan.nama_golongan, master_gaji.* 
					FROM pegawai 
					INNER JOIN master_gaji ON master_gaji.nip = pegawai.nip 
					INNER JOIN jabatan ON jabatan.kode_jabatan = pegawai.kode_jabatan
					INNER JOIN golongan ON golongan.kode_golongan = pegawai.kode_golongan
					WHERE master_gaji.bulan = '$bulanTahun' 
					ORDER BY pegawai.nip ASC");
								
				$no=1;
				while($d = mysqli_fetch_array($sql)) {
					echo "<tr>
						<td width='40px' align='center'>$no</td>
						<td>$d[nip]</td>
						<td>$d[nama_pegawai]</td>
						<td>$d[nama_jabatan]</td>
						<td>$d[nama_golongan]</td>
						<td>$d[masuk]</td>
						<td>$d[sakit]</td>
						<td>$d[izin]</td>
						<td>$d[alpha]</td>
						<td>$d[lembur]</td>
						<td>".Rp($d['total_potongan'])."</td>
						<td>".Rp($d['pinjaman'])."</td>
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
				<p><?php echo Tgl(date("Y-m-d")); ?><br>Human Capital</p>
				<br>
				<br>
				<br>
				<p>_____________________________________</p>

			</td>
		</tr>
	</table>

	<a href="#" class="no-print" onclick="window.print();">Cetak/Print Kehadiran</a>

</body>
</html>

<?php
}else {
	header('location:Login.php');
}
?>