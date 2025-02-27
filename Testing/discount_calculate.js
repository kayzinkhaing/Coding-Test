//const products = [ 
//     { name: "P1", price: 500 },
//     { name: "P2", price: 1000 },
//     { name: "p3", price: 300 },
//     { name: "p3", price: 1000 }
// ];

// const discountedPrices = Object.fromEntries(
//     [...new Set(products.map(p => p.price))].map(price => [price, price * 0.9])
// );


// const discountedProducts = products.map(p => ({ ...p, price: discountedPrices[p.price] }));

// console.log(discountedProducts);

const products = {
    p1: { price: 1000, discount: 10 },
    p2: { price: 1500, discount: 7 },
    p3: { price: 1000, discount: 10 },
    p4: { price: 2000, discount: 5 },
    p5: { price: 4000, discount: 10 }
};


const discountSave = {}; 
const discountedProducts = {};

for (const [key, { price, discount }] of Object.entries(products)) {
    const inputValue = price + '-' + discount;
    // console.log(inputValue);

 
    if (!discountSave[inputValue]) {
        discountSave[inputValue] = getDiscount(price, discount);
        // console.log(discountSave[inputValue]); 
    }
    
    discountedProducts[key] = discountSave[inputValue]; 
    // console.log(discountedProducts[key]);
}
function getDiscount(price, discount) {
    return price - (price * (discount / 100));
}

console.log("Discounted Products:", discountedProducts);



