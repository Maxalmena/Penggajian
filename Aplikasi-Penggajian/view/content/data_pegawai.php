<script src="assets/plugins/DataTables/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/js/dataTables.responsive.js"></script>
<script src="assets/js/table-manage-responsive.demo.min.js"></script>
<script>
$(document).ready(function() {
    TableManageResponsive.init();
});
</script>  
<?php 
    if ($_SESSION['level']=='admin'){
 ?>
<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Master</a></li>
				<li class="active">Data Pegawai</li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Data Pegawai</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
                <!-- begin col-6 -->
			    <div class="col-md-6">
			        <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">Tambah Data Pegawai</h4>
                        </div>
                        <div class="panel-body panel-form">
                            <form class="form-horizontal form-bordered" data-parsley-validate="true" name="data_pengguna" action="./model/input_pegawai.php" method="POST">
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4" >NIP :</label>
									<div class="col-md-6 col-sm-6">
										<input class="form-control" type="text" name="nip" placeholder="NIP" maxlength="15" data-parsley-required="true" data-parsley-type="number" />
									</div>
								</div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Nama Pegawai :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" name="nama_pegawai" placeholder="Nama Pegawai" data-parsley-required="true" />
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Tanggal Lahir :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="date" name="tgl_lhr" placeholder="Tanggal Lahir" data-parsley-required="true" />
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Tanggal Lahir * :</label>
                                    <div class="col-md-6 col-sm-6"> 
                                        <div class="input-group date" id="datepicker-default" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control" name="tgl_lhr" data-type="tgl_lhr" data-parsley-required="true"/>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Alamat :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea class="form-control" type="text" placeholder="Masukan Alamat" name="alamat" data-parsley-required="true"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">No. Telepon :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="text" maxlength="12" name="tlp" placeholder="No. Telepon" data-parsley-required="true" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4 col-sm-4">Jabatan :</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="id_jabatan" data-live-search="true" data-style="btn-white" class="form-control selectpicker" >
                                             <option value="1">---- Pilih Jabatan ----</option>
                                             <?php
                                            include "config/config.php";
                                             $sql = mysql_query("SELECT * FROM t_jabatan ORDER BY nama_jabatan ASC");
                                             if(mysql_num_rows($sql) != 0){
                                                 while($data = mysql_fetch_assoc($sql)){
                                                     echo '<option value='.$data['id_jabatan'].'>'.$data['nama_jabatan'].'</option>';
                                                 }
                                             }
                                             ?>
                                         </select>
                                    </div>
                                </div>
								<div class="form-group">
									<label class="control-label col-md-4 col-sm-4"></label>
									<div class="col-md-6 col-sm-6">
										<button type="submit" class="btn btn-primary btn-sm">Submit</button> <button type="resset" class="btn btn-danger btn-sm">Resset</button>
									</div>
								</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
			    <!-- begin col-12 -->
			    <div class="col-md-12">
			        <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">List Data Pegawai</h4>
                        </div>
                        <div class="panel-body">
                            
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">No</th>
                                        <th style="text-align:center">NIP</th>
                                        <th style="text-align:center">Nama Pegawai</th>
                                        <th style="text-align:center">Tangal Lahir</th>
                                        <th style="text-align:center">Alamat</th>
                                        <th style="text-align:center">No. Telepon</th>
                                        <th style="text-align:center">Jabatan</th>
                                        <th style="text-align:center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                        include "config/config.php";
                                        $halaman = "index.php?p=data_pegawai";
                                        $action = "model/hapus_pegawai.php?";
                                        $i=0;
                                        $sql=mysql_query("SELECT * FROM `t_pegawai` INNER JOIN t_jabatan ON t_pegawai.id_jabatan=t_jabatan.id_jabatan ORDER BY nama_pegawai ASC");
                                        while($data=mysql_fetch_array($sql)){
                                                $i++;
                                        ?>
                                             <tr>
                                                <td style="text-align:center"><?php echo $i . "."; ?></td>
                                                <td><?php echo $data['nip']; ?></td>
                                                <td><?php echo $data['nama_pegawai']; ?></td>
                                                <td><?php echo date("d-F-Y", strtotime($data['tgl_lhr'])); ?></td>
                                                <td><?php echo $data['alamat']; ?></td>
                                                <td><?php echo $data['tlp']; ?></td>
                                                <td><?php echo $data['nama_jabatan']; ?></td>
                                                <td align="center">
                                                    <a class="btn btn-default btn-icon btn-sm" href="index.php?p=edit_pegawai&&nip=<?php echo $data['nip']; ?>"><i class="fa fa-expand"></i></a>
                                                    <a class="btn btn-danger btn-icon btn-sm" onclick="konfirmasi('<?php echo $data['nip'];?>','<?php echo $halaman;?>','<?php echo $action;?>')"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                            <?php 
                                        }
                                    ?>
                             
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->
            </div>
                       <?php 
        }else{
            ?>
            <script type="text/javascript">
                window.location.href="halaman_error.php";
            </script>
        <?php
        }
     ?>