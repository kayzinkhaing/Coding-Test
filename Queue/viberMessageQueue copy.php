<?php

class CircularQueue {
    public array $messages;
    private int $capacity;
    private int $size;
    private int $rear;

    public function __construct(int $capacity = 5) {
        $this->capacity = $capacity;
        $this->messages = array_fill(0, $capacity, null);
        $this->size = 0;
        $this->rear = 0;
    }

    public function enqueue(mixed $value): void {
        if ($this->size < $this->capacity) {
            $this->messages[$this->rear] = $value;
            $this->rear++;
            $this->size++;
        } else {
            // Shift left all elements by 1 to remove oldest
            for ($i = 1; $i < $this->capacity; $i++) {
                $this->messages[$i - 1] = $this->messages[$i];
            }
            // Add new value at last position
            $this->messages[$this->capacity - 1] = $value;
        }
    }
}

$q = new CircularQueue(5);

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->enqueue(4);
$q->enqueue(5);

print_r($q->messages); // [1, 2, 3, 4, 5]

$q->enqueue(6);
$q->enqueue(7);

print_r($q->messages); // [3, 4, 5, 6, 7]
