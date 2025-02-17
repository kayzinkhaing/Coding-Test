const numbers=[1,2,3,4,5];
const doubled =numbers.map((num) => num*2);
console.log(doubled); // [2, 4, 6, 8, 10]

const number2 = [1,2,3,4,5];
const evenNumbers = number2.filter((num) => num % 2 === 0);
console.log(evenNumbers); // [2, 4]

const number3 = [1,2,3,4,5];
const sum = number3.reduce((acc, num) => acc + num, 0);
console.log(sum); // 15

const number4 = [1,2,3,4,5];
const firstEven = number4.find((num) => num % 2 === 0);
console.log(firstEven); // 2



