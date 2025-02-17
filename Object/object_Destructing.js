const person={
    name:'John',
    address:{
        street:'123 Main St',
        city:'New York',
        zip:10001,
    },

    };

const{
    name,
    address:{street,city,zip},
}=person;
console.log(name);
console.log(street);
console.log(city);

//Renaming
const personObj={
    firstName:'John',
    lastName:'Doe',
    age:30,
};
const{ firstName:first , lastName:last,age:years }=personObj;
console.log(first);
console.log(last);
console.log(years);


// Default values
const personDefault={
    firstName:'John',
    lastName:'Doe',
};
const{ firstName,lastName,age=30 }=personDefault;
console.log(firstName);
console.log(lastName);
console.log(age);