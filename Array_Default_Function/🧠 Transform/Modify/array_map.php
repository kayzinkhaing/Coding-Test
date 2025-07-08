<?php
$nums = [1, 2, 3];
$squared = array_map(fn($n) => $n * $n, $nums);
// Result: [1, 4, 9]
print_r($squared);


/* 
$words = ['php', 'laravel', 'symfony'];

$capitalized = array_map('ucfirst', $words);

print_r($capitalized);
*/