function isPalindrome(str) {
    // Remove non-alphanumeric characters and convert to lowercase
    let cleanedStr = '';
    for (let i = 0; i < str.length; i++) {
        let char = str[i].toLowerCase();
        // Only allow a-z and 0-9 characters
        if ((char >= 'a' && char <= 'z') || (char >= '0' && char <= '9')) {
            cleanedStr += char;
        }
    }

    // Use two-pointer technique to check for palindrome
    let left = 0;
    let right = cleanedStr.length - 1;
    // console.log(right);
    while (left < right) {
        if (cleanedStr[left] !== cleanedStr[right]) {
            return false;
        }
        left++;
        right--;
    }
    return true;
}

// Test Cases
console.log(isPalindrome('A man, a plan, a canal, Panama')); // true
console.log(isPalindrome('hello')); // false
console.log(isPalindrome('racecar')); // true
console.log(isPalindrome('No lemon, no melon!')); // true
