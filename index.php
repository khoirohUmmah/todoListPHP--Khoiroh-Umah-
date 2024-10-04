<?php
session_start();

// Inisialisasi session jika belum ada
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle penambahan Task
if (isset($_POST['add_task'])) {
    $task = [
        'title' => $_POST['task_title'],
        'priority' => $_POST['task_priority'],
        'deadline' => $_POST['task_deadline'], // Tambahkan deadline
    ];
    $_SESSION['tasks'][] = $task;
}

// Handle penghapusan Task
if (isset($_GET['delete_task'])) {
    $task_id = $_GET['delete_task'];
    unset($_SESSION['tasks'][$task_id]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
}

// Handle pengeditan Task
if (isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $_SESSION['tasks'][$task_id] = [
        'title' => $_POST['task_title'],
        'priority' => $_POST['task_priority'],
        'deadline' => $_POST['task_deadline'], // Tambahkan deadline
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Task Manager</h1>

        <!-- Form untuk menambahkan Task -->
        <form action="" method="post" class="task-form">
            <input type="text" name="task_title" placeholder="Enter task" required>
            <select name="task_priority" required>
                <option value="Priority 1">Priority 1</option>
                <option value="Priority 2">Priority 2</option>
                <option value="Priority 3">Priority 3</option>
            </select>
            <input type="date" name="task_deadline" required> <!-- Input untuk deadline -->
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <!-- Menampilkan Daftar Tasks -->
        <h2>Task List</h2>
        <ul class="task-list">
            <?php foreach ($_SESSION['tasks'] as $id => $task) { ?>
                <li>
                    <form action="" method="post" class="update-form">
                        <input type="hidden" name="task_id" value="<?= $id ?>">
                        <input type="text" name="task_title" value="<?= $task['title'] ?>" required>
                        <select name="task_priority">
                            <option value="Priority 1" <?= $task['priority'] == 'Priority 1' ? 'selected' : '' ?>>Priority 1</option>
                            <option value="Priority 2" <?= $task['priority'] == 'Priority 2' ? 'selected' : '' ?>>Priority 2</option>
                            <option value="Priority 3" <?= $task['priority'] == 'Priority 3' ? 'selected' : '' ?>>Priority 3</option>
                        </select>
                        <input type="date" name="task_deadline" value="<?= $task['deadline'] ?>" required> <!-- Menampilkan deadline -->
                        <button type="submit" name="update_task">Update</button>
                    </form>
                    <span>Deadline: <?= $task['deadline'] ?></span> <!-- Tampilkan deadline -->
                    <a href="?delete_task=<?= $id ?>" class="delete-btn">Delete</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
