<?php include "Header.php" ?>
<div class="container">

	<?php
	$view = isset($_GET['view'])  ? $_GET['view'] : null;

	switch ($view) {
		default:
		
		?>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Potongan Gaji Pegawai</h3>
				</div>
				<div class="panel-body">

					<form class="form-inline" method="get" action="">
						<div class="form-group">
							<label>Bulan</label>
							<select name="Bulan" class="form-control">
								<option value="">-Choose-</option>
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
						<div class="form-group">
							<label>Tahun</label>
							<select name="Tahun" class="form-control">
								<option value="">-Choose-</option>
								<?php
								$y= date('Y');
								for ($i=2010; $i <= $y; $i++) { 
									echo "<option value='$i'>$i</option>";
								}
								?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Tampilkan Data</button>
					</form>
					<br>
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
					<div class="alert alert-info">
						<strong>Bulan : <?php echo $bulan; ?>, Tahun : <?php echo $tahun; ?> </strong>
					</div>

					<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>NIP</th>
								<th>Nama Pegawai</th>
								<th>Jabatan</th>
								<th>Iuran BPJS Kesehatan</th>
								<th>Iuran BPJS Ketenagakerjaan</th>
								<th>Iuran BPJS Jaminan Kematian</th>
								<th>Iuran BPJS Kecelakaan Kerja</th>
								<th>Dana Pensiun</th>
								<th>PPh 21</th>
								<th>Uang Makan Digunakan</th>
								<th>Uang Transport Digunakan</th>
								<th>Simpanan Pokok</th>
								<th>Simpanan Wajib</th>
								<th>Simpanan Sukarela</th>
								<th>Simpanan Berencana</th>
								<th>Total Potongan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sql =mysqli_query($connect, "SELECT pegawai.nip, pegawai.nama_pegawai, jabatan.nama_jabatan,
								iuran_bpjs_kesehatan AS ibpjskes, iuran_bpjs_ketenagakerjaan AS ibpjsket, 
								iuran_bpjs_jaminan_kematian AS ibpjsjk, iuran_bpjs_kecelakaan_kerja AS ibpjskk, 
								dana_pensiun, pph21, master_gaji.masuk*uang_makan_digunakan AS uangmakandipakai, 
								master_gaji.masuk*uang_transport_digunakan AS uangtransportdipakai, simpanan_pokok, 
								simpanan_wajib, simpanan_sukarela, simpanan_berencana, 
								((SELECT ibpjskes) + (SELECT ibpjsket) + (SELECT ibpjsjk) + (SELECT ibpjskk) + (SELECT dana_pensiun) + pph21 + (SELECT uang_makan_digunakan) + (SELECT uang_transport_digunakan) + (SELECT simpanan_pokok) + (SELECT simpanan_wajib) + (SELECT simpanan_sukarela) + (SELECT simpanan_berencana)) AS total_potongan 
								FROM pegawai
								INNER JOIN potongan ON potongan.nip = pegawai.nip 
								INNER JOIN master_gaji ON master_gaji.nip = pegawai.nip
								INNER JOIN jabatan ON jabatan.kode_jabatan = pegawai.kode_jabatan 
								ORDER BY pegawai.nip ASC");

							$no=1;

							while ($d=mysqli_fetch_array($sql)) {
								echo "<tr>
									<td width='40' align='center'>$no</td>
									<td>$d[nip]</td>
									<td>$d[nama_pegawai]</td>
									<td>$d[nama_jabatan]</td>
									<td>$d[nama_golongan]</td>
									<td>".Rp($d['ibpjskes'])."</td>
									<td>".Rp($d['ibpjsket'])."</td>
									<td>".Rp($d['ibpjsjk'])."</td>
									<td>".Rp($d['ibpjskk'])."</td>
									<td>".Rp($d['dana_pensiun'])."</td>
									<td>".Rp($d['pph21'])."</td>
									<td>".Rp($d['uangmakandipakai'])."</td>
									<td>".Rp($d['uangtransportdipakai'])."</td>
									<td>".Rp($d['simpanan_pokok'])."</td>
									<td>".Rp($d['simpanan_wajib'])."</td>
									<td>".Rp($d['simpanan_sukarela'])."</td>
									<td>".Rp($d['simpanan_berencana'])."</td>
									<td>".Rp($d['total_potongan'])."</td>
								</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
					</div>

				</div>
				<div class="panel-footer">
					<?php
					if(mysqli_num_rows($sql) > 0){
						echo "
							<center>
								<a class='btn btn-success' href='Cetak_Laporan_Potongan.php?Bulan=$bulan&Tahun=$tahun' target='_blank'>Cetak Laporan Potongan</a>
							</center>
						";
					}
					?>
				</div>
			</div>
		</div>
		<?php	
		
		break;
	}

	?>

</div>
<?php include "Footer.php" ?>