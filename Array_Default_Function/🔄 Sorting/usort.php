<?php
$numbers = [3, 1, 4, 1, 5, 9];

usort($numbers, function($a, $b) {
    return $b <=> $a;  // Descending order
});

print_r($numbers);
?>
