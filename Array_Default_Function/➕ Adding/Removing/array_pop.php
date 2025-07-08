<?php
$stack = ['task1', 'task2', 'task3'];

while (!empty($stack)) {
    $task = array_pop($stack);
    echo "Processing: $task\n";
}
?>
