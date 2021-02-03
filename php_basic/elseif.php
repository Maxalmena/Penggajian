<?php
    $a = 10;
    $b = 12;
    $c = FALSE; // boolean TRUE : FALSE

    if(!$c AND $a){
        echo "Kondisi Benar Pertama", "<br>", "<br>";
    } elseif(!$d){
        echo "Kondisi Benar Kedua", "<br>", "<br>";
    }else {
        echo "Kondisi Salah", "<br>", "<br>";
    }

    // AND | && --> Harus TRUE keduanya
    // OR | || --> Cukup salah satu yang TRUE
    
?>