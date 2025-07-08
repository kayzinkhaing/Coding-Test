<?php

//Reduces array to a single value (like summing).

$nums = [1, 2, 3];
$sum = array_reduce($nums, fn($carry, $item) => $carry + $item, 0);
echo $sum; // 6
