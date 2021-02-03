<?php include "Header_Pegawai.php" ?>
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

			<?php
				$sql = mysqli_query($connect, "SELECT pegawai.*, jabatan.nama_jabatan
					FROM pegawai 
					INNER JOIN jabatan ON pegawai.kode_jabatan=jabatan.kode_jabatan 
					WHERE username='$_SESSION[username]'");
				$d = mysqli_fetch_array($sql);
			?>

			<div class="row clearfix">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Profile Pegawai</h3>
					</div>

					<div class="panel-body">

						<table class="table table-striped">
							<tr>
								<th>NIP</th>
								<td><?=$d['nip']?></td>
							</tr>

							<tr>
								<th>Username</th>
								<td><?=$d['username']?></td>
							</tr>

							<tr>
								<th>Role</th>
								<td><?=$d['role']?></td>
							</tr>
							
							<tr>
								<th>Nama Pegawai</th>
								<td><?=$d['nama_pegawai']?></td>
							</tr>
							
							<tr>
								<th>Nama Jabatan</th>
								<td><?=$d['nama_jabatan']?></td>
							</tr>

							<tr>
								<th>Tempat Lahir</th>
								<td><?=$d['tempat_lahir']?></td>
							</tr>

							<tr>
								<th>Tanggal Lahir</th>
								<td><?=$d['tanggal_lahir']?></td>
							</tr>

							<tr>
								<th>Alamat</th>
								<td><?=$d['alamat']?></td>
							</tr>

							<tr>
								<th>No.Telepon</th>
								<td><?=$d['no_telp']?></td>
							</tr>
							
							<tr>
								<th>Action</th>
								<td>
					 				<a class='btn btn-warning btn-sm' href='Profile_Pegawai.php?view=edit&id=<?=$d['nip']?>'>
					 					Edit Profile
					 				</a>
				 				</td>
							</tr>
						</table>
					</div>

				</div>
			</div>

			<?php
			break;
		
		case "edit":
			$sqlEdit = mysqli_query($connect, "SELECT * FROM pegawai WHERE username='$_SESSION[username]'");
			$e = mysqli_fetch_array($sqlEdit);

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
					<h3 class="panel-title">Edit Profile Pegawai</h3>
				</div>
				<div class="panel-body">
					<form method="POST" action="ACTION_Pegawai.php?act=update">
						<table class="table">

							<tr>
								<td width="160px">NIP</td>
								<td>
									<input class="form-control" type="text" name="NIP" value="<?php echo $e['nip']; ?>" 
									readonly>
								</td>
							</tr>

							<tr>
								<td width="160px">Username</td>
								<td>
									<input class="form-control" type="text" name="Username" 
									value="<?php echo $e['username']; ?>" required>
								</td>
							</tr>

							<tr>
								<td width="160px">Password</td>
								<td>
									<input class="form-control" type="text" name="Password" 
									value="<?php echo $e['password']; ?>">
								</td>
							</tr>

							<tr>
								<td width="160px">Role</td>
								<td>
									<input class="form-control" type="text" name="Role" 
									value="<?php echo $e['role']; ?>" readonly>
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
									<input name="Jabatan" class="form-control" value= "
										<?php
										$sqlJabatan = mysqli_query($connect, "SELECT pegawai.*, jabatan.nama_jabatan 
											FROM pegawai 
											INNER JOIN jabatan ON pegawai.kode_jabatan=jabatan.kode_jabatan 
											WHERE username='$_SESSION[username]' ");
										while ($j=mysqli_fetch_array($sqlJabatan)) {
											$selected = ($j['kode_jabatan'] == $e['kode_jabatan']) ? 
											'selected="selected"' : "";
											echo "$j[kode_jabatan] - $j[nama_jabatan]";
										}
										?>"
										readonly>
									</input>
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
									<a class="btn btn-danger" href="Profile_Pegawai.php">Cancel</a>
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