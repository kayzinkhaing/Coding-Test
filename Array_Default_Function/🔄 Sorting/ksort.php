<?php
//Sorts array by keys in ascending (A-Z) order
$data = [
    "d" => "Dog",
    "b" => "Banana",
    "a" => "Apple",
    "c" => "Cat"
];

ksort($data);

print_r($data);
?>
