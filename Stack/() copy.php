<?php



// Balanced Parentheses Checker
// Difficulty: Easy to Medium
// Topic: Stack

// Problem Statement

// Given a string containing just the characters '(', ')', '{', '}', '[', and ']', write a function that determines if the input string is valid.

// A string is considered valid if:

// Open brackets must be closed by the same type of brackets.
// Open brackets must be closed in the correct order.


// is_valid_brackets("()")            # True
// is_valid_brackets("()[]{}")        # True
// is_valid_brackets("(]")            # False
// is_valid_brackets("([)]")          # False
// is_valid_brackets("{[]}")          # True


function is_valid_brackets($s) {
    $stack = [];

    // Extended bracket pairs
    $pairs = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
        '«' => '»',
        '“' => '”',
        '‘' => '’',
        '「' => '」',
        '【' => '】',
        '《' => '》',
        '‹' => '›',
        '"'  => '"', // symmetric quote
        "'"  => "'", // symmetric single quote
    ];
    // $chars = str_split($s);// [ '(', '[' , ')' ]

    $chars = preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY); // Unicode-safe split/
    // print_r($chars);//Array([0] => ( [1] => ) )
    // die();

    foreach ($chars as $char) { // ( , )
        if (isset($pairs[$char])) { // true
            $stack[] = $char;//$stack = [ ( ]
        } else {
            $last = array_pop($stack);// (
            if ($last === null || ($pairs[$last] ?? null) !== $char) { // ) !== )
                return false;
            }
        }
    }

    return empty($stack);//true
}

// Test cases
var_dump(is_valid_brackets("()"));                 // true
var_dump(is_valid_brackets("()[]{}"));             // true
var_dump(is_valid_brackets("(]"));                 // false
var_dump(is_valid_brackets("([)]"));               // false
var_dump(is_valid_brackets("{[]}"));               // true
var_dump(is_valid_brackets("«[<hello>]»"));        // true
var_dump(is_valid_brackets("「[《》]」"));           // true
var_dump(is_valid_brackets("‘{[(“”)])}’"));         // true
var_dump(is_valid_brackets("({[}])"));             // false
?>

