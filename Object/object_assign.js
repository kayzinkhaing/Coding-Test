const person={ name:'Alice' };
const age={ age:30 };

const newPerson=Object.assign(person,age);
console.log(newPerson); // { name: 'Alice', age: 30 }