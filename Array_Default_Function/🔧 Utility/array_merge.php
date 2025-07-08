<?php 
$a =[1,2,3];
$b=[3,4,5];
$result=array_merge($a,$b);
print_r($result);


$a = ['name' => 'Alice', 'email' => 'alice@example.com'];
$b = ['email' => 'updated@example.com', 'age' => 30];

$result = array_merge($a, $b);

print_r($result);