function greet(name){
    console.log('Hello,' +name);
}

function processUserInput(callback){
    console.log(callback);
    const name='John';
    callback(name);//calling the callback function passed to processUserInput
}
processUserInput(greet);//here , greet is passed as a callback

//Asynchronous Operations
setTimeout(function(){
    console.log('This is a delayed message');
}, 5000);//The function passed to setTimeout is a callback

