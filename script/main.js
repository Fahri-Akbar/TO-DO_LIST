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