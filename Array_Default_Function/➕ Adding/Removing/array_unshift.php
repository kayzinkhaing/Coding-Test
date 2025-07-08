<?php
$arr = [2, 3];
$unshift=array_unshift($arr, 1);
// Result: [1, 2, 3]
print_r($unshift);


$arr = ['b', 'c', 'd'];

$newCount = array_unshift($arr, 'a');

print_r($arr);
echo "New count: $newCount\n";