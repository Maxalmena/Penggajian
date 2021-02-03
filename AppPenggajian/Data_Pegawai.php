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
						<h3 class="panel-title">Data Pegawai</h3>
					</div>

					<div class="panel-body">

						<a href="Data_Pegawai.php?view=add" style="margin-bottom:10px" class="btn btn-primary">
							Add Pegawai
						</a>

						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>No</th>
								<th>NIP</th>
								<th>Username</th>
								<th>Role</th>
								<th>Nama Pegawai</th>
								<th>Jabatan</th>
								<th>Tempat Lahir</th>
								<th>Tanggal Lahir</th>
								<th>Alamat</th>
								<th>No. Telp.</th>
								<th>Action</th>
							</tr>
							<?php
							$sql = mysqli_query($connect, "SELECT pegawai.*, jabatan.nama_jabatan
								 FROM pegawai 
								 INNER JOIN jabatan ON pegawai.kode_jabatan=jabatan.kode_jabatan 
								 ORDER BY pegawai.nama_pegawai ASC");
							$no = 1;
							while ($d = mysqli_fetch_array($sql) ) {
								echo "<tr>
									<td width='40px' align='center'>$no</td>
									<td>$d[nip]</td>
									<td>$d[username]</td>
									<td>$d[role]</td>
									<td>$d[nama_pegawai]</td>
									<td>$d[nama_jabatan]</td>
									<td>$d[tempat_lahir]</td>
									<td>$d[tanggal_lahir]</td>
									<td>$d[alamat]</td>
									<td>$d[no_telp]</td>
									<td width='160px' align='center'>
										<a class='btn btn-warning btn-sm' href='Data_Pegawai.php?view=edit&id=
										$d[nip]'>Edit</a>
										<a class='btn btn-danger btn-sm' href='Delete_Pegawai.php?act=delete&id=
										$d[nip]'>Delete</a>
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
			//MEMBUAT KODE GOLONGAN OTOMATIS
			// $symbol = "P";
			// $query = mysqli_query($connect, "SELECT max(kode_golongan) AS last FROM golongan WHERE kode_golongan LIKE 
			// 	'$symbol%'");
			// $data = mysqli_fetch_array($query);
			// $lastCode = $data['last'];
			// $lastNumber = substr($lastCode, 1, 2);
			// $nextNumber = $lastNumber + 1;
			// $nextCode = $symbol.sprintf('%02s', $nextNumber);
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
						<h3 class="panel-title">Add Data Pegawai</h3>
					</div>

					<div class="panel-body">
						<form method="POST" action="Delete_Pegawai.php?act=insert">
							<table class="table">

								<tr>
									<td width="160px">NIP</td>
									<td>
										<input class="form-control" type="text" name="NIP" readonly>
									</td>
								</tr>

								<tr>
									<td width="160px">Username</td>
									<td>
										<input class="form-control" type="text" name="Username" required>
									</td>
								</tr>

								<tr>
									<td width="160px">Password</td>
									<td>
										<input class="form-control" type="password" name="Password" required>
									</td>
								</tr>

								<tr>
									<td width="160px">Role</td>
									<td>
										<select name="Role" class="form-control">
											<option value=''>- Pilih -</option>
											<?php
											$sqlRole = mysqli_query($connect, "SELECT * FROM pegawai ORDER BY 
												role ASC");
											while ($j=mysqli_fetch_array($sqlRole)) {
												echo "<option value='$j[role]'> $j[role] </option>";
											}
											?>
										</select>
									</td>
								</tr>

								<tr>
									<td>Nama Pegawai</td>
									<td>
										<input class="form-control" type="text" name="NamaPegawai" required>
									</td>
								</tr>

								<tr>
									<td>Jabatan</td>
									<td>
										<select name="Jabatan" class="form-control">
											<option value=''>- Pilih -</option>
											<?php
											$sqlJabatan = mysqli_query($connect, "SELECT * FROM jabatan ORDER BY 
												kode_jabatan ASC");
											while ($j=mysqli_fetch_array($sqlJabatan)) {
												echo "<option value='$j[kode_jabatan]'>$j[kode_jabatan] - $j[nama_jabatan]
												</option>";
											}
											?>
										</select>
									</td>
								</tr>

								<tr>
									<td width="160px">Tempat Lahir</td>
									<td>
										<input class="form-control" type="text" name="TempatLahir">
									</td>
								</tr>

								<tr>
									<td width="160px">Tanggal Lahir</td>
									<td>
										<input class="form-control" type="text" name="TanggalLahir">
									</td>
								</tr>

								<tr>
									<td width="160px">Alamat</td>
									<td>
										<input class="form-control" type="text" name="Alamat">
									</td>
								</tr>

								<tr>
									<td width="160px">No Telp</td>
									<td>
										<input class="form-control" type="text" name="NoTelp">
									</td>
								</tr>

								<tr>
									<td></td>
									<td>
										<input type="submit" class="btn btn-primary" value="Save">
										<a class="btn btn-danger" href="Data_Pegawai.php">Cancel</a>
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
			$sqlEdit = mysqli_query($connect, "SELECT * FROM pegawai WHERE nip='$_GET[id]'");
			$e = mysqli_fetch_array($sqlEdit);

		?>

		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Edit Data Pegawai</h3>
				</div>
				<div class="panel-body">
					<form method="POST" action="Delete_Pegawai.php?act=update">
						<table class="table">

							<tr>
								<td width="160px">NIP</td>
								<td>
									<input class="form-control" type="text" name="NIP" 
									value="<?php echo $e['nip']; ?>" readonly>
								</td>
							</tr>

							<tr>
								<td width="160px">Username</td>
								<td>
									<input class="form-control" type="text" name="Username" 
									value="<?php echo $e['username']; var_dump($e['username']); ?>" required>
								</td>
							</tr>

							<tr>
								<td width="160px">Password</td>
								<td>
									<input class="form-control" type="password" name="Password" 
									value="<?php echo $e['password']; var_dump($e['password']); ?>">
								</td>
							</tr>

							<tr>
								<td width="160px">Role</td>
								<td><!-- 
									<input class="form-control" type="text" name="Role" 
									value="<?php echo $e['role']; ?>" required> -->
									<select name="Role" class="form-control">
										<option value=''>- Pilih -</option>
										<?php
										$sqlRole = mysqli_query($connect, "SELECT * FROM pegawai ORDER BY 
											role ASC");
										while ($j=mysqli_fetch_array($sqlRole)) {
											$selected = ($j['role'] == $e['role']) ? 
											'selected="selected"' : "";

											echo "<option value='$j[role]' $selected> $j[role] </option>";
										}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td>Nama Pegawai</td>
								<td>
									<input class="form-control" type="text" name="NamaPegawai" 
									value="<?php echo $e['nama_pegawai']; ?>" required>
								</td>
							</tr>

							<tr>
								<td>Jabatan</td>
								<td>
									<select name="Jabatan" class="form-control">
										<option value=''>- Pilih -</option>
										<?php
										$sqlJabatan = mysqli_query($connect, "SELECT * FROM jabatan ORDER BY 
											kode_jabatan ASC");
										while ($j=mysqli_fetch_array($sqlJabatan)) {
											$selected = ($j['kode_jabatan'] == $e['kode_jabatan']) ? 
											'selected="selected"' : "";

											echo "<option value='$j[kode_jabatan]' $selected>
											$j[kode_jabatan] - $j[nama_jabatan] </option>";
										}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td width="160px">Tempat Lahir</td>
								<td>
									<input class="form-control" type="text" name="TempatLahir" 
									value="<?php echo $e['tempat_lahir']; ?>">
								</td>
							</tr>

							<tr>
								<td width="160px">Tanggal Lahir</td>
								<td>
									<input class="form-control" type="text" name="TanggalLahir" 
									value="<?php echo $e['tanggal_lahir']; ?>">
								</td>
							</tr>

							<tr>
								<td width="160px">Alamat</td>
								<td>
									<input class="form-control" type="text" name="Alamat" 
									value="<?php echo $e['alamat']; ?>">
								</td>
							</tr>

							<tr>
								<td width="160px">No Telp</td>
								<td>
									<input class="form-control" type="text" name="NoTelp" 
									value="<?php echo $e['no_telp']; ?>">
								</td>
							</tr>

							<tr>
								<td></td>
								<td>
									<input type="submit" class="btn btn-primary" value="Update">
									<a class="btn btn-danger" href="Data_Pegawai.php">Cancel</a>
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