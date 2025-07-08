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
        'country' => 'DE',
        'tiers' => [
            ['up_to' => 10000, 'rate' => 0.03],
            ['up_to' => 20000, 'rate' => 0.05],
            ['up_to' => null,  'rate' => 0.07],
        ],
        'seasonal_rates' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ],
        'penalties' => [
            'early_withdrawal' => 0.02
        ],
        'bonuses' => [
            'loyalty_bonus' => [
                'after_months' => 12,
                'rate_boost' => 0.01
            ]
        ],
        'account_type' => 'savings',
        'risk_profile' => 'low',
        'compliance_flags' => [
            'high_volume_txns' => false,
            'large_foreign_deposits' => false,
        ],
        'fx_hedging' => [
            'enabled' => true,
            'hedge_rate' => 1.12
        ],
        'interest_cap' => 1500,
        'interest_floor' => 0,
        'account_holder' => [
            'name' => 'Max Mustermann',
            'dob' => '1985-06-01',
            'nationality' => 'DE',
            'residency' => 'DE',
            'kyc_status' => 'verified'
        ],
        'tax_brackets' => [
            ['up_to' => 1000, 'rate' => 0.10],
            ['up_to' => 5000, 'rate' => 0.20],
            ['up_to' => null, 'rate' => 0.30]
        ],
        'transactions' => [
            ['date' => '2023-01-10', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-04-15', 'type' => 'deposit', 'amount' => 10000],
            ['date' => '2023-09-20', 'type' => 'withdrawal', 'amount' => 5000],
        ],
        'bank' => [
            'id' => 'BANK001',
            'name' => 'Global Bank',
            'country' => 'DE',
            'regulatory_tier' => 'Tier 1'
        ]
    ]
];

$results = [];

foreach ($accounts as $account) {
    $balance = $account['balance'];
    $transactions = $account['transactions'];
    $startDate = new DateTime($account['start_date']);
    $endDate = new DateTime($account['end_date']);
    $compounding = $account['compounding'];
    $endDateCopy = clone $endDate;


    $businessDays = 0;
    $currentDate = new DateTime($account['start_date']);
    while ($currentDate <= $endDate) {
        if (isBusinessDay($currentDate)) {
            $businessDays++;
        }
        $currentDate->modify('+1 day');
    }

    $tieredRate = getTieredRate($balance, $account['tiers']);
    $txIndex = 0;


    
    for ($i = 0; $i < $businessDays; $i++) {
        $dateStr = $currentDate->format('Y-m-d');

        while ($txIndex < count($transactions) && $transactions[$txIndex]['date'] === $dateStr) {
            $txn = $transactions[$txIndex];
            if ($txn['type'] === 'deposit') {
                $balance += $txn['amount'];
            } elseif ($txn['type'] === 'withdrawal') {
                $balance -= $txn['amount'];
            }
            $txIndex++;
        }
    } 

    $seasonalModifierSum = 0;
    $seasonalDays = 0;
    $period = new DatePeriod($startDate, new DateInterval('P1D'), (clone $endDate)->modify('+1 day'));

    foreach ($period as $day) {
        $dateStrs = $day->format('Y-m-d');
        $seasonalModifierSum += getSeasonalModifier($dateStrs, $account['seasonal_rates']);
        $seasonalDays++;
    }

    $avgSeasonalModifierRate = $seasonalDays > 0 ? $seasonalModifierSum / $seasonalDays : 0;
    $finalRate = $tieredRate + $avgSeasonalModifierRate;

    $interval = $startDate->diff($endDate)->m + ($startDate->diff($endDate)->y * 12);
    if ($interval >= $account['bonuses']['loyalty_bonus']['after_months']) {
        $finalRate += $account['bonuses']['loyalty_bonus']['rate_boost'];
    }

    $n = match ($compounding) {
        'daily' => 365,
        'monthly' => 12,
        'quarterly' => 4,
        'annually' => 1
    };

    $t = $businessDays / 365;
    $final = $balance * pow(1 + $finalRate / $n, $n * $t);
    $interest = $final - $balance;

    $penaltyAmount = 0;
    foreach ($account['transactions'] as $txn) {
        if ($txn['type'] === 'withdrawal') {
            $txnDate = new DateTime($txn['date']);
            if ($txnDate < $endDateCopy) {
                $penaltyAmount += $txn['amount'] * ($account['penalties']['early_withdrawal'] ?? 0);
            }
        }
    }
    $interest -= $penaltyAmount;

    if ($interest > $account['interest_cap']) {
        $interest = $account['interest_cap'];
    }
    if ($interest < $account['interest_floor']) {
        $interest = $account['interest_floor'];
    }

    $gross_interest = round($interest, 2);
    $tax_paid = calculateTaxPaid($gross_interest, $account);
    $net_interest = $gross_interest - $tax_paid;

    $net_interest_usd = $net_interest;
    if ($account['fx_hedging']['enabled']) {
        $net_interest_usd = $net_interest * $account['fx_hedging']['hedge_rate'];
    }

    $final_balance = $account['balance'] + $net_interest;

    $results[] = [
        'account_id' => $account['account_id'],
        'gross_interest' => $gross_interest,
        'tax_paid' => $tax_paid,
        'net_interest' => round($net_interest, 2),
        'net_interest_usd' => round($net_interest_usd, 2),
        'final_balance' => round($final_balance, 2),
    ];
}

print_r($results);



function isBusinessDay($date) {
    $weekday = $date->format('N');
    $dateStr = $date->format('Y-m-d');
    $holidays = []; 
    return $weekday < 6 && !in_array($dateStr, $holidays);
}

function getTieredRate($balance, $tiers) {
    $interest = 0;
    $remaining = $balance;
    $lastCap = 0;

    foreach ($tiers as $tier) {
        $cap = $tier['up_to'] ?? $balance;
        $amountInTier = min($remaining, $cap - $lastCap);
        if ($amountInTier > 0) {
            $interest += $amountInTier * $tier['rate'];
            $remaining -= $amountInTier;
        }
        $lastCap = $cap;
        if ($remaining <= 0) break;
    }

    return $interest / $balance;
}

function getSeasonalModifier($date, $seasonalRates) {
    foreach ($seasonalRates as $season) {
        if ($date >= $season['from'] && $date <= $season['to']) {
            return $season['rate_modifier'];
        }
    }
    return 0;
}

function calculateTax($amount, $brackets) {
    $tax = 0;
    $remaining = $amount;
    $lastCap = 0;

    foreach ($brackets as $bracket) {
        $cap = $bracket['up_to'] ?? $amount;
        $amountInBracket = min($remaining, $cap - $lastCap);
        if ($amountInBracket > 0) {
            $tax += $amountInBracket * $bracket['rate'];
            $remaining -= $amountInBracket;
        }
        $lastCap = $cap;
        if ($remaining <= 0) break;
    }

    return $tax;
}

function calculateTaxPaid($grossInterest, $account) {
    return round(calculateTax($grossInterest, $account['tax_brackets']), 2);
}
