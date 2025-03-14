<?php
    require 'Database/koneksi.php';

    $querySelectTasks = "SELECT * FROM tugas";
    $getTasks = mysqli_query($connect, $querySelectTasks);

    
    $queryCountTotalTasks = "SELECT COUNT(*) as total FROM Tugas";
    $resultCountTotalTasks = mysqli_query($connect, $queryCountTotalTasks);
    $fetchTotalTasks = mysqli_fetch_assoc($resultCountTotalTasks);
    $totalTasks = $fetchTotalTasks['total'];
    
    $updateTotalTasksQuery = "UPDATE statistik SET tugas_saat_ini = '$totalTasks'";
    mysqli_query($connect, $updateTotalTasksQuery);
    
    $querySelectStatistics = "SELECT * FROM statistik";
    $getStatistics = mysqli_query($connect, $querySelectStatistics);
?>

<script>

    const toggleViewTaskModal = (id = '', title = '', desc = '') => {
        const viewTaskModal = document.getElementById('viewTask')
        const taskTitle = document.getElementById('taskTitle')
        const taskDesc = document.getElementById('taskDesc')
        const taskId = document.getElementById('taskId')

        taskTitle.value = title
        taskDesc.value = desc
        taskId.value = id

        viewTaskModal.classList.toggle('hidden')
    }

    const toggleAddTaskModal = () => {
        const addTaskModal = document.getElementById('addTask')
        const judul = document.getElementById('judul')
        const deskripsi = document.getElementById('deskripsi')

        judul.value = ''
        deskripsi.value = ''

        addTaskModal.classList.toggle('hidden')
    }

    const toggleEditMode = () => {
        const isChecked = document.getElementById('editMode').checked
        const inputTitle = document.getElementById('taskTitle')
        const inputDesc = document.getElementById('taskDesc')
        const btnEdit = document.getElementById('btnEdit')

        if (isChecked) {
            inputTitle.removeAttribute('readonly')
            inputDesc.removeAttribute('readonly')
            btnEdit.removeAttribute('disabled')
        } else{
            inputTitle.setAttribute('readonly', true)
            inputDesc.setAttribute('readonly', true)
            btnEdit.setAttribute('disabled', true)
        }
    }

    const handlePinTask = (id, status) => {
        const newStatus = status === 1 ? 0 : 1
        
        fetch(`includes/update_pin.php?id=${id}&status=${newStatus}`, {
            method: 'GET'
        })
        .then (result => {
            location.reload()
        })
        .catch (error => console.log('Terjadi Kesalahan Dalam Proses Pin Tugas: ', error))
    }

    let finishTask = []
    const handleAddFinishTask = (checkbox) => {
        const val = parseInt(checkbox.value)

        if (checkbox.checked) {
            if (!finishTask.includes(val)) {
                finishTask.push(val)
            }
        } else {
            finishTask = finishTask.filter(prev => prev !== val)
        }
        console.log(finishTask);

        const btnFinish = document.getElementById('btnFinish')
        if (finishTask.length > 0) {
            btnFinish.classList.remove('hidden')
        } else {
            btnFinish.classList.add('hidden')
        }
    }

    const handleFinishTask = () => {
        const confirmFinish = confirm ('Apakah Kamu Yakin Sudah Menyelesaikan Tugas Ini?')

        if (confirmFinish) {
            fetch(`includes/selesaikan_tugas.php?values=${finishTask}&jumlah=${finishTask.length}`, {
                method: 'GET'
            })
            .then (result => {
                location.reload()
            })
            .catch (error => console.log('Terjadi Kesalahan Dalam Proses Menyelesaikan Tugas: ', error))
        }
    }

    const toggleStatisticsModal  = () => {
        const statisticsModal = document.getElementById('modalStatistik')

        statisticsModal.classList.toggle('hidden')
    }

</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg" href="assets/appLogo.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <title>To Do List</title>
</head>
<body>  
    <div class="flex items-center justify-center w-full h-screen bg-white dark:bg-slate-800">
        <div class="flex h-[70%] w-[95%] sm:w-[90%] md:w-[80%] lg:w-[70%] flex-col items-center space-y-5 px-2 sm:px-16 rounded-lg bg-white dark:bg-slate-700 shadow-lg">

    
            <!-- Head -->
            <div class="mt-[10%] flex w-full justify-between items-end">
                <h1 class="sm:text-lg font-bold text-white ">Tugas Anda</h1>
                <div class="flex items-center space-x-1 sm:space-x-3">
                    <button id="btnFinish" name="selesaikan_tugas" onclick="handleFinishTask()" class="hidden rounded-md bg-green-600 px-2 py-1 font-semibold text-white shadow-md duration-500 active:scale-90 hover:bg-green-700">Selesai</button>
                    <button type="button" onclick="toggleAddTaskModal()" class="rounded-md bg-blue-600 px-1 sm:px-2 py-1 font-semibold text-white shadow-md duration-500 active:scale-90 hover:bg-blue-700 opacity">Tambah Tugas</button>
                    <button type="button" onclick="toggleStatisticsModal()" class="rounded-md px-3 duration-300 active:scale-90 hover:bg-slate-600">
                        <i class="mdi mdi-chart-box-outline text-white" style="font-size: 25px;"></i>
                    </button>
                </div>
            </div>
    
            <!-- Body -->
            <div class="flex max-h-[90%] w-full flex-col overflow-y-auto">
                <?php 
                    if (mysqli_num_rows($getTasks) > 0) {
                    while ($row = mysqli_fetch_array($getTasks)): 
                ?>
                    <form action="includes/hapus_tugas.php?id=<?= $row['ID'] ?>" method="post" class="my-2 flex w-full justify-between rounded-md bg-slate-600 pl-3 text-white duration-500 hover:scale-100 <?= $row['is_pin'] == 1 ? 'order-first' : '' ?>">
                        <div class="flex w-full items-center">
                            <input type="checkbox" value="<?= $row['ID'] ?>" onchange="handleAddFinishTask(this)" class="mr-3 accent-green-500">
                            <div class="flex-1 cursor-pointer py-5" onclick="toggleViewTaskModal('<?= $row['ID'] ?>', '<?= $row['Tugas'] ?>', '<?= $row['Deskripsi'] ?>')">
                                <input type="hidden" value="<?= $row['ID'] ?>" name="ID">
                                <p class="font-semibold text-sm sm:text-base"><?= $row['Tugas'] ?></p>
                            </div>
                        </div>
    
                        <div class="flex h-full w-max">
                            <button type="button" onclick="handlePinTask(<?= $row['ID'] ?>, <?= $row['is_pin'] ?>)" class="px-5 py-5 duration-500 hover:bg-slate-500">
                                <i class="mdi <?= $row['is_pin'] == 1 ? 'mdi-pin' : 'mdi-pin-outline' ?>" style="font-size: 22px;" id="pinIcon"></i>
                            </button>
    
                            <button name="hapus_tugas" onclick="return confirm('Anda yakin mau menghapus tugas ini?')" class="rounded-r-md px-5 py-5 duration-500 hover:bg-red-500">
                                <i class="mdi mdi-trash-can-outline" style="font-size: 22px;"></i>
                            </button>
                        </div>
                    </form>
                <?php 
                    endwhile;
                    } else echo "<p class='text-center text-lg font-semibold text-white'>Kamu Tidak Memiliki Tugas Untuk Saat Ini</p>";
                ?>
            </div>
        </div>
    
        <!-- Modal View Task -->
        <div id="viewTask" class="absolute left-0 top-0 flex h-full w-full items-center justify-center px-3 bg-black bg-opacity-50 hidden">
            <form action="includes/edit_tugas.php" method="post" class="divide-y lg:w-1/3 max-h-[85%] rounded-md bg-slate-700 px-3 py-3 mx-5 lg:mx-0">
                <div class="my-3">
                    <input type="hidden" id="taskId" name="taskId">
                    <input type="text" readonly id="taskTitle" name="taskTitle" autocomplete="off" class="w-full bg-slate-700 pb-2 text-lg font-semibold text-white focus:outline-none">
                    <textarea readonly id="taskDesc" name="taskDesc" class="min-h-20 max-h-96 w-full overflow-y-auto rounded border border-slate-500 bg-slate-600 p-1 text-white">Deskripsi Tugas</textarea>
                </div>
                <div class="flex w-full items-center justify-between space-x-3">
                    <div>
                        <input type="checkbox" id="editMode" onchange="toggleEditMode()" class="accent-slate-300">
                            <label for="editMode" class="font-semibold text-white">Edit Mode</label>
                        </div>
                        <div class="m-0 flex space-x-3">
                        <button id="btnEdit" name="edit_data" onclick="return confirm('Anda yakin mau mengedit tugas ini?')" disabled class="my-2 rounded bg-yellow-500 px-4 py-1 font-semibold text-white duration-300 active:scale-90 hover:bg-yellow-600 disabled:opacity-70">Edit</button>
                        <button type="button" onclick="toggleViewTaskModal()" class="my-2 rounded bg-red-500 px-4 py-1 font-semibold text-white duration-300 active:scale-90 hover:bg-red-600">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    
        <!-- Modal Add Task -->
        <div id="addTask" class="absolute left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="divide-y w-full sm:w-2/3 lg:w-1/3 max-h-[85%] rounded-md bg-slate-700 px-3 mx-5 sm:mx-0 py-3">
                <div class="py-3">
                    <p class="text-lg font-semibold text-white">Tambah Tugas Baru</p>
                </div>
    
                <form action="includes/tambah_tugas.php" method="post" id="formAdd" name="formAdd" class="divide-y space-y-3 pt-3 text-white">
                    <div class="space-y-3">
                        <div class="space-y-1">
                            <label for="judul">Judul Tugas :</label>
                            <input type="text" id="judul" name="judul" placeholder="Tambahkan Judul" required class="w-full rounded bg-slate-600 px-0.5 font-sans focus:outline-none">
                        </div>
                        <div class="space-y-1">
                            <label for="deskripsi">Deskripsi Tugas :</label>
                            <textarea id="deskripsi" name="deskripsi" placeholder="Tambahkan Deskripsi" required class="min-h-36 max-h-96 w-full rounded bg-slate-600 px-0.5 font-sans focus:outline-none"></textarea>
                        </div>
                    </div>
    
                    <div class="flex w-full items-center justify-end space-x-3">
                        <button type="button" onclick="toggleAddTaskModal()" class="my-2 rounded bg-red-500 px-4 py-1 font-semibold text-white duration-300 active:scale-90 hover:bg-red-600">Batal</button>
                        <button name="tambah_tugas" class="my-2 rounded bg-green-500 px-4 py-1 font-semibold text-white duration-300 active:scale-90 hover:bg-green-600">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    
        <!-- Modal Statistik -->
        <div id="modalStatistik" class="absolute left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="divide-y sm:w-full lg:w-2/3 max-h-[85%] rounded-md bg-slate-700 px-3 mx-5 lg:mx-0 py-3">
                <div class="py-3">
                    <p class="text-lg font-semibold text-white">Statistik Tugas Anda</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 py-4">
                    <?php while ($row = mysqli_fetch_array($getStatistics)): ?>
                        <div class="rounded-md bg-slate-600 px-2 py-5 text-white duration-500 hover:scale-105">
                            <p class="text-lg font-bold">Total Tugas</p>
                            <p class="pl-1 font-semibold"><?= $row['total_tugas'] ?></p>
                        </div>
                        <div class="rounded-md bg-slate-600 px-2 py-5 text-white duration-500 hover:scale-105">
                            <p class="text-lg font-bold">Tugas Diselesaikan</p>
                            <p class="pl-1 font-semibold"><?= $row['tugas_selesai'] ?></p>
                        </div>
                        <div class="rounded-md bg-slate-600 px-2 py-5 text-white duration-500 hover:scale-105">
                            <p class="text-lg font-bold">Total Tugas Saat Ini</p>
                            <p class="pl-1 font-semibold"><?= $row['tugas_saat_ini'] ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="pt-5">
                    <button type="button" onclick="toggleStatisticsModal()" class="float-end my-2 rounded bg-red-500 px-4 py-1 font-semibold text-white duration-300 active:scale-90 hover:bg-red-600">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>