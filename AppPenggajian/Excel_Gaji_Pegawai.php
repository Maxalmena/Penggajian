<?php
//UNTUK MENYAMBUNGKAN EXCEL DENGAN APLIKASI
header("Content-tyoe: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=daftar_gaji_pegawai.xls");

include "Koneksi.php";
$bulanTahun = $_GET['Bulan'].$_GET['Tahun'];
?>
	<h3>SLIP GAJI PEGAWAI</h3>
	<p>Bulan:<?php echo $_GET['Bulan'].", Tahun: ".$_GET['Tahun']; ?></p>

	<table border="1" cellpadding="4" cellspacing="0">
		<thead>
			<tr>
				<th>No.</th>
				<th>NIP</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Golongan</th>
				<th>Status</th>
				<th>Jumlah Anak</th>
				<th>Gaji Pokok</th>
				<th>Tunj Jabatan</th>
				<th>Tunj Suami/Istri</th>
				<th>Tunj Anak</th>
				<th>Uang Makan</th>
				<th>Uang Transport</th>
				<th>Uang Pulsa</th>
				<th>Uang Lembur</th>
				<th>Bonus Tahunan</th>
				<th>THR</th>
				<th>Tunj BPJS Kesehatan</th>
				<th>Tunj BPJS Ketenagakerjaan</th>
				<th>Tunj BPJS Jaminan Kematian</th>
				<th>Tunj BPJS Kecelakaan Kerja</th>
				<th>Gaji Bersih</th>
				<th>Potongan</th>
				<th>Pinjaman</th>
				<th>Total Gaji</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = mysqli_query($connect, "SELECT pegawai.nip, pegawai.nama_pegawai, jabatan.nama_jabatan, 
					golongan.nama_golongan, pegawai.status, pegawai.jumlah_anak, jabatan.gaji_pokok, 
					jabatan.tunjangan_jabatan, 
					IF(pegawai.status='Menikah', tunjangan_suami_istri, 0) AS tjsi, 
					IF(pegawai.status='Menikah', tunjangan_anak, 0)*pegawai.jumlah_anak AS tja, 
					uang_makan AS uangmakan, uang_transport AS uangtransport, uang_pulsa AS uangpulsa,
					master_gaji.lembur*uang_lembur AS uanglembur, 
					bonus_tahunan AS bonustahunan, 
					thr AS thr, 
					tunjangan_bpjs_kesehatan AS bpjskes, tunjangan_bpjs_ketenagakerjaan AS bpjsket, 
					tunjangan_bpjs_jaminan_kematian AS bpjsjk, tunjangan_bpjs_kecelakaan_kerja AS bpjskk, 
					(gaji_pokok + tunjangan_jabatan + (SELECT tjsi) + (SELECT tja) + (SELECT uangmakan) + 
						(SELECT uangtransport) + (SELECT uangpulsa) + (SELECT uanglembur) + (SELECT bonustahunan) + 
						(SELECT thr) + (SELECT bpjskes) + (SELECT bpjsket) + (SELECT bpjsjk) + (SELECT bpjskk)) AS gajibersih, 
					potongan, pinjaman, 
					(SELECT gajibersih) - potongan - pinjaman AS totalgaji
					FROM pegawai 
					INNER JOIN master_gaji ON master_gaji.nip = pegawai.nip 
					INNER JOIN golongan ON golongan.kode_golongan = pegawai.kode_golongan 
					INNER JOIN jabatan ON jabatan.kode_jabatan = pegawai.kode_jabatan 
					WHERE master_gaji.bulan = '$bulanTahun' ORDER BY pegawai.nip ASC ");
								
				$no=1;
				while($d = mysqli_fetch_array($sql)) {
					echo "<tr>
						<td width='40px' align='center'>$no</td>
						<td>$d[nip]</td>
						<td>$d[nama_pegawai]</td>
						<td>$d[nama_jabatan]</td>
						<td>$d[nama_golongan]</td>
						<td>$d[status]</td>
						<td>$d[jumlah_anak]</td>
						<td>$d[gaji_pokok])</td>
						<td>$d[tunjangan_jabatan]</td>
						<td>$d[tjsi]</td>
						<td>$d[tja]</td>
						<td>$d[uangmakan]</td>
						<td>$d[uangtransport]</td>
						<td>$d[uangpulsa]</td>
						<td>$d[uanglembur]</td>
						<td>$d[bonustahunan]</td>
						<td>$d[thr]</td>
						<td>$d[bpjskes]</td>
						<td>$d[bpjsket]</td>
						<td>$d[bpjsjk]</td>
						<td>$d[bpjskk]</td>
						<td>$d[gajibersih]</td>
						<td>$d[potongan]</td>
						<td>$d[pinjaman]</td>
						<td>$d[totalgaji]</td>
					</tr>";
				$no++;
			}
		?>
		</tbody>
	</table>