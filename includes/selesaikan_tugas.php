<?php

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['jumlah']) && isset($_GET['values'])) {
        $id = $_GET['values'];
        $jumlah = $_GET['jumlah'];

        $hapus_tugas = "DELETE FROM Tugas WHERE ID IN ($id)";
        $result_hapus = mysqli_query($connect, $hapus_tugas);

        $hitung_tugas_selesai = "SELECT tugas_selesai FROM statistik";
        $result_hitung = mysqli_query($connect, $hitung_tugas_selesai);
        $get_hitung = mysqli_fetch_assoc($result_hitung);
        $hasil_hitung = $get_hitung['tugas_selesai'] + $jumlah;
        $update_tugas_selesai = "UPDATE statistik SET tugas_selesai = '$hasil_hitung'";
        $result_update = mysqli_query($connect, $update_tugas_selesai);

        if ($result_hapus && $result_hitung && $result_update) {
            header('location: ../index.php');
        }
    };

?>