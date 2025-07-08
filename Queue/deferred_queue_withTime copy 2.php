<?php

class CustomerQueue
{
    private array $queue = [];
    private array $priorityQueue = [];
    private array $returnedQueue = [];
    private array $skipped = [];
    private ?array $currentlyServing = null;

    // Add a regular customer
    public function addCustomer(string $name): void
    {
        $this->queue[] = ['name' => $name];
        echo "Customer $name added to the regular queue.\n";
    }

    // Add a priority customer
    public function addPriorityCustomer(string $name): void
    {
        $this->priorityQueue[] = ['name' => $name];
        echo "Priority customer $name added to the priority queue.\n";
    }

    // Call the next customer (one at a time)
    public function callNext(): ?string
    {
        $this->cleanupMissed();

        if ($this->currentlyServing) {
            echo "Still serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        // 1. Priority queue (VIPs served immediately)
        if (!empty($this->priorityQueue)) {
            $customer = array_shift($this->priorityQueue);
            return $this->startServing($customer, 'priority');
        }

        // 2. Returned customers
        if (!empty($this->returnedQueue)) {
            $customer = array_shift($this->returnedQueue);
            return $this->startServing($customer, 'returned');
        }

        // 3. Regular queue
        if (!empty($this->queue)) {
            $customer = &$this->queue[0]; // reference first customer

            if (!isset($customer['called_at'])) {
                $customer['called_at'] = time();
                echo "Calling regular customer: {$customer['name']}\n";
            } elseif (time() - $customer['called_at'] > 60) {
                echo "Skipped (timeout): {$customer['name']}\n";
                $this->skipped[] = array_shift($this->queue); // remove from queue
                return $this->callNext(); // recursively check next
            } else {
                echo "Waiting for customer: {$customer['name']} (still within 60s)\n";
            }
        }

        echo "No available customers to serve.\n";
        return null;
    }

    // Customer arrives to be served (within time limit)
    public function beginServiceForCalledCustomer(): ?string
    {
        if ($this->currentlyServing) {
            echo "Already serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        if (!empty($this->queue)) {
            $customer = $this->queue[0];
            if (isset($customer['called_at']) && time() - $customer['called_at'] <= 60) {
                $this->currentlyServing = [
                    'name' => $customer['name'],
                    'status' => 'serving',
                    'called_at' => $customer['called_at']
                ];
                array_shift($this->queue);
                echo "Customer has arrived. Now serving: {$customer['name']}\n";
                return $customer['name'];
            }
        }

        echo "No called customer is ready to be served.\n";
        return null;
    }

    // Finish current service
    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo "Finished serving: {$this->currentlyServing['name']}\n";
            $this->currentlyServing = null;
        } else {
            echo "No customer is currently being served.\n";
        }
    }
    // Return a previously skipped customer
    public function returnSkipped(string $name): void
    {
        foreach ($this->skipped as $index => $customer) {
            if ($customer['name'] === $name) {
                unset($this->skipped[$index]);
                $this->returnedQueue[] = ['name' => $name];
                echo "$name has returned and added to the returned queue.\n";
                return;
            }
        }
        echo "$name not found in skipped list.\n";
    }
    // Clean up customers who timed out
    private function cleanupMissed(): void
    {
        foreach ($this->queue as $i => $customer) {
            if (isset($customer['called_at']) && time() - $customer['called_at'] > 60) {
                echo "Auto-skip: {$customer['name']} (timeout)\n";
                $this->skipped[] = $customer;
                unset($this->queue[$i]);
            }
        }
        // Re-index to keep the array clean
        $this->queue = array_values($this->queue);
    }

    // Start serving the given customer
    private function startServing(array $customer, string $source): string
    {
        $this->currentlyServing = [
            'name' => $customer['name'],
            'status' => 'serving',
            'called_at' => time()
        ];
        echo "Now serving {$customer['name']} from $source queue.\n";
        return $customer['name'];
    }

    // Optional: Display current queue states
    public function showQueues(): void
    {
        echo "\n--- QUEUE STATUS ---\n";
        echo "Priority Queue: " . implode(', ', array_column($this->priorityQueue, 'name')) . "\n";
        echo "Regular Queue: " . implode(', ', array_column($this->queue, 'name')) . "\n";
        echo "Returned Queue: " . implode(', ', array_column($this->returnedQueue, 'name')) . "\n";
        echo "Skipped: " . implode(', ', array_column($this->skipped, 'name')) . "\n";
        echo "Currently Serving: " . ($this->currentlyServing['name'] ?? 'None') . "\n";
        echo "---------------------\n\n";
    }
}

// require_once 'CustomerQueue.php'; // Assuming class from previous message

$q = new CustomerQueue();

// Setup queue
$q->addCustomer("A");
$q->addCustomer("B");
$q->addPriorityCustomer("VIP1");

// Track time for atomic 20s ticks
$startTime = time();
$lastCallTime = 0;

// Simulate script for 2 minutes
while (time() - $startTime < 120) {
    $now = time();

    // Atomically call callNext() every 20 seconds
    if (($now - $lastCallTime) >= 20) {
        echo "\n[AUTO CALL at " . date('H:i:s') . "]\n";
        $q->callNext();
        $lastCallTime = $now;
    }

    // Simulate service logic
    if (($now - $startTime) === 22) {
        $q->completeService(); // finish VIP1
    }

    if (($now - $startTime) === 45) {
        echo "[ Sleep simulation for A delay]\n";
        sleep(65); // A doesn't show up, should be skipped
    }

    if (($now - $startTime) === 112) {
        $q->beginServiceForCalledCustomer(); // B shows up
        $q->completeService();
    }

    if (($now - $startTime) === 115) {
        $q->returnSkipped("A");
    }

    if (($now - $startTime) === 118) {
        $q->beginServiceForCalledCustomer(); // Serve A from returned queue
        $q->completeService();
        $q->showQueues();
    }

    sleep(1); // Avoid CPU spike
}