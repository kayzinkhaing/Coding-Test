// for Loop
// Used when the number of iterations is known. It has three parts:

// Initialization: Executes once before the loop starts.
// Condition: If true, the loop runs; if false, it stops.
// Increment/Decrement: Runs after each loop iteration.

//When to use?
// When you know how many times the loop should run.
// Mostly used for iterating over arrays with an index.

for (let i = 1; i <= 5; i++) {
    console.log(i);
}
function reverseString(str) {
    let reversed = "";
    for (let i = str.length - 1; i >= 0; i--) {
        reversed += str[i];
    }
    return reversed;
}

console.log(reverseString("hello")); // Output: "olleh"
