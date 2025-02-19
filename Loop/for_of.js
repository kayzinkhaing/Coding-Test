//Used for iterating over arrays, strings, maps, and sets.

const colors = ["red", "green", "blue"];
for (let color of colors) {
    console.log(color);
}


const numbers = [10, 20, 30];
let sum = 0;
for (let num of numbers) {
    sum += num;
}
console.log(sum); // Output: 60
