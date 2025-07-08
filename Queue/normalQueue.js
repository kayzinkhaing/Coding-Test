class Queue {
    constructor(){
        this.data =[];
    }
    add(element){
        this.data.unshift(element);
    }
    remove(){
        if(this.data.length >0){
            this.data.pop();
        }
    }
}
Queue = new Queue();
Queue.add(1);
Queue.add(2);
Queue.add(3);
Queue.add(4);
Queue.add(5);
console.log("================adding number into array");
console.log(Queue);
console.log("================removing number from array");
Queue.remove();
console.log(Queue);
