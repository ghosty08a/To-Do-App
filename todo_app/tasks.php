<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user'];

// ADD TASK
if (isset($_POST['add'])) {
    $task = $_POST['task'];
    $date = $_POST['due_date'];

    $conn->query("INSERT INTO tasks (user_id, task, due_date, status)
                  VALUES ('$user_id', '$task', '$date', 'pending')");
}

// GET TASKS
$tasks = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="nav">
    <a href="index.php">Dashboard</a>
    <a href="tasks.php">Tasks</a>
    <a href="schedule.php">Schedule</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">

    <h2>📝 My Tasks</h2>

    <form method="POST" class="task-form">
        <input type="text" name="task" placeholder="Enter task..." required>
        <input type="date" name="due_date" required>
        <button name="add">Add Task</button>
    </form>

    <div class="task-list">
        <?php while ($row = $tasks->fetch_assoc()): ?>
            <div class="task-card">
                <h3><?php echo $row['task']; ?></h3>
                <p>Due: <?php echo $row['due_date']; ?></p>
                <span class="status <?php echo $row['status']; ?>">
                    <?php echo $row['status']; ?>
                </span>
            </div>
        <?php endwhile; ?>
    </div>

</div>

</body>
</html>