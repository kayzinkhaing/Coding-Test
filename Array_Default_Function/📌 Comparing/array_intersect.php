<?php
// $a = [1, 2, 3];
// $b = [2, 3, 4];
// $intersect = array_intersect($a, $b);
// // Result: [1 => 2, 2 => 3]
// print_r($intersect);

$article1Tags = ['php', 'backend', 'web', 'laravel'];
$article2Tags = ['web', 'frontend', 'html', 'php'];

$commonTags = array_intersect($article1Tags, $article2Tags);

print_r($commonTags);

