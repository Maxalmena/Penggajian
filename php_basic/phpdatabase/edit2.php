<?php
    $id = $_GET["id"];
    // echo $id;
    include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit 1</title>
</head>
<body>
    <H1>Edit Data Karyawan</H1>
    <form action="#" method="post">
    <?php
        $get = "SELECT id, nama, alamat, jabatan FROM karyawan WHERE id=".$id;
        $get_data = $conn->query($get);
        while ($row = $get_data->fetch_assoc()) {
            // echo $row["nama"]."".$row["alamat"];
            echo "<input type='hidden' name='id' value=".$row["id"].">";
            echo "Nama  :<input type='text' name='nama' value=".$row["nama"]."><br>";
            echo "Alamat  :<input type='text' name='alamat' value=".$row["alamat"]."><br>";
            echo "Jabatan  :<input type='text' name='jabatan' value=".$row["jabatan"]."><br>";
        }
    ?><input type ="submit" value="submit">
    </form>
</body>
</html>

<?php
if (!empty($_POST)){
  $home = 'get_data.php';
  $nama = $_POST["nama"];
  $alamat = $_POST["alamat"];
  $jabatan = $_POST["jabatan"];
  $update = "UPDATE karyawan SET `nama`='$nama',
  `alamat`='$alamat',`jabatan`='$jabatan'
  WHERE id =".$_POST["id"];
  $result = $conn->query($update);
  if ($result) {
    header('Location: '.$home);
  } else {
    echo $conn->error;
  }
}
?>