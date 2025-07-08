<?php

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 30000,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
        'interest_type' => 'compound',
        'compounding' => 'daily',
        'currency' => 'EUR',
        'country' => 'DE', // Germany
        'tiers' => [
            ['up_to' => 10000, 'rate' => 0.03],
            ['up_to' => 20000, 'rate' => 0.05],
            ['up_to' => null,  'rate' => 0.07],
        ]
    ],
    // ... you can add more accounts
];

$exchangeRates = [
    'EUR' => 1.1, // 1 EUR = 1.1 USD
    'USD' => 1.0
];

$taxRates = [
    'DE' => 0.25,
    'US' => 0.15
];

$holidaysByCountry = [
    'DE' => ['2023-01-01', '2023-12-25'],
    'US' => ['2023-07-04', '2023-12-25']
];

function isBusinessDay($date, $holidays) {
    $weekday = $date->format('N');
    $dateStr = $date->format('Y-m-d');
    return $weekday < 6 && !in_array($dateStr, $holidays);
}

function getTieredRate($balance, $tiers) {
    $interest = 0;
    $remaining = $balance;//30000
    $lastCap = 0;//10000//20000

    foreach ($tiers as $tier) {
        $cap = $tier['up_to'] ?? $balance;//10000 //20000 //30000
        $amountInTier = min($remaining, $cap - $lastCap);//(30000,0-10000) (20000,10000-20000) //(10000,20000-null)
        if ($amountInTier > 0) {//10000>0 //10000>0 //10000
            $interest += $amountInTier * $tier['rate'];//0+0.03*10000 //300+(10000*0.05)=800 //800+(10000*0.07)
            $remaining -= $amountInTier;//30000-10000=20000 //20000-10000 //10000-10000
        }
        $lastCap = $cap;//10000 //20000
        if ($remaining <= 0) break; 
    }

    return $interest / $balance; // effective average rate //1500/30000=5%
}

function calculateInterest($accounts, $holidaysByCountry, $taxRates, $exchangeRates) {
    $results = [];
    $totalTax = 0;

    foreach ($accounts as $account) {
        $id = $account['account_id'];
        $balance = $account['balance'];
        $start = new DateTime($account['start_date']);
        $end = new DateTime($account['end_date']);
        $type = $account['interest_type'];
        $compounding = $account['compounding'];
        $country = $account['country'];
        $currency = $account['currency'];
        $tiers = $account['tiers'];

        // Business days only
        $businessDays = 0;
        $current = clone $start;
        while ($current <= $end) {
            if (isBusinessDay($current, $holidaysByCountry[$country])) {
                $businessDays++;
            }
            $current->modify('+1 day');
        }

        $rate = getTieredRate($balance, $tiers); // effective rate from tiers 

        // Compounding periods per year
        $n = match ($compounding) {
            'daily' => 365,
            'monthly' => 12,
            'quarterly' => 4,
            'annually' => 1,
            default => 365
        };

        // Duration in years
        $t = $businessDays / 365;

        // Compound Interest
        $final = $balance * pow(1 + $rate / $n, $n * $t);
        print_r($final);
        $interest = $final - $balance;

        // Tax
        $taxRate = $taxRates[$country] ?? 0.2;
        $tax = $interest * $taxRate;

        // Convert to USD
        $usdFinal = ($final - $tax) * $exchangeRates[$currency];

        $totalTax += $tax * $exchangeRates[$currency];
        $results[$id] = round($usdFinal, 2);
    }

    return ['results' => $results, 'total_tax' => round($totalTax, 2)];
}

// Calculate and output
$data = calculateInterest($accounts, $holidaysByCountry, $taxRates, $exchangeRates);

foreach ($data['results'] as $id => $amount) {
    echo "Account $id: \$" . number_format($amount, 2) . "<br>";
}
echo "<br><strong>Total Tax Paid to Government: \$" . number_format($data['total_tax'], 2) . "</strong>";

?>