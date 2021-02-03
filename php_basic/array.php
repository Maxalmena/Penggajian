<?php
    $array = [1, "string", false];
    $array1 = [
        ["satu", "dua", "tiga"],
        [1,2,3]
    ];

    // echo $array[1];
    // echo $array1[1][1];

    $merk_mobil = ["BMW", "TOYOTA", "NISSAN"];
    // untuk munculkan 1 1 isis array
    echo $merk_mobil [0], "<br>";
    echo $merk_mobil [1], "<br>";
    echo $merk_mobil [2], "<br>";

    // munculkan isi array dengan cara looping
    $panjang_array = count($merk_mobil);
    echo "panjang array = ", $panjang_array, "<br>";

    for ($i=0; $i < $panjang_array; $i++) {
        echo $merk_mobil[$i]; // fungsi [$i] dipakai untuk petunjuk alamat array
        echo "<br>";
    }

    // $a = 0;
    // while ($a = < panjang_array) {
    //     echo $merk_mobil[$a];
    //     echo "<br>";
    //     $a++
    // }
?>