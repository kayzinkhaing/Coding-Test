<?php

/*
သုံးလို့ရတဲ့နေရာတွေ
Lucky draw

Quiz app – Random question

eCommerce – Random featured product

Educational tool – Random exercise
*/

$fruits = ['apple', 'banana', 'cherry'];
$key = array_rand($fruits);
echo $fruits[$key]; // Random fruit


$colors = ['red', 'green', 'blue', 'yellow'];

$random_keys = array_rand($colors, 2);
print_r($random_keys);

echo $colors[$random_keys[0]] . ', ' . $colors[$random_keys[1]];
