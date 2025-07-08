<?php
// $nums = [1, 2, 3, 4];
// $even = array_filter($nums, fn($n) => $n % 2 === 0);
// // Result: [1 => 2, 3 => 4]
// print_r($even);

$strings = ["apple", "", "banana", null, "cherry", 0, false];

// Keep only non-empty strings
$filtered = array_filter($strings, function ($item) {
    return is_string($item) && $item !== "";
});

print_r($filtered);