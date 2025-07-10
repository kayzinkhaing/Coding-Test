<?php

$arr = ['apple', 'banana'];
list($a, $b) = $arr;
echo $a; // apple

echo "\n**********************\n";

$row = ['Ko Ko', 'Developer', 'Yangon'];

list($name, $job, $city) = $row;

echo "$name is a $job from $city.";

echo "\n**********************\n";

$items = [
  ['Apple', 100],
  ['Banana', 50],
  ['Orange', 75]
];

foreach ($items as $item) {
    list($name, $price) = $item;
    echo "$name costs $price ks\n";
}

