<?php
$form = ['name' => 'Alice', 'email' => null];

if (array_key_exists('email', $form)) {
    echo "Email field is present, even if it's empty.";
} else {
    echo "Email field is missing.";
}

$arr = ['name' => null];

var_dump(isset($arr['name']));            // false
var_dump(array_key_exists('name', $arr)); // true
?>
