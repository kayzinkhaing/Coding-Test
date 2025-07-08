<?php

class CustomerQueue
{
    private array $queue = [];
    private array $skipped = [];
    private array $callData = [];
    private ?string $currentCustomer = null;

    public function addCustomer(string $name): void
    {
        $this->queue[] = $name;
    }

    public function callNext(): void
    {
        if ($this->currentCustomer !== null) {//A
            $name = $this->currentCustomer;//A
            $data = $this->callData[$name];//A
            // echo "This is ";
            // var_dump($data);
            // die();

            $elapsed = time() - $data['first_call_time'];
            $calls = $data['call_count'];

            if ($calls < 3 && $elapsed <= 12) {
                $this->callData[$name]['call_count']++;
                echo "Calling again ({$this->callData[$name]['call_count']}): $name (elapsed: {$elapsed}s)\n";
                return;
            } else {
                echo "$name did not respond in time. Skipping.\n";
                $this->skipped[$name] = $name;
                $this->currentCustomer = null;
                unset($this->callData[$name]);
            }
        }

        if (empty($this->queue)) {
            echo "No more customers in queue.\n";
            return;
        }

        $name = array_shift($this->queue);
        $this->currentCustomer = $name;
        $this->callData[$name] = [
            'first_call_time' => time(),
            'call_count' => 1
        ];

        echo "Calling: $name\n";
    }

    public function completeService(): void
    {
        if ($this->currentCustomer === null) {
            echo "No customer is currently being served.\n";
            return;
        }

        $name = $this->currentCustomer;
        echo "Finished serving: $name\n";

        unset($this->callData[$name]);
        $this->currentCustomer = null;
    }

    public function returnSkipped(string $name): void
    {
        if (isset($this->skipped[$name])) {
            unset($this->skipped[$name]);
            array_unshift($this->queue, $name);
            echo "Returned skipped customer: $name\n";
        } else {
            echo "$name was not found in skipped list.\n";
        }
    }

    public function getSkipped(): array
    {
        return array_values($this->skipped);
    }
}
$q = new CustomerQueue();
$q->addCustomer("A");
$q->addCustomer("B");
$q->addCustomer("C");

$q->callNext(); // A - 1st call
sleep(4);
$q->callNext(); // A - 2nd call
sleep(4);
$q->callNext(); // A - 3rd call
sleep(4);
$q->callNext(); // Skips A

$q->callNext(); // B - 1st call
$q->completeService(); // B done

$q->returnSkipped("A");
$q->callNext(); // A - 1st retry call
$q->completeService(); // A done

$q->callNext(); // C
$q->completeService();

$q->callNext(); // no more
