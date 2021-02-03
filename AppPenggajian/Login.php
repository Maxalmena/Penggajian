<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Aplikasi Penggajian Koperasi Simpan Pinjam</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      body{
        background: url(assets/img/login_background.jpg) no-repeat center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover; 
        -o-background-size: cover;
        background-size: cover;
      }
      body > .container{
        margin: 250px 190px 0;
      }
    </style>

  </head>
  <body>
    <div class="container">
      <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">LOGIN APLIKASI PENGGAJIAN</h3>
          </div>
          <div class="panel-body">

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              session_start();
              $user = $_POST['username'];
              $pass = $_POST['password'];
              $p    = md5($pass);

              if ($user == '' || $pass == '') {
                ?>
                  <div class="alert alert-warning" role="alert"><b>WARNING!</b>Form anda belum lengkap</div>
                <?php
              }else{
                include "Koneksi.php";
                $sqlLogin = mysqli_query($connect, "SELECT * FROM pegawai WHERE username='$user' AND password = '$p' " );
                $d = mysqli_fetch_assoc($sqlLogin);

                if (mysqli_num_rows($sqlLogin)>0) {
                  $_SESSION['login']        = TRUE;
                  $_SESSION['role']         = $d['role'];
                  $_SESSION['id']           = $d['nip'];
                  $_SESSION['username']     = $d['username'];
                  $_SESSION['namalengkap']  = $d['nama_pegawai'];
                  
                  if ($d['role'] == "admin") {

                    header('Location:./Index.php'); 

                  }
                  elseif ($d['role'] == "pegawai") {

                    header('Location:./Index_Pegawai.php'); 

                  }
                  elseif ($d['role'] == "manager") {

                    header('Location:./Index_Manager.php'); 

                  }else{
                    ?>
                      <div class="alert alert-warning" role="alert"><b>ERROR</b>Username dan Password Salah</div>
                    <?php
                  }
                }
              }
            }
            ?>

            <form action="" method="post" role="form">
              <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username">
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-lg btn-block" value="login">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>