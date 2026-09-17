<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "yamtin";


    $conexion = new mysqli($host, $user, $pass, $db);


    if($conexion){

    }else{
        echo "error en la conexion";
    }
?>