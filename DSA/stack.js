class Stack{
    constructor() {
        this.data = [];
    }
    add(element){
        this.data.push(element);
    }
    remove(){
        return this.data.pop();
    }
    peek(){
        if(this.data.length>0){
            return true;
        }
        return false;
    }
}
Stack = new Stack();
for(let i=1;i<6;i++){
    Stack.add(i);
}
console.log("==========Adding item into array =======");
console.log(Stack);
console.log("==========Removing item from array =======");
Stack.remove();
console.log(Stack);

