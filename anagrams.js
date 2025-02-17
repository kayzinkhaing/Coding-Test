function areAnagrams(str1, str2) {
  if (str1.length !==str2.length) {
    return false;
  }

  const count = {};
  for (let char of str1) {
    count[char] =(count[char]|| 0)+1;
  }
  console.log(count);
for(let char2 of str2){
    if (!count[char2]) return false;
    count[char2]--;
}
  console.log(count);
  return true;

}
console.log(areAnagrams("listen", "silent")); // true
console.log(areAnagrams("hello", "bye")); // false

