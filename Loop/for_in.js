//Used for iterating over object properties (keys).

const person = { name: "Alice", age: 25, city: "New York" };
for (let key in person) {
    console.log(`${key}: ${person[key]}`);
}


const obj = { a: 1, b: 2, c: 3 };
let count = 0;
for (let key in obj) {
    count++;
}
console.log(count); // Output: 3
