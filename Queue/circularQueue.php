<?php

class CircularQueue {
    private $queue;
    private $size;
    private $front;
    private $rear;

    public function __construct($size) {
        $this->size = $size;
        $this->queue = array_fill(0, $size, null);
        $this->front = -1;
        $this->rear = -1;
    }

    // Enqueue
    public function enqueue($value) {
        if (($this->rear + 1) % $this->size == $this->front) {
            echo "Queue is Full\n";
            return;
        }

        if ($this->front == -1) {
            $this->front = 0;
        }

        $this->rear = ($this->rear + 1) % $this->size;
        $this->queue[$this->rear] = $value;
    }

    // Dequeue
    public function dequeue() {
        if ($this->front == -1) {
            echo "Queue is Empty\n";
            return null;
        }

        $removed = $this->queue[$this->front];
        $this->queue[$this->front] = null;

        if ($this->front == $this->rear) {
            $this->front = -1;
            $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->size;
        }

        return $removed;
    }

    // Display Queue
    public function display() {
        if ($this->front == -1) {
            echo "Queue is Empty\n";
            return;
        }

        echo "Queue: ";
        $i = $this->front;
        while (true) {
            echo $this->queue[$i] . " ";
            if ($i == $this->rear) break;
            $i = ($i + 1) % $this->size;
        }
        echo "\n";
    }
}
