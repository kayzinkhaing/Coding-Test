<?php

class Task {
    public $data;
    public $id;
    public $readyAfter;
    public $processed = false;

    public function __construct($data, $readyAfter) {//A,20
        $this->id = $data;//A
        $this->readyAfter = $readyAfter;//20
    }

    public function isReady($time) {
        // var_dump($time);
        // exit();
        return $time >= $this->readyAfter && !$this->processed;//  0 >= 20 && true
    }
}

class SmartQueue {
    private $tasks;
    private $skipped = [];
    private $time = 0;
    private $timeLimit = 1;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function run() {
        $index = 0;

        while (!$this->allProcessed()) {//true
            // var_dump(!$this->allProcessed());
            // exit();
            if ($index < count($this->tasks)) {
                $task = $this->tasks[$index];//A
                if ($task->isReady($this->time)) { //
                    echo "{$task->id} is running...\n";
                    $this->process($task);
                } else {
                    echo "{$task->id} is not ready → skipped\n";
                    $this->skipped[] = $task;//A 
                }
                $index++;
                $this->advanceTime();
                $this->recheckSkipped();
            } else {
                $this->advanceTime();
                $this->recheckSkipped();
            }
        }

        echo "All tasks completed.\n";
    }

    private function process($task) {
        echo "Processed Task {$task->id} at time {$this->time}s\n";
        $task->processed = true;
    }

    private function recheckSkipped() {
        $remaining = [];
        foreach ($this->skipped as $task) {
            if ($task->isReady($this->time)) {
                echo "{$task->id} is running...\n";
                $this->process($task);
            } else {
                $remaining[] = $task;
            }
        }
        $this->skipped = $remaining;
    }

    private function advanceTime() {
        sleep($this->timeLimit);
        $this->time += $this->timeLimit;
    }

    private function allProcessed() {
        foreach ($this->tasks as $task) {
            if (!$task->processed) return false;
        }
        return true;
    }
}

$tasks = [
    new Task('A', 20),
    new Task('B', 0),
    new Task('C', 15),
    new Task('D', 5),
];

$queue = new SmartQueue($tasks);
$queue->run();
