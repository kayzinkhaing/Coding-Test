const person = { name: 'Zaw', age: 28 };
const copyPerson = { ...person };

console.log(copyPerson);
// Output: { name: 'John', age: 30 }



const job = { title: 'Developer', company: 'Tech Co' };

const employee = { ...person, ...job };

console.log(employee);
// Output: { name: 'John', age: 30, title: 'Developer', company: 'Tech Co' }



const updatedPerson = { ...person, age: 35 };  // Overriding age

console.log(updatedPerson);
// Output: { name: 'John', age: 35 }


const newPerson = { ...person, country: 'USA' };

console.log(newPerson);
// Output: { name: 'John', age: 30, country: 'USA' }


const people = { name: 'John', age: 30, city: 'New York' };
const { city, ...newPersons } = people;

console.log(newPersons);
// Output: { name: 'John', age: 30 }


const girl = { name: 'Alice', age: 25 };

function greet({ name, age }) {
  console.log(`Hello, my name is ${name} and I am ${age} years old.`);
}

greet({ ...girl });
// Output: Hello, my name is Alice and I am 25 years old.
