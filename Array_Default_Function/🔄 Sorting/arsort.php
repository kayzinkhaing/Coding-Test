<?php

// Sorts array by values in descending order
// Keeps original keys

$grades = [
    "Alice" => 85,
    "Bob" => 92,
    "Charlie" => 78,
    "David" => 95
];

arsort($grades);

print_r($grades);
?>
