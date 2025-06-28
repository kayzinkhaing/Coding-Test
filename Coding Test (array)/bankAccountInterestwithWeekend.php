<?php

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'monthly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'rate' => 0.03,
        'compounding' => 'daily',
        'start_date' => '2023-06-01',
        'end_date' => '2023-09-01',
    ]
];
//balance >10000 = 7% 

function calculateInterest(array $account): float {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $rate = $account['rate'];

    $interval = $start->diff($end);
    $totalDays = $interval->days + 1; 

    if ($account['interest_type'] === 'simple') {
        $interest = $balance * $rate * ($totalDays / 365);
        return $interest;
    }

    $n = match($account['compounding']) {
        'daily' => 365,
        'weekly' => 52,
        'monthly' => 12,
        'yearly' => 1
    };

    $totalPeriods = match($account['compounding']) {
        'daily' => $totalDays,
        'weekly' => $totalDays / 7,
        'monthly' => ($end->format('Y') - $start->format('Y')) * 12 
                   + ($end->format('m') - $start->format('m')) 
                   + 1,//2023-2023 *12 + 12 -1 +1 =12
        'yearly' => $end->format('Y') - $start->format('Y') + 1
    };//12

    $t = $totalPeriods / $n; //12%12 =1 
    $A = $balance * pow(1 + $rate / $n, $n * $t);//12000 * pow(1 + 5% /12 , 12 * 1)=
    $interest = $A - $balance;
    return $interest;
}

foreach ($accounts as $account) {
    $interest = calculateInterest($account);
    echo "For account {$account['account_id']} is " . round($interest, 2) . "<br>";
}

?>
