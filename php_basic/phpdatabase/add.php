<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Tambah Data Karyawan</title>
    </head>
    <body>
        <H1>Tambah Data Karyawan</H1>

        <form action="#" method="post">
            Nama    :<input type="text" name="nama"><br>
            Alamat  :<input type="text" name="alamat"><br>
            Jabatan :<input type="text" name="jabatan"><br>
            <input type ="submit" value="submit">
        </form>
    </body>
</html>

<?php
    include_once("connection.php"); // mengcopy isi connection.php
    if(!empty($_POST)){
        $home = 'get_data.php';
        $nama = $_POST["nama"];
        $alamat = $_POST["alamat"];
        $jabatan = $_POST["jabatan"];

        $insert = "INSERT INTO karyawan (`nama`, `alamat`, `jabatan`) VALUES ('$nama', '$alamat', '$jabatan')";
        $result = $conn->query($insert);
        if ($result) {
            header('Location'.$home);
        }
    }
?>