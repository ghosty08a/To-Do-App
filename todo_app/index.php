<?php
include 'auth.php';

// LOAD DATA
$data = json_decode(file_get_contents('tasks.json'), true);
if (!$data) $data = [];

// PAGE + FILTER
$page   = $_GET['page'] ?? 'dashboard';
$filter = $_GET['filter'] ?? 'all';

// STATS
$total = count($data);
$completed = 0;
$pending = 0;

foreach ($data as $task) {
    $status = $task['status'] ?? 'pending';

    if ($status == "done") {
        $completed++;
    } else {
        $pending++;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart To-Do</title>
    <link rel="stylesheet" href="style.css?v=4">
</head>
<body>

<div class="app">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>SmartApp</h2>

    <a href="index.php?page=dashboard"
       class="<?= $page=='dashboard'?'active':'' ?>">
        🏠 <span>Dashboard</span>
    </a>

    <a href="index.php?page=tasks&filter=all"
       class="<?= ($page=='tasks' && $filter=='all')?'active':'' ?>">
        📋 <span>Tasks</span>
    </a>

    <a href="index.php?page=tasks&filter=done"
       class="<?= ($page=='tasks' && $filter=='done')?'active':'' ?>">
        ✅ <span>Completed</span>
    </a>

    <a href="index.php?page=tasks&filter=pending"
       class="<?= ($page=='tasks' && $filter=='pending')?'active':'' ?>">
        ⏳ <span>Pending</span>
    </a>

    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h1><?= $page == 'dashboard' ? '📊 Dashboard' : '📋 My Tasks' ?></h1>

<!-- STATS -->
<div class="cards">
    <div class="card blue">
        <h2><?= $total ?></h2>
        <p>Total</p>
    </div>
    <div class="card green">
        <h2><?= $completed ?></h2>
        <p>Completed</p>
    </div>
    <div class="card orange">
        <h2><?= $pending ?></h2>
        <p>Pending</p>
    </div>
</div>

<!-- SHOW TASK UI ONLY IF TASKS PAGE -->
<?php if ($page == 'tasks'): ?>

<!-- ADD TASK -->
<form action="add.php" method="POST" class="add">
    <input type="text" name="task" placeholder="New task..." required>
    <input type="date" name="date" required>

    <select name="priority">
        <option value="Low">Low</option>
        <option value="Medium" selected>Medium</option>
        <option value="High">High</option>
    </select>

    <button>Add</button>
</form>

<!-- TASK LIST -->
<div class="task-list">

<?php foreach ($data as $t): 

    $status   = $t['status'] ?? 'pending';
    $priority = $t['priority'] ?? 'Low';
    $created  = $t['created_at'] ?? 'N/A';
    $task     = $t['task'] ?? '';
    $date     = $t['date'] ?? '';
    $id       = $t['id'] ?? 0;

    // FILTER
    if ($filter == 'done' && $status != 'done') continue;
    if ($filter == 'pending' && $status != 'pending') continue;
?>

<div class="task <?= $status ?> priority-<?= strtolower($priority) ?>">

    <div class="task-top">
        <h3><?= htmlspecialchars($task) ?></h3>
        <span class="priority"><?= $priority ?></span>
    </div>

    <div class="task-meta">
        <span>📅 <?= $date ?></span>
        <span>🕒 <?= $created ?></span>
    </div>

    <div class="actions">
        <a href="update.php?id=<?= $id ?>" class="done">✔</a>
        <a href="delete.php?id=<?= $id ?>" class="delete">✖</a>
    </div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div> <!-- main -->
</div> <!-- app -->

</body>
</html>