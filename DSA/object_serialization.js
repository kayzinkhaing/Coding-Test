/*
    What is Serialization?
Serialization is the process of converting an object into a format (like JSON or binary) so it can be stored or transmitted and later reconstructed.

🔹 Why Use Serialization?

To store objects in files, databases, or local storage.
To send data over networks (e.g., APIs).
To cache data efficiently.
🔹 Common Serialization Formats:

JSON (JavaScript Object Notation)
XML (Extensible Markup Language)
Binary (used in advanced cases like Protocol Buffers, MessagePack)
*/

const obj={
    name: 'Kay',
    age: 24,
    city: 'Yangon',

};
const jsonString =JSON.stringify(obj);
console.log(jsonString);
 

//in object, we can't change to string for function 
const company={
    name: 'ITVisionHub',
    greet: function(){
        return 'This company is that find for getting a job with programming languages';
    },
};
const serializedCompany =JSON.stringify(company);
console.log(serializedCompany);

const user = {
    id: 1,
    name: "Alice",
    password: "secret",
    toJSON() {  // Define custom serialization
        return { id: this.id, name: this.name };
    }
};

console.log(JSON.stringify(user));  
// Output: {"id":1,"name":"Alice"} (password is excluded)
