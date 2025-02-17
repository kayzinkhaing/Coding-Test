const company={
    name: 'GeekyAnts',
    address:{
        street:'123 Main St',
        city:'Techville',
        zipCode:10001,
    },
    employees:[
        {name : 'Alice', role : 'Developer'},
        {name : 'Bob', role : 'Designer'},
        {name : 'Charlie', role : 'Manager'},
    ],
};
//Accessing nested object(address)
console.log(company.address.city);

//Accessing nested object(employees)
console.log(company.employees[0].name);
console.log(company.employees[1].role);

