<?php

class CircularQueue {
    private array $queue;
    private int $front;
    private int $rear;
    private int $capacity;
    private int $size;

    public function __construct(int $capacity) {
        $this->capacity = $capacity; //5
        $this->queue = array_fill(0, $capacity, null); //[null, null, null, null, null]
        $this->front = 0; //0
        $this->rear = 0;  //0
        $this->size = 0;  //0
    }

    public function enqueue(mixed $value): void {//1  //2  //3 //4 //5 //6 //7 //8 //9 //10 //11
        $this->queue[$this->rear] = $value; //[1, null, null, null, null] //[1, 2, null, null, null] //[1, 2, 3, null, null] //[1, 2, 3, 4, null] //[1, 2, 3, 4, 5] //[6, 2, 3, 4, 5] //[6, 7, 3, 4, 5] //[6, 7, 8, 4, 5] //[6, 7, 8, 9, 5] //[6, 7, 8, 9, 10] //[11, 7, 8, 9, 10]
        $this->rear = ($this->rear + 1) % $this->capacity; //0+1%5=1 //1+1%5=2 //2+1%5=3 //3+1%5=4 //4+1%5=0 //0+1%5=1 //1+1%5=2 //2+1%5=3 //3+1%5=4 //4+1%5=0 //0+1%5=1
        if ($this->size < $this->capacity) {
            $this->size++; //1 //2 //3 //4 //5
        } else {
            $this->front = ($this->front + 1) % $this->capacity; //0+1%5=1 //1+1%5=2 //2+1%5=3 //3+1%5=4 //4+1%5=0 //0+1%5=1
        }
    }

    public function dequeue(): mixed {//[1, 2, 3, 4, 5] //[6, 7, 8, 9, 10] //[11, 7, 8, 9, 10]
        if ($this->size === 0) {//5==0(false)
            echo "Queue is empty\n";
            return null;
        }
        $value = $this->queue[$this->front]; //$this->queue[0]=1 //$this->queue[1]=2
        $this->queue[$this->front] = null; //[null, 2, 3, 4, 5] //[11, null, 8, 9, 10]
        $this->front = ($this->front + 1) % $this->capacity; //0+1%5=1 //1+1%5=2
        $this->size--; //5-1=4 //4-1=3
        return $value;
    }

    public function getQueue(): array {
        return $this->queue;
    }
}

$q = new CircularQueue(5);

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->enqueue(4);
$q->enqueue(5);

print_r($q->getQueue());

$q->enqueue(6);
$q->enqueue(7);
$q->enqueue(8);
$q->enqueue(9);
$q->enqueue(10);
$q->enqueue(11);

print_r($q->getQueue());
