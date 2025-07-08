<?php
$fruits = ['apple', 'banana', 'orange'];
echo count($fruits); // 3
echo "*******";

//COUNT_RECURSIVE counts nested elements too.
$data = [
    'fruits' => ['apple', 'banana'],
    'vegetables' => ['carrot', 'onion']
];
echo count($data); // 2
echo "*******";

echo count($data, COUNT_RECURSIVE); // 6
