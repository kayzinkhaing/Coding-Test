<?php

$a = ['a' => 1, 'b' => 2];
$b = ['b' => 3, 'c' => 4];
print_r(array_replace($a, $b)); // ['a'=>1, 'b'=>3, 'c'=>4]
