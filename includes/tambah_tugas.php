<?php 

    require '../Database/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_tugas'])) {
        $taskTitle = $_POST['judul'];
        $taskDesc = $_POST['deskripsi'];

        $insertTaskQuery = $connect->prepare("INSERT INTO Tugas (Tugas, Deskripsi) VALUES (?, ?)");
        $insertTaskQuery->bind_param('ss', $taskTitle, $taskDesc);
        $executeInsertTask = $insertTaskQuery->execute();
        $insertTaskQuery->close();

        if ($executeInsertTask) {
            $getTotalTaskQuery = $connect->prepare("SELECT total_tugas FROM statistik");
            $getTotalTaskQuery->execute();
            $getTotalTaskQuery->bind_result($totalTaskData);
            $getTotalTaskQuery->fetch();
            $getTotalTaskQuery->close();

            $updateTotalTaskQuery = $connect->prepare("UPDATE statistik SET total_tugas = ?");
            $newTotalTask = $totalTaskData + 1;
            $updateTotalTaskQuery->bind_param('i', $newTotalTask);
            $updateTotalTaskQuery->execute();
            $updateTotalTaskQuery->close();
        }

        header('location: ../index.php');
        exit();
    }
?>