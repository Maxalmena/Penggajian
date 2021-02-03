<?php include "Header.php" ?>
<div class="container">

	<?php
	$view = isset($_GET['view'])  ? $_GET['view'] : null;

	switch ($view) {
		default:
			//Jika ingin menulis script HTML, tutup dahulu php nya
			?>

			<!-- MENAMPILKAN MESSAGE -->
			<?php
			if (isset($_GET['e']) && $_GET['e'] == 'success') {
			?>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						 	<strong>CONGRATULATION!!!</strong> Proses Berhasil.
						</div>
					</div>
				</div>
			<?php	
			}elseif (isset($_GET['e']) && $_GET['e'] == 'fail') {
			?>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						 	<strong>ERROR!!!</strong> Proses Gagal...
						</div>
					</div>
				</div>
			<?php
			}
			?>

			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Data Jabatan</h3>
					</div>

					<div class="panel-body">

						<a href="Data_Jabatan.php?view=add" style="margin-bottom:10px" class="btn btn-primary">
							Add Jabatan
						</a>

						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>No</th>
								<th>Kode Jabatan</th>
								<th>Nama Jabatan</th>
								<th>Gaji Pokok</th>
								<th>Uang Kehadiran</th>
								<th>Uang Makan</th>
								<th>Uang Transport</th>
								<th>Uang Pulsa</th>
								<th>Uang Lembur</th>
								<th>Tunjangan Simpanan Berencana</th>
								<th>Tunjangan Servis Kendaraan</th>
								<th>Intensive Pinjaman</th>
								<th>Intensive Simpanan Berjangka</th>
								<th>Bonus Tahunan</th>
								<th>THR</th>
								<th>Tunjangan BPJS Kesehatan</th>
								<th>Tunjangan BPJS Ketenagakerjaan</th>
								<th>Tunjangan BPJS Jaminan Kematian</th>
								<th>Tunjangan BPJS Kecelakaan Kerja</th>
								<th>Bonus/Tunjangan Lain-Lain</th>
								<th>Action</th>
							</tr>
							<?php
							$sql = mysqli_query($connect, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
							$no = 1;
							while ($d = mysqli_fetch_array($sql)) {
								echo "<tr>

									<td width='40px' align='center'>$no</td>
									<td>$d[kode_jabatan]</td>
									<td>$d[nama_jabatan]</td>
									<td>$d[gaji_pokok]</td>
									<td>$d[uang_kehadiran]</td>
									<td>$d[uang_makan]</td>
									<td>$d[uang_transport]</td>
									<td>$d[uang_pulsa]</td>
									<td>$d[uang_lembur]</td>
									<td>$d[tunjangan_simpanan_berencana]</td>
									<td>$d[tunjangan_servis_kendaraan]</td>
									<td>$d[insentive_pinjaman]</td>
									<td>$d[insentive_simpanan]</td>
									<td>$d[bonus_tahunan]</td>
									<td>$d[thr]</td>
									<td>$d[tunjangan_bpjs_kesehatan]</td>
									<td>$d[tunjangan_bpjs_ketenagakerjaan]</td>
									<td>$d[tunjangan_bpjs_jaminan_kematian]</td>
									<td>$d[tunjangan_bpjs_kecelakaan_kerja]</td>
									<td>$d[bonus_tunjangan_lain]</td>
									<td width='160px' align='center'>
										<a class='btn btn-warning btn-sm' href='Data_Jabatan.php?view=edit&
										id=$d[kode_jabatan]'>Edit</a>
										<a class='btn btn-danger btn-sm' href='Delete_Jabatan.php?act=delete&
										id=$d[kode_jabatan]'>Delete</a>
									</td>
								</tr>";
								$no++;
							}
							?>
						</table>
						</div>
					</div>

				</div>
			</div>

			<?php
			break;

		case "add":
			//MEMBUAT KODE JABATAN OTOMATIS
			$symbol = "D";
			$query = mysqli_query($connect, "SELECT max(kode_jabatan) AS last FROM jabatan WHERE kode_jabatan LIKE 
				'$symbol%'");
			$data = mysqli_fetch_array($query);
			$lastCode = $data['last'];
			$lastNumber = substr($lastCode, 1, 2);
			$nextNumber = $lastNumber + 1;
			$nextCode = $symbol.sprintf('%02s', $nextNumber);
		?>
			<?php
			if (isset($_GET['e']) && $_GET['e'] == 'belumlengkap') {
			?>
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						 	<strong>WARNING!!!</strong> Form Belum Lengkap...
						</div>
					</div>
				</div>
			<?php	
			}
			?>

			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Add Data Jabatan</h3>
					</div>

					<div class="panel-body">
						<form method="POST" action="Delete_Jabatan.php?act=insert">
							<table class="table">
								<tr>
									<td width="160px">Kode Jabatan</td>
									<td>
										<input class="form-control" type="text" name="KodeJabatan" value="<?php 
										echo $nextCode; ?>" readonly>
									</td>
								</tr>

								<tr>
									<td>Nama Jabatan</td>
									<td>
										<input class="form-control" type="text" name="NamaJabatan" required>
									</td>
								</tr>

								<tr>
									<td>Gaji Pokok</td>
									<td>
										<input class="form-control" type="number" name="GajiPokok" required>
									</td>
								</tr>

								<tr>
									<td>Uang Kehadiran</td>
									<td>
										<input class="form-control" type="number" name="UangKehadiran">
									</td>
								</tr>

								<tr>
									<td>Uang Makan</td>
									<td>
										<input class="form-control" type="number" name="UangMakan">
									</td>
								</tr>

								<tr>
									<td>Uang Transport</td>
									<td>
										<input class="form-control" type="number" name="UangTransport">
									</td>
								</tr>

								<tr>
									<td>Uang Pulsa</td>
									<td>
										<input class="form-control" type="number" name="UangPulsa">
									</td>
								</tr>

								<tr>
									<td>Uang Lembur</td>
									<td>
										<input class="form-control" type="number" name="UangLembur">
									</td>
								</tr>

								<tr>
									<td>Tunjangan Simpanan Berencana</td>
									<td>
										<input class="form-control" type="number" name="TunjanganSimpananBerencana">
									</td>
								</tr>

								<tr>
									<td>Tunjangan Service Kendaraan</td>
									<td>
										<input class="form-control" type="number" name="TunjanganServiceKendaraan">
									</td>
								</tr>

								<tr>
									<td>Insentive Pinjaman</td>
									<td>
										<input class="form-control" type="number" name="InsentivePinjaman">
									</td>
								</tr>

								<tr>
									<td>Insentive Simpanan Berjangka</td>
									<td>
										<input class="form-control" type="number" name="InsentiveSimpanan">
									</td>
								</tr>

								<tr>
									<td>Bonus Tahunan</td>
									<td>
										<input class="form-control" type="number" name="BonusTahunan">
									</td>
								</tr>

								<tr>
									<td>THR</td>
									<td>
										<input class="form-control" type="number" name="THR">
									</td>
								</tr>

								<tr>
									<td>Tunjangan BPJS Kesehatan</td>
									<td>
										<input class="form-control" type="number" name="TunjanganBPJSKesehatan">
									</td>
								</tr>

								<tr>
									<td>Tunjangan BPJS Ketenagakerjaan</td>
									<td>
										<input class="form-control" type="number" name="TunjanganBPJSKetenagakerjaan">
									</td>
								</tr>

								<tr>
									<td>Tunjangan BPJS Jaminan Kematian</td>
									<td>
										<input class="form-control" type="number" name="TunjanganBPJSJaminanKematian">
									</td>
								</tr>

								<tr>
									<td>Tunjangan BPJS Kecelakaan Kerja</td>
									<td>
										<input class="form-control" type="number" name="TunjanganBPJSKecelakaanKerja">
									</td>
								</tr>

								<tr>
									<td>Bonus/Tunjangan Lain-Lain</td>
									<td>
										<input class="form-control" type="number" name="BonusTunjanganLain">
									</td>
								</tr>
								
								<tr>
									<td></td>
									<td>
										<input type="submit" class="btn btn-primary" value="Save">
										<a class="btn btn-danger" href="Data_Jabatan.php">Cancel</a>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>

		<?php
			break;
		
		case "edit":
			$sqlEdit = mysqli_query($connect, "SELECT * FROM jabatan WHERE kode_jabatan='$_GET[id]'");
			$e = mysqli_fetch_array($sqlEdit);

		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Data Jabatan</h3>
				</div>
				<div class="panel-body">
					<form method="POST" action="Delete_Jabatan.php?act=update">
						<table class="table">

							<tr>
								<td width="160px">Kode Jabatan</td>
								<td>
									<input class="form-control" type="text" name="KodeJabatan" 
									value="<?php echo $e['kode_jabatan']; ?>" readonly>
								</td>
							</tr>

							<tr>
								<td>Nama Jabatan</td>
								<td>
									<input class="form-control" type="text" name="NamaJabatan" 
									value="<?php echo $e['nama_jabatan']; ?>" required>
								</td>
							</tr>

							<tr>
								<td>Gaji Pokok</td>
								<td>
									<input class="form-control" type="number" name="GajiPokok" 
									value="<?php echo $e['gaji_pokok']; ?>" required>
								</td>
							</tr>

							<tr>
								<td>Uang Kehadiran</td>
								<td>
									<input class="form-control" type="number" name="UangKehadiran" 
									value="<?php echo $e['uang_kehadiran']; ?>">
								</td>
							</tr>

							<tr>
								<td>Uang Makan</td>
								<td>
									<input class="form-control" type="number" name="UangMakan" 
									value="<?php echo $e['uang_makan']; ?>">
								</td>
							</tr>

							<tr>
								<td>Uang Transport</td>
								<td>
									<input class="form-control" type="number" name="UangTransport" 
									value="<?php echo $e['uang_transport']; ?>">
								</td>
							</tr>

							<tr>
								<td>Uang Pulsa</td>
								<td>
									<input class="form-control" type="number" name="UangPulsa" 
									value="<?php echo $e['uang_pulsa']; ?>">
								</td>
							</tr>

							<tr>
								<td>Uang Lembur</td>
								<td>
									<input class="form-control" type="number" name="UangLembur" 
									value="<?php echo $e['uang_lembur']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan Simpanan Berencana</td>
								<td>
									<input class="form-control" type="number" name="TunjanganSimpananBerencana" 
									value="<?php echo $e['tunjangan_simpanan_berencana']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan Service Kendaraan</td>
								<td>
									<input class="form-control" type="number" name="TunjanganServiceKendaraan" 
									value="<?php echo $e['tunjangan_servis_kendaraan']; ?>">
								</td>
							</tr>

							<tr>
								<td>Insentive Pinjaman</td>
								<td>
									<input class="form-control" type="number" name="InsentivePinjaman" 
									value="<?php echo $e['insentive_pinjaman']; ?>">
								</td>
							</tr>

							<tr>
								<td>Insentive Simpanan Berjangka</td>
								<td>
									<input class="form-control" type="number" name="InsentiveSimpanan" 
									value="<?php echo $e['insentive_simpanan']; ?>">
								</td>
							</tr>

							<tr>
								<td>Bonus Tahunan</td>
								<td>
									<input class="form-control" type="number" name="BonusTahunan" 
									value="<?php echo $e['bonus_tahunan']; ?>">
								</td>
							</tr>

							<tr>
								<td>THR</td>
								<td>
									<input class="form-control" type="number" name="THR" 
									value="<?php echo $e['thr']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan BPJS Kesehatan</td>
								<td>
									<input class="form-control" type="number" name="TunjanganBPJSKesehatan" 
									value="<?php echo $e['tunjangan_bpjs_kesehatan']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan BPJS Ketenagakerjaan</td>
								<td>
									<input class="form-control" type="number" name="TunjanganBPJSKetenagakerjaan" 
									value="<?php echo $e['tunjangan_bpjs_ketenagakerjaan']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan BPJS Jaminan Kematian</td>
								<td>
									<input class="form-control" type="number" name="TunjanganBPJSJaminanKematian" 
									value="<?php echo $e['tunjangan_bpjs_jaminan_kematian']; ?>">
								</td>
							</tr>

							<tr>
								<td>Tunjangan BPJS Kecelakaan Kerja</td>
								<td>
									<input class="form-control" type="number" name="TunjanganBPJSKecelakaanKerja" 
									value="<?php echo $e['tunjangan_bpjs_kecelakaan_kerja']; ?>">
								</td>
							</tr>

							<tr>
								<td>Bonus/Tunjangan Lain-Lain</td>
								<td>
									<input class="form-control" type="number" name="BonusTunjanganLain" 
									value="<?php echo $e['bonus_tunjangan_lain']; ?>">
								</td>
							</tr>

							<tr>
								<td></td>
								<td>
									<input type="submit" class="btn btn-primary" value="Update Data">
									<a class="btn btn-danger" href="Data_Jabatan.php">Cancel</a>
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