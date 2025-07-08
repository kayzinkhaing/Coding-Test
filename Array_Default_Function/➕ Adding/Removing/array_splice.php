<?php

$fruits = ['apple', 'banana', 'cherry'];

array_splice($fruits, 1, 1, ['blueberry', 'kiwi']);

print_r($fruits);

$arr = [1, 2, 3, 4];
$splice=array_splice($arr, 1, 2);
// Result: [1, 4]
print_r($splice);


$fruits = ['apple', 'banana', 'cherry', 'date'];

$removed = array_splice($fruits, 1, 2);
echo "Remove fruits are ";
print_r($removed); // ['banana', 'cherry']
echo "Remaining fruits are ";
print_r($fruits);  // ['apple', 'date']
?>
