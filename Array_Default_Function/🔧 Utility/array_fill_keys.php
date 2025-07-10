<?php

//Creates a new array using a list of keys, and fills all values with the same given value. 

$keys = ['a', 'b', 'c'];
print_r(array_fill_keys($keys, 0)); // ['a'=>0, 'b'=>0, 'c'=>0]

//📌 Use case: New user signs up — system gives them default settings automatically.
$setting_keys = ['notifications', 'email_verified', 'two_factor'];
$default_settings = array_fill_keys($setting_keys, false);

print_r($default_settings);
