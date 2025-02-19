//Stops the loop completely when a condition is met.

for (let i = 1; i <= 5; i++) {
    if (i === 3) break;
    console.log(i);
}


const nums = [1, 3, 5, 8, 10];
for (let num of nums) {
    if (num % 2 === 0) {
        console.log("First even number:", num);
        break;
    }
}
