const products = [
    { id : 1, name: 'Laptop', price: 1000 ,category:'Electronics'},
    { id : 2, name: 'Keyboard', price: 100 ,category:'Electronics'},
    { id : 3, name: 'Monitor', price: 300 ,category:'Electronics'},
    { id : 4, name: 'Mouse', price: 50 ,category:'Electronics'},
    { id : 5, name: 'T-shirt', price: 10 ,category:'Clothing'},
    { id : 6, name: 'Jeans', price: 50 ,category:'Clothing'},       
    { id : 7, name: 'Hat', price: 200,category:'Clothing'},
    { id : 8, name: 'Socks', price: 500 ,category:'Clothing'},
    { id : 9, name: 'Tablet', price: 500 ,category:'Electronics'},
    { id : 10, name: 'Phone', price: 300 ,category:'Electronics'},
];
//Accessing the name of the second product
console.log(products[1].name); // Keyboard

console.log('------------------------------------');

//looping over the array to display product details
products.forEach(product => {
    console.log(`Product Name: ${product.name}, Price: ${product.price}, Category: ${product.category}`);
});

console.log('------------------------------------');

//Filter with Es6 function
const electronics = products.filter(product => product.category === 'Electronics');

console.log(electronics);

//Map function
const discountedProducts = products.map((product => ({
    ...product,
    price: product.price * 0.9,
})));

console.log(discountedProducts);
    
        