<?php
    require 'Database/koneksi.php';

    $querySelect = "SELECT * FROM tugas";
    $getTugas = mysqli_query($connect, $querySelect);

    $querySelectStatistik = "SELECT * FROM statistik";
    $getStatistik = mysqli_query($connect, $querySelectStatistik);

    $queryCount = "SELECT COUNT(*) as total FROM Tugas";
    $resultCount = mysqli_query($connect, $queryCount);
    $dataCount = mysqli_fetch_assoc($resultCount);
    $total_tugas = $dataCount['total'];

    $updateTotal = "UPDATE statistik SET tugas_saat_ini = '$total_tugas'";
    mysqli_query($connect, $updateTotal);
?>

<script>
    const toggleViewModal = (id = '', title = '', desc = '') => {
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
        const titleInput = document.getElementById('taskTitle')
        const descInput = document.getElementById('taskDesc')
        const btnEdit = document.getElementById('btnEdit')

        if (isChecked) {
            titleInput.removeAttribute('readonly')
            descInput.removeAttribute('readonly')
            btnEdit.removeAttribute('disabled')
        } else{
            titleInput.setAttribute('readonly', true)
            descInput.setAttribute('readonly', true)
            btnEdit.setAttribute('disabled', true)
        }
    }

    const togglePin = (id, status) => {
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
    const addFinishTask = (checkbox) => {
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

    const selesaikan_tugas = () => {
        const confirm_finish = confirm ('Apakah Kamu Yakin Sudah Menyelesaikan Tugas Ini?')

        if (confirm_finish) {
            fetch(`includes/selesaikan_tugas.php?values=${finishTask}&jumlah=${finishTask.length}`, {
                method: 'GET'
            })
            .then (result => {
                location.reload()
            })
            .catch (error => console.log('Terjadi Kesalahan Dalam Proses Menyelesaikan Tugas: ', error))
        }
    }

    const toggleModalStatistik = () => {
        const modal = document.getElementById('modalStatistik')

        modal.classList.toggle('hidden')
    }

</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <title>To Do List App</title>
</head>
<body class="bg-slate-800">
    <div class="w-full h-full flex flex-col items-center space-y-5">

        <!-- Head -->
        <div class="w-[70%] mt-[10%] flex justify-between">
            <h1 class="font-bold text-lg text-white">Tugas Anda</h1>
            <div class="flex items-center space-x-3">
                <button id="btnFinish" name="selesaikan_tugas" onclick="selesaikan_tugas()" class="px-2 py-1 rounded-md bg-green-600 hover:bg-green-700 text-white font-semibold shadow-md active:scale-90 duration-500 hidden">Selesai</button>
                <button type="button"  class="px-2 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md active:scale-90 duration-500 opacity" onclick="toggleAddTaskModal()">Tambah Tugas</button>
                <button type="button" onclick="toggleModalStatistik()" class="px-3 hover:bg-slate-600 duration-300 active:scale-90 rounded-md"><i class="mdi mdi-chart-box-outline text-white" style="font-size: 25px;"></i></button>
            </div>
        </div>

        <!-- Body -->
         <div class="w-[70%] max-h-[60%] overflow-y-auto flex flex-col">
            <?php 
                if (mysqli_num_rows($getTugas) > 0) {
                while ($row = mysqli_fetch_array($getTugas)): 
            ?>
                <form action="includes/hapus_tugas.php?id=<?= $row['ID'] ?>" method="post" class="w-full pl-3 bg-slate-700 text-white rounded-md hover:scale-100 duration-500 flex justify-between my-2 <?= $row['is_pin'] == 1 ? 'order-first' : '' ?>">
                    <div class="flex w-full items-center">
                        <input type="checkbox" value="<?= $row['ID'] ?>" onchange="addFinishTask(this)" class="mr-3 accent-green-500">
                        <div class="flex-1 cursor-pointer py-5" onclick="toggleViewModal('<?= $row['ID'] ?>', '<?= $row['Tugas'] ?>', '<?= $row['Deskripsi'] ?>')">
                            <input type="hidden" value="<?= $row['ID'] ?>" name="ID">
                            <p class="font-semibold"><?= $row['Tugas'] ?></p>
                        </div>
                    </div>

                    <div class="w-max h-full flex">
                        <button type="button" onclick="togglePin(<?= $row['ID'] ?>, <?= $row['is_pin'] ?>)" class="py-5 px-5 hover:bg-slate-500 duration-500">
                            <i class="mdi <?= $row['is_pin'] == 1 ? 'mdi-pin' : 'mdi-pin-outline' ?>" style="font-size: 22px;" id="pinIcon"></i>
                        </button>

                        <button name="hapus_tugas" onclick="return confirm('Anda yakin mau menghapus tugas ini?')" class="py-5 px-5 hover:bg-red-500 duration-500 rounded-r-md">
                            <i class="mdi mdi-trash-can-outline" style="font-size: 22px;"></i>
                        </button>
                    </div>
                </form>
            <?php 
                endwhile;
                } else echo "<p class ='text-white  text-lg text-center font-semibold'>Kamu Tidak Memiliki Tugas Untuk Saat Ini</p>"
            ?>
         </div>
    </div>

    <!-- Modal View Task -->
    <div class="w-full h-full absolute flex justify-center items-center left-0 top-0 bg-black bg-opacity-50 hidden" id="viewTask">
        <form action="includes/edit_tugas.php" method="post" class="w-1/3 h-max max-h-[85%] bg-slate-700 rounded-md px-3 py-3 divide-y">
            <div class="my-3">
                <input type="hidden" id="taskId" name="taskId">
                <input type="text" readonly id="taskTitle" name="taskTitle" autocomplete="off" class="w-full bg-slate-700 text-white text-lg font-semibold focus:outline-none pb-2">
                <textarea readonly id="taskDesc" name="taskDesc" class="w-full max-h-96 min-h-20 bg-slate-600 rounded border border-slate-500 p-1 text-white overflow-y-auto">Deskripsi Tugas</textarea>
            </div>
            <div class="w-full h-full flex justify-between items-center space-x-3">
                <div class="">
                    <input type="checkbox" id="editMode" onchange="toggleEditMode()" class="accent-slate-300">
                    <label for="editMode"  class="text-white font-semibold">Edit Mode</label>
                </div>
                <div class="flex m-0 space-x-3">
                    <button id="btnEdit" name="edit_data" onclick="return confirm('Anda yakin mau mengedit tugas ini?')" disabled class="px-4 py-1 bg-yellow-500 hover:bg-yellow-600 rounded my-2 text-white font-semibold float-end active:scale-90 duration-300">Edit</button>
                    <button type="button" class="px-4 py-1 bg-red-500 hover:bg-red-600 rounded my-2 text-white font-semibold float-end active:scale-90 duration-300" onclick="toggleViewModal()">Tutup</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Add Task -->
    <div class="w-full h-full absolute flex justify-center items-center left-0 top-0 bg-black bg-opacity-50 hidden" id="addTask">
        <div class="w-1/3 h-max max-h-[85%] bg-slate-700 rounded-md px-3 py-3 divide-y">
            <div class="py-3">
                <p class="text-white text-lg font-semibold">Tambah Tugas Baru</p>
            </div>

            <form action="includes/tambah_tugas.php" method="post" id="formAdd" name="formAdd" class="pt-3 text-white space-y-3 divide-y">
                <div class="space-y-3">
                    <div class="space-y-1">
                        <label for="judul">Judul Tugas :</label>
                        <input type="text" class="w-full rounded bg-slate-600 focus:outline-none px-0.5 font-sans" id="judul" name="judul" placeholder="Tambahkan Judul" required>
                    </div>
                    <div class="space-y-1">
                        <label for="deskripsi">Deskripsi Tugas :</label>
                        <textarea class="w-full max-h-96 min-h-36 rounded bg-slate-600 focus:outline-none px-0.5 font-sans" id="deskripsi" name="deskripsi" placeholder="Tambahkan Deskripsi" required></textarea>
                    </div>
                </div>

                <div class="w-full flex justify-end items-center space-x-3 ">
                    <button class="px-4 py-1 bg-red-500 hover:bg-red-600 rounded my-2 text-white font-semibold active:scale-90 duration-300" onclick="toggleAddTaskModal()">Batal</button>
                    <button name="tambah_tugas" class="px-4 py-1 bg-green-500 hover:bg-green-600 rounded my-2 text-white font-semibold active:scale-90 duration-300">Tambah</button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Statistik -->
    <div class="w-full h-full absolute flex justify-center items-center left-0 top-0 bg-black bg-opacity-50 hidden" id="modalStatistik">
        <div class="w-2/3 h-max max-h-[85%] bg-slate-700 rounded-md px-3 py-3 divide-y">
            <div class="py-3">
                <p class="text-white text-lg font-semibold">Statistik Tugas Anda</p>
            </div>
            <div class="grid grid-cols-3 gap-3 py-4">
                <?php while ($row = mysqli_fetch_array($getStatistik)): ?>
                    <div class="bg-slate-600 px-2 py-5 rounded-md text-white hover:scale-105 duration-500">
                        <p class="font-bold text-lg">Total Tugas</p>
                        <p class="pl-1 font-semibold"><?= $row['total_tugas'] ?></p>
                    </div>
                    <div class="bg-slate-600 px-2 py-5 rounded-md text-white hover:scale-105 duration-500">
                        <p class="font-bold text-lg">Tugas Diselesaikan</p>
                        <p class="pl-1 font-semibold"><?= $row['tugas_selesai'] ?></p>
                    </div>
                    <div class="bg-slate-600 px-2 py-5 rounded-md text-white hover:scale-105 duration-500">
                        <p class="font-bold text-lg">Tugas Saat Ini</p>
                        <p class="pl-1 font-semibold"><?= $row['tugas_saat_ini'] ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="py-3">
                <button class="px-4 py-1 bg-red-500 float-end hover:bg-red-600 rounded my-2 text-white font-semibold active:scale-90 duration-300" onclick="toggleModalStatistik()">Tutup</button>
            </div>
        </div>
    </div>

</body>
</html>