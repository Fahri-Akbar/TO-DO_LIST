<?php

    require '../Database/koneksi.php';

    if (isset($_GET['id']) && isset($_GET['status'])) {
        $id = $_GET['id'];
        $status = $_GET['status'];

        $query = "UPDATE Tugas SET is_pin = '$status' WHERE ID = '$id' ";
        mysqli_query($connect, $query);
    }

?>