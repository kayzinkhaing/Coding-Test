/*
Deserialization is the reverse process of serialization—it converts the serialized format back into an object that can be used in the program.

🔹 Why Use Deserialization?

To read stored data from a file or database.
To receive data from APIs and process it as an object.
*/ 


const jsonString= '{"name":"Kay","age":24,"city":"Yangon"}';
const deserializedObj=JSON.parse(jsonString);
console.log(deserializedObj); 

const jsonData = '{"id":1,"name":"Alice","dateOfBirth":"2000-01-01"}';

const userObject = JSON.parse(jsonData, (key, value) => {
    if (key === "dateOfBirth") {
        return new Date(value);  // Convert string to Date object
    }
    return value;
});

console.log(userObject.dateOfBirth instanceof Date);  // Output: true


const data = {
    user: "Alice",
    posts: [
        { id: 1, title: "Hello World" },
        { id: 2, title: "Learning JS" }
    ],
    isActive: true
};

// 1️⃣ Serialize the object
const serializedData = JSON.stringify(data);

// 2️⃣ Deserialize it back
const deserializedData = JSON.parse(serializedData);

// 3️⃣ Print both
console.log("Serialized:", serializedData);
console.log("Deserialized:", deserializedData);


// Custom sort function (bubble sort) without using the built-in sort method
function customSort(arr) {
    for (let i = 0; i < arr.length - 1; i++) {
        for (let j = 0; j < arr.length - i - 1; j++) {
            if (arr[j] > arr[j + 1]) {
                // Swap elements
                let temp = arr[j];
                arr[j] = arr[j + 1];
                arr[j + 1] = temp;
            }
        }
    }
    return arr;
}

const unsortedArray = [5, 2, 9, 1, 5, 6];
const sortedArray = customSort(unsortedArray.slice()); 
console.log("Unsorted:", unsortedArray);
console.log("Sorted:", sortedArray);

