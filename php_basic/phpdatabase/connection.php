<?php
    $servername = "localhost";
    $username = "root";
    $password = ""; // jika belum ada di set kosong saja
    $dbname = "php_basic";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname); 

    // check connection
    if($conn->connect_error) {
        die("Connection Failed : ". $conn->connect_error);
    }else {
        echo "Connected Successfully";
    }
?>