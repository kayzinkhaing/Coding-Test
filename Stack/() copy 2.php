<?php

function is_valid_brackets(string $input, string $pairString): bool
{
    if (mb_strlen($pairString) % 2 !== 0) {
        throw new InvalidArgumentException("Bracket pair string must have an even number of characters.");
    }

    $bracketPairs = [];
    for ($i = 0; $i < mb_strlen($pairString); $i += 2) {
        $open = mb_substr($pairString, $i, 1);
        $close = mb_substr($pairString, $i + 1, 1);
        $bracketPairs[$open] = $close;
    }

    $stack = [];
    $closingToOpening = array_flip($bracketPairs);
    $chars = preg_split('//u', $input, -1, PREG_SPLIT_NO_EMPTY);

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
echo is_valid_brackets("({[]})", "()[]{}") ? "Valid\n" : "Invalid\n";     // ✅ Valid
echo is_valid_brackets("«{[<text>]}>»", "«»{}[]<>") ? "Valid\n" : "Invalid\n"; // ✅ Valid
echo is_valid_brackets("({[})", "()[]{}") ? "Valid\n" : "Invalid\n";      // ❌ Invalid
