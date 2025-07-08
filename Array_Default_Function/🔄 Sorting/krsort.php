<?php
//Sorts array by keys in descending (Z-A) order

$arr = ["b" => 2, "c" => 3, "a" => 1];
krsort($arr);
print_r($arr);
