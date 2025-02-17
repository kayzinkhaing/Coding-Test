const numbers=[1,2,3,4,2];
const doubled=numbers.map((number)=>number*2);
console.log(doubled); // [2,4,6]

//even numbers
const even=numbers.filter((number)=>number%2===0);
console.log(even); // [2]

//sum of numbers
const sum=numbers.reduce((acc,number)=>acc+number,5);
console.log(sum); //15

//first even number
const firstEven=numbers.find((number)=>number%2===0);
console.log(firstEven); //2

let num=[1,2,3];
let allPositive =num.every((num)=>num>0);
console.log(allPositive);

let number7=[1,2,3,-1];
let index=number7.findIndex((num)=>num%2===0);
console.log(index);


let hasTwo=numbers.includes(2);
console.log(hasTwo);

//flattening 2 level
let nested=[1,[2,3,[4,5]],6];
let flat=nested.flat(2);
console.log(flat);

//flapMap
let arr=[1,2,3,4];
let flatMap=arr.flatMap((num)=>[num*2]);
console.log(flatMap);

let str='Hello';
let strArray=Array.from(str);
console.log(strArray);


//slice
let arr1=[1,2,3,4,5];
let sliced=arr1.slice(1,3);
console.log(sliced);