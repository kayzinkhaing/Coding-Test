//sync call , blocking
function syncTask(){
    console.log('Doing a synchronous task');
}
console.log('Sync Start');
syncTask();
console.log('Sync End');

console.log('=======================');

//async call 
console.log('Async Start');

setTimeout(function(){
    console.log('This is asynchronous');
},2000);//Simulates an async operations

console.log('Async ENd');