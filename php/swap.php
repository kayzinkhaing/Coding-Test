<?php
// don't use third variable
function swap(&$a, &$b) {
    $a = $a + $b; // Step 1: Add both numbers
    $b = $a - $b; // Step 2: Subtract the new value of a from b
    $a = $a - $b; // Step 3: Subtract the new value of b from a
}
// Example usage
$x = 5;
$y = 10;
$swaping = swap($x, $y);
echo "Before swapping: x = $x, y = $y\n";
swap($x, $y);
echo "After swapping: x = $x, y = $y\n";
echo "Swapped values: x = $x, y = $y\n";
echo "Swapping done successfully.\n";
?>