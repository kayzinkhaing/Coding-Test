<?php

//Sorts array by values in ascending order
// Keeps original keys

$arr = ["a" => 3, "b" => 1, "c" => 2];
asort($arr);
print_r($arr);