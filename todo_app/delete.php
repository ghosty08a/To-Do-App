<?php
$data = json_decode(file_get_contents('tasks.json'), true);

$data = array_filter($data, function($task) {
    return $task['id'] != $_GET['id'];
});

file_put_contents('tasks.json', json_encode(array_values($data), JSON_PRETTY_PRINT));

header("Location: index.php");