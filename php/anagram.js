// function areAnagrams(str1, str2) {
//     if (str1.length !== str2.length) return false;

//     const count = {};

//     for (let char of str1) {
//         count[char] = (count[char] || 0) + 1;
//     }
//     for (let char2 of str2) {
//         if (!count[char2]) return false;
//         count[char2]--;
//     }
//     return true;
// }
// // Example usage
// console.log(areAnagrams("listen", "silent")); // true
// console.log(areAnagrams("hello", "world")); // false
// console.log(areAnagrams("triangle", "integral")); // true

function anagram (str1, str2){
	if (str1.length !== str2.length) return false;
	count ={};
	for( let char of str1) {

	count[char] = (count[char] || 0) +1;

	}
	for (let char2 of str2) {
	 if(!count[char2]) return false;
     count[char2]--;
}
return true;
}
console.log(anagram('listen','silent'));