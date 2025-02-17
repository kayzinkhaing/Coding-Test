const dynamicKey= 'age';
const user= {
    name: 'Zaw Myo',
    age: 28,
    email: 'zawmyo894@gmail.com',
    
} ;
console.log(user[dynamicKey]); // 28

//dynamic key name
const propertyName = 'email';
const userObj = {
    name: 'Zaw Myo',
    [propertyName]: 'zawzaw101@gmail.com',
};
console.log(userObj.email); //