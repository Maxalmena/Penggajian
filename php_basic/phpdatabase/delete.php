<?php
$id = $_GET["id"];
include_once("connection.php");
$home = 'get_data.php';
$delete = "DELETE FROM karyawan WHERE id=".$id;
$result = $conn->query($delete);
if ($result) {
    header('Location: '.$home);
} else {
    echo "error";
}
?>