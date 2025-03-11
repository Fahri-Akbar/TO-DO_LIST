<?php
    require 'Database/koneksi.php';

    $querySelect = "SELECT * FROM tugas";
    $getTugas = mysqli_query($connect, $querySelect);
?>

<script>
    const toggleViewModal = (title = '', desc = '') => {
        const viewTaskModal = document.getElementById('viewTask')
        const taskTitle = document.getElementById('taskTitle')
        const taskDesc = document.getElementById('taskDesc')

        taskTitle.textContent = title
        taskDesc.value = desc

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

    const togglePin = () => {
        const pinIcon = document.getElementById('pinIcon')
        pinIcon.classList.toggle('-outline')
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
            <button class="px-2 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md active:scale-90 duration-500" onclick="toggleAddTaskModal()">Tambah Tugas</button>
        </div>

        <!-- Body -->
         <div class="w-[70%] max-h-[50%] space-y-3">
            <?php while ($row = mysqli_fetch_array($getTugas)): ?>
                <div class="w-full pl-3 bg-slate-700 text-white rounded-md hover:scale-100 duration-500 flex justify-between">
                    <div class="flex w-full items-center">
                        <input type="checkbox" class="mr-3 accent-green-500">
                        <div class="flex-1 cursor-pointer py-5" onclick="toggleViewModal('<?= $row['Tugas'] ?>', '<?= $row['Deskripsi'] ?>')">
                            <p class="font-semibold"><?= $row['Tugas'] ?></p>
                        </div>
                    </div>

                    <div class="w-max h-full flex">
                        <button class="py-5 px-5 hover:bg-slate-500 duration-500" onclick="togglePin()">
                            <i class="mdi mdi-pin-outline" style="font-size: 22px;" id="pinIcon"></i>
                        </button>

                        <button class="py-5 px-5 hover:bg-red-500 duration-500 rounded-r-md">
                            <i class="mdi mdi-trash-can-outline" style="font-size: 22px;"></i>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
         </div>
    </div>

    <!-- Modal View Task -->
    <div class="w-full h-full absolute flex justify-center items-center left-0 top-0 bg-black bg-opacity-50 hidden" id="viewTask">
        <div class="w-1/3 h-max max-h-[85%] bg-slate-700 rounded-md px-3 py-3 divide-y">
            <div class="my-3">
                <p class="text-white font-semibold text-lg mb-3" id="taskTitle"></p>
                <textarea readonly class="w-full max-h-96 bg-slate-600 rounded border border-slate-500 p-1 text-white overflow-y-auto" id="taskDesc">Deskripsi Tugas</textarea>
            </div>
            <div class="">
                <button class="px-4 py-1 bg-red-500 hover:bg-red-600 rounded my-2 text-white font-semibold float-end active:scale-90 duration-300" onclick="toggleViewModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Add Task -->
    <div class="w-full h-full absolute flex justify-center items-center left-0 top-0 bg-black bg-opacity-50 hidden" id="addTask">
        <div class="w-1/3 h-max max-h-[85%] bg-slate-700 rounded-md px-3 py-3 divide-y">
            <div class="py-3">
                <p class="text-white text-lg font-semibold">Tambah Tugas Baru</p>
            </div>

            <form id="formAdd" name="formAdd" class="py-3 text-white space-y-3">
                <div class="space-y-1">
                    <label for="judul">Judul Tugas :</label>
                    <input type="text" class="w-full rounded bg-slate-600 focus:outline-none px-0.5 font-sans" id="judul" placeholder="Tambahkan Judul">
                </div>
                <div class="space-y-1">
                    <label for="deskripsi">Deskripsi Tugas :</label>
                    <textarea class="w-full max-h-96 h-36 rounded bg-slate-600 focus:outline-none px-0.5 font-sans" id="deskripsi" placeholder="Tambahkan Deskripsi"></textarea>
                </div>
            </form>

            <div class="w-full flex justify-end items-center space-x-3">
                <button class="px-4 py-1 bg-red-500 hover:bg-red-600 rounded my-2 text-white font-semibold active:scale-90 duration-300" onclick="toggleAddTaskModal()">Batal</button>
                <button class="px-4 py-1 bg-green-500 hover:bg-green-600 rounded my-2 text-white font-semibold active:scale-90 duration-300">Tambah</button>
            </div>
        </div>
    </div>

</body>
</html>