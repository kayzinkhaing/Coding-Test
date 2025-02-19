//Skips the current iteration and moves to the next.

for (let i = 1; i <= 5; i++) {
    if (i === 3) continue;
    console.log(i);
}
console.log("________________");
for (let i = 1; i <= 10; i++) {
    if (i % 2 !== 0) continue;
    console.log(i);
}
