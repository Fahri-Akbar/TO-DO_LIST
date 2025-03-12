<?php 

require '../Database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_data'])) {
    $taskId = $_POST['taskId']; 
    $taskTitle = $_POST['taskTitle']; 
    $taskDesc = $_POST['taskDesc']; 

    $editTaskQuery = $connect->prepare("UPDATE tugas SET Tugas = ?, Deskripsi = ? WHERE ID = ?");
    $editTaskQuery->bind_param('ssi', $taskTitle, $taskDesc, $taskId);
    $editTaskQuery->execute();
    $editTaskQuery->close();

    header('location: ../index.php');
    exit();
}

?>
