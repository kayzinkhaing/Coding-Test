<?php

//User-defined sorting by values

// Preserves original keys



$arr = ["a" => 3, "b" => 1, "c" => 2];
uasort($arr, fn($a, $b) => $b <=> $a);
print_r($arr);
