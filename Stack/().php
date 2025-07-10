<?php

function is_valid_brackets(string $input): bool
{
    $chars = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY);
    $counts = array_count_values($chars);
    $bracketPairs = [];

    // Find all brackets that appear an even number of times
    $potentialPairs = [];
    foreach ($counts as $char => $count) {
        if ($count >= 2 && $count % 2 === 0) {
            $potentialPairs[] = $char;
        }
    }

    // Pair up characters: (first with second), (third with fourth), etc.
    for ($i = 0; $i < count($potentialPairs); $i += 2) {
        if (isset($potentialPairs[$i + 1])) {
            $open = $potentialPairs[$i];
            $close = $potentialPairs[$i + 1];
            $bracketPairs[$open] = $close;
        }
    }

    $stack = [];
    $closingToOpening = array_flip($bracketPairs);

    foreach ($chars as $char) {
        if (isset($bracketPairs[$char])) {
            $stack[] = $char;
        } elseif (isset($closingToOpening[$char])) {
            $last = array_pop($stack);
            if ($last !== $closingToOpening[$char]) {
                return false;
            }
        }
    }

    return empty($stack);
}

var_dump(is_valid_brackets("(]"));                 // true
var_dump(is_valid_brackets("()[]{}"));             // true
var_dump(is_valid_brackets("(]"));                 // false
var_dump(is_valid_brackets("([)]"));               // false
var_dump(is_valid_brackets("{[]}"));               // true
var_dump(is_valid_brackets("«[<hello>]»"));        // true
var_dump(is_valid_brackets("「[《》]」"));           // true
var_dump(is_valid_brackets("‘{[(“”)])}’"));         // true
var_dump(is_valid_brackets("({[}])"));             // false
