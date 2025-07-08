class Stack {
    constructor() {
        this.data = [];
    }

    push(element) {
        this.data.push(element);
    }

    pop() {
        return this.data.pop();
    }

    peek() {
        return this.data[this.data.length - 1];
    }

    isEmpty() {
        return this.data.length === 0;
    }
}

class Queue {
    constructor() {
        this.stack1 = new Stack();
        this.stack2 = new Stack();
    }

    add(element) {
        this.stack1.push(element);
    }

    remove() {
        while (!this.stack1.isEmpty()) {
            this.stack2.push(this.stack1.pop());
        }

        const removed = this.stack2.pop();

        while (!this.stack2.isEmpty()) {
            this.stack1.push(this.stack2.pop());
        }

        return removed;
    }
}

// Usage
const queue = new Queue();
queue.add(1);
queue.add(2);
queue.add(3);
queue.add(4);
queue.add(5);

console.log("Removed:", queue.remove());
queue.add(7);
queue.add(8);
console.log("Removed:", queue.remove());
console.log("Removed:", queue.remove());

// queue.add(8);

console.log("Queue internal state:", queue.stack1.data); // Shows remaining queue
