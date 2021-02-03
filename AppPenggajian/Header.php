<?php
session_start();
if (!isset($_SESSION['login'])) {
  header('location:Login.php');
}

include "Koneksi.php";
include "Fungsi.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/sticky-footer-navbar/">

    <title>Aplikasi Penggajian Koperasi Simpan Pinjam</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./">PAYROLL</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="./">Home</a></li>
            <li><a href="Data_Jabatan.php">Data Jabatan</a></li>
            <li><a href="Data_Pegawai.php">Data Pegawai</a></li>
            <li><a href="Data_Kehadiran.php">Data Kehadiran Pegawai</a></li>
            <li><a href="Data_Penggajian.php">Data Gaji Pegawai</a></li>
            <li><a href="Data_Potongan.php">Data Potongan</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Cetak_Data_Pegawai.php">Laporan Data Pegawai</a></li>
                <li><a href="Laporan_Data_Kehadiran.php">Laporan Data Kehadiran Pegawai</a></li>
                <li><a href="Cetak_Data_Lembur.php">Laporan Data Lembur Pegawai</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="Logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>