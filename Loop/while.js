//Used when the number of iterations is not known in advance. The condition is checked before execution.

// When to use?
// When the number of iterations is not known beforehand.
// Used when a condition needs to be checked before each iteration.

let i = 1;
while (i <= 5) {
    console.log(i);
    i++;
}


let num = 51;
while (num % 7 !== 0) {
    num++;
}
console.log(num); // Output: 56
