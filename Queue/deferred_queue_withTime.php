<?php

class CustomerQueue
{
    private array $queue = [];
    private array $skipped = [];
    private array $returnedQueue = [];
    private ?array $currentlyServing = null;

    public function addCustomer(string $name): void
    {
        $this->queue[] = ['name' => $name];
    }

    public function callNext(): ?string
    {
        if ($this->currentlyServing) {
            if (time() - $this->currentlyServing['called_at'] > 12) {
                echo "Skipped: {$this->currentlyServing['name']}\n";
                $this->skipped[] = $this->currentlyServing;
                $this->currentlyServing = null;
                return $this->callNext();
            }
            echo "Still serving: {$this->currentlyServing['name']}\n";
            return null;
        }

        if (!empty($this->returnedQueue)) {
            $customer = array_shift($this->returnedQueue);
            $this->currentlyServing = [
                'name' => $customer['name'],
                'status' => 'serving',
                'called_at' => time()
            ];
            echo "Serving returned customer: {$customer['name']}\n";
            return $customer['name'];
        }

        if (!empty($this->queue)) {
            $customer = array_shift($this->queue);

            if (isset($customer['called_at']) && (time() - $customer['called_at'] > 12)) {
                echo "Skipped: {$customer['name']}\n";
                $this->skipped[] = $customer;
                return $this->callNext();
            }

            $customer['called_at'] = time();
            $this->currentlyServing = [
                'name' => $customer['name'],
                'status' => 'serving',
                'called_at' => $customer['called_at']
            ];
            echo "Calling: {$customer['name']}\n";
            return $customer['name'];
        }

        echo "No customers to call.\n";
        return null;
    }

    public function completeService(): void
    {
        if ($this->currentlyServing) {
            echo "Finished serving: {$this->currentlyServing['name']}\n";
            $this->currentlyServing = null;
        } else {
            echo "No customer is currently being served.\n";
        }
    }

    public function returnSkipped(string $name): void
    {
        foreach ($this->skipped as $index => $customer) {
            if ($customer['name'] === $name) {
                unset($this->skipped[$index]);
                $this->skipped = array_values($this->skipped);
                $this->returnedQueue[] = ['name' => $name];
                echo "$name has returned to queue.\n";
                return;
            }
        }
        echo "$name was not found in skipped list.\n";
    }
}

$q = new CustomerQueue();
$q->addCustomer("A");
$q->addCustomer("B");
$q->addCustomer("C");

$q->callNext();
sleep(13);

$q->callNext();
$q->completeService();

$q->returnSkipped("A");

$q->callNext();
$q->completeService();

$q->callNext();
$q->completeService();

$q->callNext();

?>