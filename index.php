<?php
    require 'Database/koneksi.php';

    $querySelect = "SELECT * FROM tugas";
    $getTugas = mysqli_query($connect, $querySelect);
?>

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
    <div class="w-full h-full flex flex-col justify-center items-center space-y-5">

        <!-- Head -->
        <div class="w-[70%] mt-[10%] flex justify-between">
            <h1 class="font-bold text-lg text-white">Tugas Anda</h1>
            <button class="px-2 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md active:scale-90 duration-500">Tambah Tugas</button>
        </div>

        <!-- Body -->
         <div class="w-[70%] max-h-[50%] space-y-3">
            <?php while ($row = mysqli_fetch_array($getTugas)): ?>
                <div class="w-full pl-3 bg-slate-700 text-white rounded-md hover:scale-100 duration-500 flex justify-between">
                    <div class="flex py-5">
                        <input type="checkbox" class="mr-3 accent-green-500">
                        <p class="font-semibold"><?= $row['Tugas'] ?></p>
                    </div>

                    <div class="w-max h-full flex">
                        <button class="py-5 px-5 hover:bg-slate-500 duration-500">
                            <i class="mdi mdi-pin-outline" style="font-size: 22px;"></i>
                        </button>

                        <button class="py-5 px-5 hover:bg-red-500 duration-500 rounded-r-md">
                            <i class="mdi mdi-trash-can-outline" style="font-size: 22px;"></i>
                        </button>
                    </div>
                </div>
            <?php endwhile; ?>
         </div>
    </div>
</body>
</html>