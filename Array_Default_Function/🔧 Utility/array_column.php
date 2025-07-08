<?php
$users = [
    ['id' => 101, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 102, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ['id' => 103, 'name' => 'Charlie', 'email' => 'charlie@example.com']
];

// Get the 'email' column from each user
$emails = array_column($users, 'email');

print_r($emails);
?>
