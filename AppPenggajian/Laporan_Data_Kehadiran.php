<?php
include "Header.php";
?>

<div class="container">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Laporan Kehadiran Pegawai</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline" method="GET" action="Cetak_Laporan_Data_Kehadiran.php">
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

					<button type="submit" class="btn btn-primary">Cetak Data Kehadiran</button>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
include "Footer.php";
?>