<?php 

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_tugas'])) {
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];

        $query = "INSERT INTO Tugas (Tugas, Deskripsi) VALUES ('$judul', '$deskripsi') ";
        $result = mysqli_query($connect, $query);

        if ($result) header('location: ../index.php');
        else echo "<script> alert('Terjadi kesalahan dalam proses menambah tugas, silahkan coba lagi') </script>";

        $total_tugas = "SELECT total_tugas FROM statistik";
        $get_total_tugas = mysqli_fetch_array(mysqli_query($connect, $total_tugas));
        $total_baru = $get_total_tugas['total_tugas'] + 1;
        $perbarui_total = "UPDATE statistik SET total_tugas = '$total_baru' ";
        mysqli_query($connect, $perbarui_total);
    }

?>