<?php
$data = json_decode(file_get_contents('tasks.json'), true);

foreach ($data as &$task) {
    if ($task['id'] == $_GET['id']) {
        $task['status'] = ($task['status'] == "done") ? "pending" : "done";
    }
}

file_put_contents('tasks.json', json_encode($data, JSON_PRETTY_PRINT));

header("Location: index.php");