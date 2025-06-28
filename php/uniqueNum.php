<!-- //uniquenumber , use only one for loop, count key , result = value =1 ,don't use built-in functions ,no use isset, no use array_key_exists, no use array_count_values, no use array_unique, no use array_filter, no use array_map, no use array_reduce,$input = [1, 2, 2, 3, 4, 4, 5]; result will be 1,3,5 -->
<?php
// $arr = [1, 2, 2, 5, 6, 6, 6, 8, 9];
// $unique = [];

// for ($i = 0; $i < count($arr); $i++) {
//     $before = array_slice($arr, 0, $i);
//     $after = array_slice($arr, $i + 1);
//     $rest = array_merge($before, $after);
//     if (!in_array($arr[$i], $rest)) {
//         $unique[] = $arr[$i];
//     }
// }

// echo "Unique numbers: " . implode(" ", $unique);

$arr = [1, 2, 2, 5, 6, 6, 6, 8, 9];
$unique = [];

for ($i = 0; $i < count($arr); $i++) {
    $before = array_slice($arr, 0, $i);       // elements before current index
    // var_dump($before);
    $after = array_slice($arr, $i + 1);       // elements after current index

    // If current element is not in before or after, it's unique
    if (!in_array($arr[$i], $before) && !in_array($arr[$i], $after)) {
        $unique[] = $arr[$i];
    }
}

echo "Unique numbers: " . implode(" ", $unique);
?>
