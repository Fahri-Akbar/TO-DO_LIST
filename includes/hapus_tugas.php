<?php

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_tugas'])) {
        $id = $_GET['id'];

        $query = "DELETE FROM Tugas WHERE ID = $id";
        $result = mysqli_query($connect, $query);

        if ($result) header('location: ../index.php');
        else echo "<script> alert('Terjadi kesalahan dalam proses menghapus tugas, silahkan coba lagi') </script>";
    }

?>