<?php include "Header.php" ?>
<div class="container">

	<?php
	$view = isset($_GET['view']) ? $_GET['view'] : null;

	switch ($view) {
		default:
		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Data Kehadiran Pegawai</h3>
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
						<a href="Data_Kehadiran.php?view=add" class="btn btn-primary">Input Kehadiran Pegawai</a>
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

					<table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th>Jabatan</th>
							<th>Masuk</th>
							<th>Sakit</th>
							<th>Izin</th>
							<th>Alpha</th>
							<th>Lembur</th>
							<th>Potongan</th>
							<th>Pinjaman</th>
						</tr>
						<?php
						$sql = mysqli_query($connect, "SELECT master_gaji.*, pegawai.nama_pegawai, pegawai.kode_jabatan, 
								jabatan.nama_jabatan FROM master_gaji 
								INNER JOIN pegawai ON master_gaji.nip = pegawai.nip 
								INNER JOIN jabatan ON pegawai.kode_jabatan = jabatan.kode_jabatan 
								WHERE master_gaji.bulan = $bulanTahun 
								ORDER BY pegawai.nip ASC");

						$no=1;
						while($d=mysqli_fetch_array($sql)) {
							echo "<tr>
								<td>$no</td>
								<td>$d[nip]</td>
								<td>$d[nama_pegawai]</td>
								<td>$d[nama_jabatan]</td>
								<td>$d[masuk]</td>
								<td>$d[sakit]</td>
								<td>$d[izin]</td>
								<td>$d[alpha]</td>
								<td>$d[lembur]</td>
								<td>$d[total_potongan]</td>
								<td>$d[pinjaman]</td>
							</tr>";
							$no++;
						}

						if (mysqli_num_rows($sql) > 0) {
							echo "<tr>
								<td colspan='11' text-align='center'>
									<a class='btn btn-warning' href='Data_Kehadiran.php?view=edit&Bulan=$bulan&Tahun=$tahun'>
										Edit Data Kehadiran
									</a>
								</td>
							</tr>";
						}else{
							echo "<tr>
								<td colspan='11' text-align='center'>
									Tidak Ada Data yang Tersedia Pada Bulan dan Tahun yang Anda Pilih...
								</td>
							</tr>";
						}

						?>
					</table>

				</div>
			</div>
		</div>

		<?php	
			break;

		case "add":
			?>

			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Tambah Data Kehadiran Pegawai</h3>
					</div>
					<div class="panel-body">
						<form class="form-inline" method="get" action="">
							<input type="hidden" name="view" value="add">
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
							<button type="submit" class="btn btn-primary">Generate Data Kehadiran Pegawai</button>
						</form>

						<?php
							if ((isset($_GET['Tahun']) && ($_GET['Tahun']) != '') && (isset($_GET['Bulan']) && ($_GET['Bulan']) != '') ) {
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

						<form method="post" action="Delete_Kehadiran.php?act=insert">
							<table class="table">
								<tr>
									<th>No</th>
									<th>NIP</th>
									<th>Nama Pegawai</th>
									<th>Jabatan</th>
									<th>Masuk</th>
									<th>Sakit</th>
									<th>Izin</th>
									<th>Alpha</th>
									<th>Lembur</th>
									<th>Potongan</th>
									<th>Pinjaman</th>
								</tr>

								<?php
									$no=1;
									$query = mysqli_query($connect, "SELECT pegawai.*, jabatan.nama_jabatan FROM pegawai
												INNER JOIN jabatan ON pegawai.kode_jabatan = jabatan.kode_jabatan
												WHERE NOT EXISTS (SELECT * FROM master_gaji WHERE bulan='$bulanTahun' AND
													pegawai.nip = master_gaji.nip)
												ORDER BY pegawai.nip ASC");
									$jmlPegawai = mysqli_num_rows($query);
									while($d=mysqli_fetch_array($query)){
								?>
										<input type="hidden" name="Bulan[]" value="<?php echo $bulanTahun; ?>" />
										<input type="hidden" name="NIP[]" value="<?php echo $d['nip']; ?>" />
										<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $d['nip']; ?></td>
												<td><?php echo $d['nama_pegawai']; ?></td>
												<td><?php echo $d['nama_jabatan']; ?></td>
												<td>
													<input type="number" name="Masuk[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Sakit[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Izin[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Alpha[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Lembur[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Potongan[]" class="form-control"value="0" required/>
												</td>
												<td>
													<input type="number" name="Pinjaman[]" class="form-control"value="0" required/>
												</td>
											</tr>
								<?php
									$no++;
								}

								if ($jmlPegawai > 0) {
								?>	
									<tr>
										<td colspan="4"></td>
										<td colspan="7">
											<input class="btn btn-primary" type="submit" value="Save">
											<a href="Data_Kehadiran.php" class="btn btn-danger">Cancel</a>
										</td>
									</tr>
								<?php
								}else{
								?>
									<tr>
										<td colspan="11">
											<label class="label label-warning">
												Bulan dan Tahun Yang Dipilih Telah Diproses, Silahkan Melakukan Edit Data...!!!
											</label>
										</td>
									</tr>
								<?php
								}
							?>

							</table>
						</form>

					</div>
				</div>
			</div>

			<?php
			break;
		
		case 'edit':
			
			$bulan = $_GET['Bulan'];
			$tahun = $_GET['Tahun'];
			$bulanTahun = $bulan.$tahun;
			?>

			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Edit Data Kehadiran</h3>
					</div>
					<div class="panel-body">
						<div class="alert alert-info">
							<strong>Bulan : <?php echo $bulan; ?>, Tahun : <?php echo $tahun; ?> </strong>
						</div>

						<form method="post" action="Delete_Kehadiran.php?act=update">
							<table class="table">
								<tr>
									<th>No</th>
									<th>NIP</th>
									<th>Nama Pegawai</th>
									<th>Jabatan</th>
									<th>Masuk</th>
									<th>Sakit</th>
									<th>Izin</th>
									<th>Alpha</th>
									<th>Lembur</th>
									<th>Potongan</th>
									<th>Pinjaman</th>
								</tr>

								<?php
									$no=1;
									$query = mysqli_query($connect, "SELECT master_gaji.*, pegawai.nama_pegawai, jabatan.nama_jabatan 
												FROM master_gaji
												INNER JOIN pegawai ON master_gaji.nip = pegawai.nip
												INNER JOIN jabatan ON pegawai.kode_jabatan = jabatan.kode_jabatan
												WHERE master_gaji.bulan = '$bulanTahun'
												ORDER BY master_gaji.nip ASC");

									$jmlPegawai = mysqli_num_rows($query);
									while($d=mysqli_fetch_array($query)){
								?>
										<input type="hidden" name="Bulan[]" value="<?php echo $bulanTahun; ?>" />
										<input type="hidden" name="NIP[]" value="<?php echo $d['nip']; ?>" />
										<tr>
												<td><?php echo $no; ?></td>
												<td><?php echo $d['nip']; ?></td>
												<td><?php echo $d['nama_pegawai']; ?></td>
												<td><?php echo $d['nama_jabatan']; ?></td>
												<td>
													<input type="number" name="Masuk[]" class="form-control" 
													value="<?php echo $d['masuk']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Sakit[]" class="form-control" 
													value="<?php echo $d['sakit']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Izin[]" class="form-control" 
													value="<?php echo $d['izin']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Alpha[]" class="form-control" 
													value="<?php echo $d['alpha']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Lembur[]" class="form-control" 
													value="<?php echo $d['lembur']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Potongan[]" class="form-control" 
													value="<?php echo $d['potongan']; ?>" required/>
												</td>
												<td>
													<input type="number" name="Pinjaman[]" class="form-control" 
													value="<?php echo $d['pinjaman']; ?>" required/>
												</td>
											</tr>
								<?php
									$no++;
								}

								?>	
								<tr>
									<td colspan="4"></td>
									<td colspan="7">
										<input class="btn btn-primary" type="submit" value="Update">
										<a href="Data_Kehadiran.php" class="btn btn-danger">Cancel</a>
									</td>
								</tr>

							</table>
						</form>

					</div>
				</div>
			</div>

			<?php

			break;
	}

	?>

</div>
<?php include "Footer.php" ?>