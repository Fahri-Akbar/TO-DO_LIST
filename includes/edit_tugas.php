<?php 

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_data'])) {
        $id = $_POST['taskId'];
        $title = $_POST['taskTitle'];
        $desc = $_POST['taskDesc'];

        $query = "UPDATE Tugas SET Tugas = '$title', Deskripsi = '$desc' WHERE ID = '$id' ";
        $result = mysqli_query($connect, $query);

        if ($result) header('location: ../index.php');
        else echo "<script> alert('Terjadi kesalahan dalam proses mengedit tugas, silahkan coba lagi') </script>";
    }
?>