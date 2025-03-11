<?php

    $host = 'localhost';
    $database = 'db_todo';
    $username = 'root';
    $password = '';

    $connect = mysqli_connect($host, $username, $password, $database);

    if(!$connect) die('Koneksi Gagal' . mysqli_connect_error());

?>