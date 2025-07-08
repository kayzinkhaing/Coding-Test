<?php
$arr = ['a' => 1, 'b' => 2];
$values = array_values($arr);
// Result: [1, 2]
print_r($values);

$arr = [
    3 => 'apple',
    5 => 'banana',
    9 => 'cherry'
];

$newArr = array_values($arr);

print_r($newArr);