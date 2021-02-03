<?php
session_start();
if(isset($_SESSION['login'])){
	include "Koneksi.php";
	include "Fungsi.php";
?>

<!DOCTYPE html>
<head>
	<title>Laporan Data Pegawai</title>
	<style type="text/css">
		body{
			font-family: "Times New Roman";
		}
		table{
			border-collapse: collapse;
		}

		@media print{
			.no-print{
				display: none;
			}
		}
	</style>
</head>
<body>
<h3 align="center">CETAK DATA PEGAWAI</h3>
<hr>
<p>Laporan Data Pegawai</p>
<table border="1" cellpadding="4" cellspacing="0" width="100%">
	<tr>
		<th>NIP</th>
		<th>Username</th>
		<th>Role</th>
		<th>Nama Pegawai</th>
		<th>Jabatan</th>
		<th>Tempat Lahir</th>
		<th>Tanggal Lahir</th>
		<th>Alamat</th>
		<th>No. Telp.</th>
	</tr>

	<?php
	$sql = mysqli_query($connect, "SELECT pegawai.*, jabatan.nama_jabatan 
			FROM pegawai
			INNER JOIN jabatan ON pegawai.kode_jabatan = jabatan.kode_jabatan
			ORDER BY pegawai.nama_pegawai ASC ");

	$no = 1;
	while ($d=mysqli_fetch_array($sql)) {
		echo "<tr>
			<td>$d[nip]</td>
			<td>$d[username]</td>
			<td>$d[role]</td>
			<td>$d[nama_pegawai]</td>
			<td>$d[nama_jabatan]</td>
			<td>$d[tempat_lahir]</td>
			<td>$d[tanggal_lahir]</td>
			<td>$d[alamat]</td>
			<td>$d[no_telp]</td>
		</tr>";
		$no++;
	}

	if(mysqli_num_rows($sql) < 1){
		echo "<tr><td colspan='7'>Belum Ada Data...</td></tr>";
	}
	?>

</table>

<table width="100%">
	<tr>
		<td></td>
		<td width="200px">
			<p>
				<?php echo Tgl(date('Y-m-d')); ?>
				<br>
				Human Capital
				<br>
				<br>
				<br>
				<p>_____________________________________</p>
			</p>
		</td>
	</tr>
</table>

<a href="#" class="no-print" onclick="window.print()">Cetak/Print Data Pegawai</a>
<br>
<a href="Data_Pegawai.php" class="no-print">Data Pegawai</a>


</body>
</html>

<?php
}else {
	header('Location:Login.php');
}
?>