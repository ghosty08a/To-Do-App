<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user'];

$schedule = $conn->query("SELECT * FROM tasks WHERE user_id='$user_id' ORDER BY due_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule</title>
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

    <h2>📅 Schedule</h2>

    <?php while ($row = $schedule->fetch_assoc()): ?>
        <div class="schedule-card">
            <h3><?php echo $row['task']; ?></h3>
            <p>📆 <?php echo $row['due_date']; ?></p>
        </div>
    <?php endwhile; ?>

</div>

</body>
</html>