<?php

//User-defined sorting by keys

$arr = ["b" => 2, "c" => 3, "a" => 1];
uksort($arr, fn($a, $b) => strcmp($b, $a)); // descending key sort
print_r($arr);
