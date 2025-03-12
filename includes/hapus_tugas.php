<?php

require '../Database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_tugas'])) {
    $taskId = $_GET['id'];

    $deleteTaskQuery = $connect->prepare("DELETE FROM tugas WHERE ID = ?");
    $deleteTaskQuery->bind_param('i', $taskId);
    $deleteTaskQuery->execute();
    $deleteTaskQuery->close();

    header('location: ../index.php');
    exit();
}

?>
