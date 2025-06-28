<?php
//plaindrome check //don't use built-in functions
function isPalindrome($str) {
    $length = strlen($str);
    for ($i = 0; $i < $length / 2; $i++) {
        if ($str[$i] !== $str[$length - $i - 1]) {
            return false; // Not a palindrome
        }
    }
    return true; // Is a palindrome
}
// Example usage
$input = "hellos"; // You can change this input to test other strings
if (isPalindrome($input)) {
    echo "$input is a palindrome.";
} else {
    echo "$input is not a palindrome.";
}
?>