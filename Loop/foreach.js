//Used for looping through an array.
// Cannot be stopped with break or continue.

const fruits = ["apple", "banana", "cherry"];
fruits.forEach(fruit => console.log(fruit));


const numbers = [1, 2, 3, 4];
numbers.forEach((num, index, arr) => arr[index] = num * 2);
console.log(numbers); // Output: [2, 4, 6, 8]
