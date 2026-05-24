<?php
$data = json_decode(file_get_contents('tasks.json'), true);

$new = [
    "id" => time(),
    "task" => $_POST['task'],
    "date" => $_POST['date'],
    "priority" => $_POST['priority'],
    "status" => "pending",
    "created_at" => date("Y-m-d H:i:s")
];

$data[] = $new;

file_put_contents('tasks.json', json_encode($data, JSON_PRETTY_PRINT));

header("Location: index.php");