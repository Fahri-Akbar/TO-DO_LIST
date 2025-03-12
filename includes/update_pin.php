<?php

require '../Database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['status'])) {
    $pinId = $_GET['id'];
    $isPinned = $_GET['status'];

    $updatePinStatusQuery = $connect->prepare("UPDATE tugas SET is_pin = ? WHERE ID = ?");
    $updatePinStatusQuery->bind_param('ii', $isPinned, $pinId);
    $updatePinStatusQuery->execute();
    $updatePinStatusQuery->close();

    header('location: ../index.php');
    exit();
}

?>
