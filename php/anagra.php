<?php

function areAnagrams(string $str1, string $str2): bool {
    // Early length check
    if (strlen($str1) !== strlen($str2)) {
        return false;
    }

    $count = [];

    // Count characters in first string
    for ($i = 0; isset($str1[$i]); $i++) {
        $char = $str1[$i];
        $count[$char] = isset($count[$char]) ? $count[$char] + 1 : 1;
    }

    // Decrease counts based on second string
    for ($i = 0; isset($str2[$i]); $i++) {
        $char = $str2[$i];
        if (!isset($count[$char]) || $count[$char] === 0) {
            return false;
        }
        $count[$char]--;
    }

    return true;
}

// Example usage
var_dump(areAnagrams("listen", "silent"));     // true
var_dump(areAnagrams("hello", "world"));       // false
var_dump(areAnagrams("triangle", "integral")); // true
