<!DOCType html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PHP DATABASE</title>
    </head>

    <body>
        <H1>PHP BASIC DATABASE</H1>
        <a href="add.php">Tambah Data</a>
        <br><br>
        <?php
            include_once("connection.php");
            $sql = "SELECT id, nama, alamat, jabatan FROM karyawan";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row= $result->fetch_assoc()) {
                    echo
                    "id: ".$row["id"]
                    ." Nama: " . $row["nama"]." "
                    .$row["alamat"]." "
                    .$row["jabatan"]
                    ." <a href='edit.php?id=".$row["id"]."'>EDIT</a>"
                    ." | "
                    ."<a href='delete.php?id=".$row["id"]."'>DELETE</a> "
                    ."<br>";
                }
            }
        ?>
    </body>
</html>