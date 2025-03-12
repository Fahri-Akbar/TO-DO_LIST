<?php

require '../Database/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['jumlah']) && isset($_GET['values'])) {
    $idTaskList = $_GET['values'];
    $taskTotal = $_GET['jumlah'];

    $idTaskArray = explode(',', $idTaskList);
    $idTaskArray = array_filter($idTaskArray, function($value) {
        return is_numeric($value);
    });

    if (!empty($idTaskArray)) {
        $idTaskFinal = implode(',', $idTaskArray);

        $deleteTasksQuery = "DELETE FROM Tugas WHERE ID IN ($idTaskFinal)";
        $resultDeleteTasks = mysqli_query($connect, $deleteTasksQuery);

        // UPDATE TOTAL FINISHED TASKS
        if ($resultDeleteTasks) {
            $getFinishedTaskQuery = $connect->prepare("SELECT tugas_selesai FROM statistik");
            $getFinishedTaskQuery->execute();
            $getFinishedTaskQuery->bind_result($totalFinishedTask);
            $getFinishedTaskQuery->fetch();
            $getFinishedTaskQuery->close();

            $updateFinishedTask = $connect->prepare("UPDATE statistik SET tugas_selesai = ?");
            $totalFinishedTaskNow = $totalFinishedTask + $taskTotal;
            $updateFinishedTask->bind_param('i', $totalFinishedTaskNow);
            $updateFinishedTask->execute();
            $updateFinishedTask->close();
        } else {
            echo mysqli_error($connect);
        }

        header('location: ../index.php');
        exit();
    }

    // DELETE TASK

    // // DELETE FINISH TASK
    // $deleteTasksQuery = "DELETE FROM Tugas WHERE ID IN ($taskList)";
    // $deleteTasksResult = mysqli_query($connect, $deleteTasksQuery);

    // // UPDATE TOTAL FINISHED TASK
    // $getFinishedTaskQuery = "SELECT tugas_selesai FROM statistik";
    // $getFinishedTaskResult = mysqli_query($connect, $getFinishedTaskQuery);
    // $finishedTaskData = mysqli_fetch_assoc($getFinishedTaskResult);
    // $newFinishedTask = $finishedTaskData['tugas_selesai'] + $taskTotal;
    // $updateFinishedTaskQuery = "UPDATE statistik SET tugas_selesai = '$newFinishedTask'";
    // $updateFinishedTaskResult = mysqli_query($connect, $updateFinishedTaskQuery);

    // if ($deleteTasksResult && $getFinishedTaskResult && $updateFinishedTaskResult) {
    //     header('location: ../index.php');
    // }
};

?>
