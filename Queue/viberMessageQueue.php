<?php

class ViberMessageQueue {
    private array $messages; // Message storage array //[null, null, null, null, null] -> ["Hi", "How", "Ok", "Bye", "Good"]
    private int $front; // Starting index of the oldest message //0 //1 //2
    private int $rear; // Index to insert next message //0 //1 //2 //3 //4 //0
    private int $capacity; // Max messages //5
    private int $size; // Current number of messages //0 //1 //2 //3 //4 //5

    public function __construct(int $capacity = 10) {
        $this->capacity = $capacity; // Set max capacity //5
        $this->messages = array_fill(0, $capacity, null); // Initialize array with nulls //[null, null, null, null, null]
        $this->front = 0; // Start from 0
        $this->rear = 0; // Insert index also 0
        $this->size = 0; // Initially empty
    }

    public function addMessage(string $message): void {
        $this->messages[$this->rear] = $message; // Add message at rear index //["Hi", null, null, null, null]
        $this->rear = ($this->rear + 1) % $this->capacity; // Move rear circularly //(0+1)%5 = 1 //(4+1)%5 = 0

        if ($this->size < $this->capacity) { // If not full //0<5 //1<5 ...
            $this->size++; // Just increase size
        } else {
            $this->front = ($this->front + 1) % $this->capacity; // If full, move front forward to remove oldest
        }
    }

    public function getMessages(): array {
        $result = []; // Final array to return messages
        for ($i = 0; $i < $this->size; $i++) { // Loop through size count
            $index = ($this->front + $i) % $this->capacity; // Correct circular index
            $result[] = $this->messages[$index]; // Add message to result
        }
        return $result; // Return ordered messages
    }
}
$q = new ViberMessageQueue(5); // Max 5 messages

$q->addMessage("Hi");
$q->addMessage("How are you?");
$q->addMessage("I'm fine");
$q->addMessage("See you");
$q->addMessage("Bye");

print_r($q->getMessages()); // [Hi, How are you?, I'm fine, See you, Bye]

$q->addMessage("New Msg 1"); // Overwrites "Hi"
$q->addMessage("New Msg 2"); // Overwrites "How are you?"
// $q->addMessage("New Msg 3"); 
// $q->addMessage("New Msg 4"); 
// $q->addMessage("New Msg 5"); 
// $q->addMessage("New Msg 6"); 

print_r($q->getMessages()); // [I'm fine, See you, Bye, New Msg 1, New Msg 2]
