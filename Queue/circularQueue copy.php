<?php

class CircularQueue
{
    private array $queue;
    private int $size;
    private int $front;
    private int $rear;

    public function __construct(int $size)
    {
        $this->size = $size;
        $this->queue = array_fill(0, $size, null);//[null, null, null, null, null]  //[A, B, null, null, null]  //[A, B, C, null, null] //[null, B, C, null, null] 
        $this->front = -1;//0  //1
        $this->rear = -1;//0  //1  //2
    }

    public function enqueue(string $value): void     //A  //B  //C  //F  //G
    {
        if (($this->rear + 1) % $this->size === $this->front) {//-1 +1 % 5 ===-1 (false)  //0 +1 % 5 ===-1 (false)  //1 +1 % 5 ===-1 (false)  //2 +1 % 5 ===-1 (false)  //2 +1 % 5 ===-1 (false)
            echo "Queue is full! Cannot add '$value'.\n";
            return;
        }

        if ($this->front === -1) {
            $this->front = 0;
        }

        $this->rear = ($this->rear + 1) % $this->size;//-1 +1 % 5 =0  //0 +1 % 5 =1  //1 +1 % 5 =2  //2 +1 % 5 =3  
        $this->queue[$this->rear] = $value;//[A, null, null, null, null]  //[A, B, null, null, null]  //[A, B, C, null, null]   //[null, B, C, F, null]
        echo "Enqueued: $value\n";
    }

    public function dequeue(): ?string  //[A, B, C, null, null] 
    {
        if ($this->front === -1) {//false
            echo "Queue is empty!\n";
            return null;
        }

        $value = $this->queue[$this->front];//$this->queue[0]=A
        $this->queue[$this->front] = null;//[null, B, C, null, null] 

        if ($this->front === $this->rear) {// 1===2 (false)
            $this->front = $this->rear = -1;
        } else {
            $this->front = ($this->front + 1) % $this->size;// 0 + 1 % 5 =1
        }

        echo "Dequeued: $value\n";
        return $value;
    }

    public function printQueue(): void //A,B,C,D,E   //F,G,C,D,E  //F,G,H,D,E// F,G,H, ,E
    {
        echo "\nQueue State:\n";
        foreach ($this->queue as $i => $v) {
            echo "[$i] " . ($v ?? "") . "\n";
        }
    }
}

// === Example Usage ===

$q = new CircularQueue(5);

$q->enqueue("A");
$q->enqueue("B");
$q->enqueue("C");
// $q->enqueue("D");
// $q->enqueue("E");

// $q->printQueue();

$q->dequeue();

$q->enqueue("F");
$q->enqueue("G"); // Should wrap around

$q->printQueue();

$q->dequeue();
$q->enqueue("H"); // Should say queue is full
$q->dequeue();
$q->dequeue(); // Should remove "F"
$q->enqueue("I"); // Should add "I" to the queue
$q->enqueue("J"); 
$q->enqueue("K"); // Should say queue is full

$q->printQueue();