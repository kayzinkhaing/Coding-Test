class Node {
    constructor (data , next =null){
        this.data=data;
        this.next=next;
    }
}
class LinkedList {
    constructor(){
        this.head = null;
    }
    insertFirst(data){
        this.head=new Node(data,this.head);
    }
    size(){
       let count=0;
       let node=this.head;
       while(node){
        count++;
        node=node.next;
       } 
       return count;
    }

    getFirst(){
        return this.head;
    }

    getLast(){
        if(!this.head){
            return null;
        }
        let node=this.head;
        while(node){
            if(!node.next){
                return node;
            }
            node=node.next;
        }
    }

    removeFirst(){
        if(!this.head){
            return;
        }
        return this.head=this.head.next;
    }

    removeLast(){
        
    }

}

const linkedList=new LinkedList();
const node=new Node("hey");
// const node=new Node("hey","hi");
linkedList.head=node;
console.log("Linked last Node =>",linkedList);
console.log("       ************     ");
linkedList.insertFirst("hello");
console.log("Insert first data is ",linkedList);
console.log("       ************     ");
console.log("Counting for all node =>",linkedList.size());
console.log("       ************     ");
console.log("Getting First Node =>  ", linkedList.getFirst());
console.log("       ************     ");
console.log("Finding the last node is =>", linkedList.getLast());
console.log("       ************     ");
console.log("Removing the first node is =>", linkedList.removeFirst());