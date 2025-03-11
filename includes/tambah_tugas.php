<?php 

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_tugas'])) {
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];

        $query = "INSERT INTO Tugas (Tugas, Deskripsi) VALUES ('$judul', '$deskripsi') ";
        $result = mysqli_query($connect, $query);

        if ($result) header('location: ../index.php');
        else echo "<script> alert('Terjadi kesalahan dalam proses menambah tugas, silahkan coba lagi') </script>";
    }

?>