function isPlaindrome(str){
    strClean = '';
    for(let i=0 ; i < str.length ; i++){
        let char = str[i].toLowerCase();
        if( char < 'a' && char > 'z' || char < 0 && char > 9){
            strClean += char;
        }
        left = strClean[i];
        right = strClean.length - i - 1;
        if(left < right){
            if(strClean[left] !== strClean[right]){
                return false;
            }
            left++;
            right--;
        }
        return true;
    }
}

// Test Cases
console.log(isPlaindrome("A man, a plan, a canal: Panama")); // true
console.log(isPlaindrome("race a car")); // false
console.log(isPlaindrome("")); // true


function isPlaindrome(str){
let strClean='';
for ( let $i=0; $i < str.length ; $i++){
let char = str[i].toLowerCase();
if(char > 'a' && char < 'z' || char > 0 && char < 9 ) {
 strClean += char[i];
}
left = strClean[i];
right =strClean[i]-i -1;
if(left<right){
if(strClean[left] !== strClean[rigt]){
 return false;
}
left++;
right--;
}

return true;
}
}
let dd=isPlaindrome('hello');
console.log("The result is :" + dd );