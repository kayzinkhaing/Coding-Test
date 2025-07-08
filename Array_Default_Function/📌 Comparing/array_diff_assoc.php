<?php
//Compares both key and value.

$a = ['a' => 1, 'b' => 2];
$b = ['a' => 1, 'b' => 3];
print_r(array_diff_assoc($a, $b)); // ['b' => 2]
