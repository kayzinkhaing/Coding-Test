<?php

$a = ['a' => 1, 'b' => 2];
$b = ['b' => 3];
print_r(array_diff_key($a, $b)); // ['a' => 1]
