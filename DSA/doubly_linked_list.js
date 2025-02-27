class DoublyNode {
    constructor(data, next = null, prev = null) {
        this.data = data;
        this.next = next;
        this.prev = prev;
    }
}

class DoublyLinkedList {
    constructor() {
        this.head = null;
        this.tail = null;
    }

    // Insert at the end
    insertLast(data) {
        let node = new DoublyNode(data);
        if (!this.head) {
            this.head = this.tail = node;
            return;
        }
        this.tail.next = node;
        node.prev = this.tail;
        this.tail = node;
    }

    // Print Forward
    printForward() {
        let current = this.head;
        let output = [];
        while (current) {
            output.push(current.data);
            current = current.next;
        }
        console.log("Doubly Linked List (Forward):", output.join(" ⇄ "));
    }

    // Print Backward
    printBackward() {
        let current = this.tail;
        let output = [];
        while (current) {
            output.push(current.data);
            current = current.prev;
        }
        console.log("Doubly Linked List (Backward):", output.join(" ⇄ "));
    }
}

// Example Usage
const dll = new DoublyLinkedList();
dll.insertLast(10);
dll.insertLast(20);
dll.insertLast(30);
dll.printForward();  // Output: 10 ⇄ 20 ⇄ 30
dll.printBackward(); // Output: 30 ⇄ 20 ⇄ 10
