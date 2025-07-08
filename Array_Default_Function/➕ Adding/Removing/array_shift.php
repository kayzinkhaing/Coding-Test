<?php
$arr = [1, 2, 3];
$first = array_shift($arr);
// $first = 1; $arr = [2, 3]
print_r($first);

$queue = ['task1', 'task2', 'task3'];

$firstTask = array_shift($queue);

echo "First task: $firstTask\n";
print_r($queue);


$data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

$first = array_shift($data);

echo "Removed: $first\n";
print_r($data);
