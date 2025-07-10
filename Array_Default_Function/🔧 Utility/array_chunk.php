<?php

//array_chunk() splits an array into smaller arrays (chunks), each of a specified size.
// "Split this array into chunks of 2 items each."

$input = [1, 2, 3, 4];
print_r(array_chunk($input, 2)); // [[1, 2], [3, 4]]
