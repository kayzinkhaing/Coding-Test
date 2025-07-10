<?php
class CircularQueue{
    private $queue;
    private $size;
    private $front;
    private $rear;
    public function __construct($size){
        $this->size = $size;
        $this->queue =array_fill(0, $size, null);
        $this->front = -1;//Empty
        $this->rear = -1;//Empty
    }
    public function enqueue($item){ // Check if full
        if(($this->front == 0 && $this->rear == $this->size-1) || ($this->rear+1)% $this->size == $this->front){
            echo "Queue is full\n";
            return;
        }
        if($this->front == -1){
            $this->front = 0;
        }
        $this->rear = ($this->rear +1 )%$this->size;
        $this->queue[$this->rear] = $item;
        echo "Insert Value\n";
    }
    public function dequeue(){
        if($this->front == -1){
            echo "Queue is empty\n";
            return;
        }
        $data = $this->queue[$this->front];
        $this->queue[$this->front] = null;
        if($this->front == $this->rear){// Last element removed
            $this->front = -1;
            $this->rear = -1;
        }
        else{
            $this->front = ($this->front +1 ) % $this->size;
        }
        echo "Removed: $data\n";
        return $data;
    }
    public function display(){
        if($this->front == -1){
            echo "Queue is empty\n";
            return;
        }
        echo "Queue: ";
        $i = $this->front;
        while(true){
            echo $this->queue[$i]. " ";
            if($i==$this->rear) break;
            $i = ($i + 1)% $this->size;        
        }
    echo "\n";
}
}
$q = new CircularQueue(5);
$q->enqueue(1);
$q->enqueue(2);
$q->enqueue(3);
$q->enqueue(4);
$q->enqueue(5);//should fill the queue
$q->enqueue(6);// should show "Queue is full"
$q->display();
$q->dequeue();
$q->dequeue();
$q->display();
$q->enqueue(6);
$q->enqueue(7);
$q->display();
?>