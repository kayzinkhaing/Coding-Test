<?php

$a = ['a' => 1, 'b' => 2];
$b = ['b' => 3, 'c' => 4];
print_r(array_replace($a, $b)); // ['a'=>1, 'b'=>3, 'c'=>4]


$default_settings = [
    'theme' => 'light',
    'notifications' => true,
    'language' => 'en'
];

$user_settings = [
    'theme' => 'dark',
    'language' => 'fr'
];

$final_settings = array_replace($default_settings, $user_settings);
print_r($final_settings);


$default_form = [
    'name' => '',
    'email' => '',
    'phone' => ''
];

$submitted_data = [
    'email' => 'test@example.com'
];

$form = array_replace($default_form, $submitted_data);
print_r($form);
