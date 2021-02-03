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
					<h3 class="panel-title">Gaji Pegawai</h3>
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
								<th>Nama</th>
								<th>Jabatan</th>
								<th>Alamat</th>
								<th>Gaji Pokok</th>
								<th>Uang Kehadiran</th>
								<th>Uang Makan</th>
								<th>Uang Transport</th>
								<th>Uang Pulsa</th>
								<th>Uang Lembur</th>
								<th>Tunjangan Simpanan Berencana</th>
								<th>Tunjangan Service Kendaraan</th>
								<th>Insentive Pinjaman</th>
								<th>Insentive Simpanan Berjangka</th>
								<th>Bonus Tahunan</th>
								<th>THR</th>
								<th>Tunj BPJS Kesehatan</th>
								<th>Tunj BPJS Ketenagakerjaan</th>
								<th>Tunj BPJS Jaminan Kematian</th>
								<th>Tunj BPJS Kecelakaan Kerja</th>
								<th>Bonus/Tunjangan Lain-Lain</th>
								<th>Gaji Bersih</th>
								<th>Potongan</th>
								<th>Pinjaman</th>
								<th>Total Gaji</th>
							</tr>
						</thead>
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
								echo "<tr>
									<td width='40px' align='center'>$no</td>
									<td>$d[nip]</td>
									<td>$d[nama_pegawai]</td>
									<td>$d[nama_jabatan]</td>
									<td>$d[alamat]</td>
									<td>".Rp($d['gaji_pokok'])."</td>
									<td>".Rp($d['uangkehadiran'])."</td>
									<td>".Rp($d['uangmakan'])."</td>
									<td>".Rp($d['uangtransport'])."</td>
									<td>".Rp($d['uangpulsa'])."</td>
									<td>".Rp($d['uanglembur'])."</td>
									<td>".Rp($d['tunjangansimpanan'])."</td>
									<td>".Rp($d['tunjanganservis'])."</td>
									<td>".Rp($d['insentivepinjaman'])."</td>
									<td>".Rp($d['insentivesimpanan'])."</td>
									<td>".Rp($d['bonustahunan'])."</td>
									<td>".Rp($d['thr'])."</td>
									<td>".Rp($d['bpjskes'])."</td>
									<td>".Rp($d['bpjsket'])."</td>
									<td>".Rp($d['bpjsjk'])."</td>
									<td>".Rp($d['bpjskk'])."</td>
									<td>".Rp($d['bonustunjanganlain'])."</td>
									<td>".Rp($d['gajibersih'])."</td>
									<td>".Rp($d['total_potongan'])."</td>
									<td>".Rp($d['pinjaman'])."</td>
									<td>".Rp($d['totalgaji'])."</td>
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
					if(mysqli_num_rows($sql) > 0) {
						echo "
							<center>
								<a class='btn btn-success' href='Cetak_Gaji_Pegawai.php?Bulan=$bulan&Tahun=$tahun' 
								target='_blank'><span class='glypicon glypicon-print'></span>Cetak Gaji Pegawai</a>

								<a class='btn btn-warning' href='Excel_Gaji_Pegawai.php?Bulan=$bulan&Tahun=$tahun' 
								target='_blank'><span class='glypicon glypicon-print'></span>Export Gaji Pegawai</a>								
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