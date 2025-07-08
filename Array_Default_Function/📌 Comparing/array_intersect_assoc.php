<?php
//Keeps elements with same key and value.

$a = ['a' => 1, 'b' => 2];
$b = ['a' => 1, 'b' => 3];
print_r(array_intersect_assoc($a, $b)); // ['a' => 1]
