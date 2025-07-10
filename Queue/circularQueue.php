<?php

class CircularQueue {
    private array $queue;
    private int $front;
    private int $rear;
    private int $capacity;
    private int $size;

    public function __construct(int $capacity) {
        $this->capacity = $capacity;//5
        $this->queue = array_fill(0, $capacity, null);//[null, null, null, null, null]   //[1, 2, null, null, null]  //[1, 2, 3, null, null] //[null, 2, 3, null, null] //[null, 2, 3, 6, null] //[null, 2, 3, 6, 7] //[8, 2, 3, 6, 7]
        $this->front = 0;//1 //2
        $this->rear = 0;//1 //2 //3 //4 //0 //1
        $this->size = 0;//1 //2 //3 //2 //3 //4 //5
    }

    public function enqueue(mixed $value): void {//1  //2  //3 //6 //7 //8  //9
        if ($this->size >= $this->capacity) {//0 >= 5  
            // throw new Exception("Cannot enqueue: the circular queue is full.\n");
            echo "Cannot enqueue: the circular queue is full.\n";
            return;
        }
        $this->queue[$this->rear] = $value;//[1, null, null, null, null]  //[1, 2, null, null, null]  //[1, 2, 3, null, null] //[null, 2, 3, 6, null] //[null, 2, 3, 6, 7] //[8, 2, 3, 6, 7] //[8, 9, 3, 6, 7]
        $this->rear = ($this->rear + 1) % $this->capacity;// 0 + 1 % 5 =1 //1 + 1 % 5 = 2 //2 + 1 % 5 = 3 //3+1 %5= 4 //4+1 %5= 0 //0+1 %5= 1 ////1+1 %5= 2
        $this->size++;//1  //2  //3  //3 //4 //5
    }

    // public function dequeue(): mixed {//[1, 2, 3, null, null]  //[8, 2, 3, 6, 7]
    //     if ($this->size === 0) {//3==0(false) //5==0(false)
    //         throw new Exception("Cannot dequeue: the circular queue is empty.\n");
    //         echo "Queue is empty\n";
    //         return null;
    //     }
    //     $value = $this->queue[$this->front];// 1  //$this->queue[2]=3
    //     $this->queue[$this->front] = null;//[null, 2, 3, null, null]  //[8, 2, null, 6, 7]
    //     $this->front = ($this->front + 1) % $this->capacity;//0 + 1 % 5 =1 //2+1 % 5=3
    //     $this->size--;//3-1=2 //5-1=4
    //     return $value;
    // }

    public function getQueue(): array {
        return $this->queue;
    }
}


$q = new CircularQueue(5);

$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
// $q->enqueue(4);
// $q->enqueue(5);
// $q->enqueue(6);



// print_r($q->getQueue());

// $q->dequeue();

$q->enqueue(6);
$q->enqueue(7);
$q->enqueue(8);
// $q->enqueue(9);

$q->dequeue();
$q->dequeue();

$q->enqueue(10);
// $q->enqueue(11);

print_r($q->getQueue());
