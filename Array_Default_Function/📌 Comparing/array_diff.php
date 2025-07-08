<?php
$availableProducts = ['apple', 'banana', 'orange', 'grape'];
$soldOutProducts = ['banana', 'grape'];

// Find which products are still available and not sold out
$inStock = array_diff($availableProducts, $soldOutProducts);

print_r($inStock);
?>
