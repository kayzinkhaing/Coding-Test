<?php

//Same as array_merge() but does not overwrite; combines into arrays.

$a = ['color' => ['red'], 'size' => 'M'];
$b = ['color' => ['blue']];
print_r(array_merge_recursive($a, $b));
// ['color' => ['red', 'blue'], 'size' => 'M']
