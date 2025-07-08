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

function isWeekend(DateTime $date): bool { return $date->format('N') >= 6; }
function isPublicHoliday(DateTime $date, array $countryHolidaysForYear): bool { return in_array($date->format('Y-m-d'), $countryHolidaysForYear); }
function isBusinessDay(DateTime $date, array $countryHolidaysForYear): bool { return !isWeekend($date) && !isPublicHoliday($date, $countryHolidaysForYear); }

function getBusinessDaysBetween(DateTime $start, DateTime $end, array $countryHolidaysForYear): int {
    $days = 0;
    $current = clone $start;
    while ($current <= $end) {
        if (isBusinessDay($current, $countryHolidaysForYear)) { $days++; }
        $current->modify('+1 day');
    }
    return $days;
}

function getCountryHolidaysInRange(string $countryCode, DateTime $start, DateTime $end, array $allHolidays): array {
    $relevantHolidays = [];
    for ($year = (int)$start->format('Y'); $year <= (int)$end->format('Y'); $year++) {
        $relevantHolidays = array_merge($relevantHolidays, $allHolidays[$countryCode][$year] ?? []);
    }
    return array_unique($relevantHolidays);
}


function calculateInterestForEntireBalance(float $balance, float $annualRate, string $interestType, ?string $compounding, int $totalCalendarDays, int $businessDays): float {
    if ($interestType === 'simple') {
        return $balance * $annualRate * ($businessDays / 365);
    }

    // Compound interest
    $n = match ($compounding) {
        'daily' => 365, 'weekly' => 52, 'monthly' => 12, 'yearly' => 1,
        default => throw new InvalidArgumentException("Invalid compounding period: {$compounding}")
    };
    $t = $totalCalendarDays / 365;
    return $balance * (pow(1 + $annualRate / $n, $n * $t) - 1);
}

function getApplicableRate(float $balance, array $tiers): float {
    usort($tiers, function($a, $b) {
        $upA = $a['up_to'] ?? PHP_FLOAT_MAX;
        $upB = $b['up_to'] ?? PHP_FLOAT_MAX;
        return $upA <=> $upB;
    });

    foreach ($tiers as $tier) {
        if ($tier['up_to'] === null || $balance <= $tier['up_to']) {
            return $tier['rate']; 
        }
    }
    return 0.0;
}


function calculateAccountInterest(array $account, array $exchangeRates, array $taxRates, array $holidaysByCountry): array {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $initialBalance = $account['balance'];
    $countryCode = $account['country'];
    $interestType = $account['interest_type'];
    $compounding = $account['compounding'] ?? null;

    $relevantHolidays = getCountryHolidaysInRange($countryCode, $start, $end, $holidaysByCountry);
    
    $totalCalendarDays = $start->diff($end)->days + 1;
    $businessDays = getBusinessDaysBetween($start, $end, $relevantHolidays);

    $applicableRate = getApplicableRate($initialBalance, $account['tiers']);

    $totalGrossInterest = calculateInterestForEntireBalance(
        $initialBalance,
        $applicableRate,
        $interestType,
        $compounding,
        $totalCalendarDays,
        $businessDays
    );

    $taxRate = $taxRates[$countryCode] ?? 0;
    $taxAmount = $totalGrossInterest * $taxRate;
    $netInterest = $totalGrossInterest - $taxAmount;

    return [
        'gross_interest' => $totalGrossInterest,
        'tax_amount' => $taxAmount,
        'net_interest' => $netInterest,
        'currency' => $account['currency'],
        'calculated_days_simple' => $businessDays,
        'calculated_days_compound' => $totalCalendarDays,
        'tax_rate_applied' => $taxRate,
        'effective_rate_applied' => $applicableRate 
    ];
}

// --- Main Execution and Output ---

echo "ACCOUNT INTEREST CALCULATION RESULTS\n";
echo "====================================\n\n";

$overallTotalTaxUSD = 0;

foreach ($accounts as $account) {
    try {
        $results = calculateAccountInterest($account, $exchangeRates, $taxRates, $holidaysByCountry);
        $taxAmountInUSD = $results['tax_amount'] * ($exchangeRates[$results['currency']] ?? 1.0);
        $overallTotalTaxUSD += $taxAmountInUSD;

        echo "--------------------------------------------------\n";
        echo "Account ID:              {$account['account_id']}\n";
        echo "Currency:                {$account['currency']}\n";
        echo "Country:                 {$account['country']}\n";
        echo "Initial Balance:         " . number_format($account['balance'], 2) . " {$account['currency']}\n";
        echo "Interest Period:         {$account['start_date']} to {$account['end_date']}\n";
        echo "Interest Type:           " . ucfirst($account['interest_type']) . "\n";
        echo "Effective Rate Applied:  " . ($results['effective_rate_applied'] * 100) . "%\n"; // New output

        if ($account['interest_type'] === 'compound') {
            echo "Compounding Period:      " . ucfirst($account['compounding']) . "\n";
            echo "Days for Calculation:    {$results['calculated_days_compound']} (Calendar Days)\n";
        } else {
            echo "Days for Calculation:    {$results['calculated_days_simple']} (Business Days)\n";
        }

        echo "--------------------------------------------------\n";
        echo "Gross Interest:          " . number_format($results['gross_interest'], 2) . " {$results['currency']}\n";
        echo "Tax Rate Applied:        " . ($results['tax_rate_applied'] * 100) . "% (for {$account['country']})\n";
        echo "Tax Amount:              " . number_format($results['tax_amount'], 2) . " {$results['currency']}\n";
        echo "Tax Amount (in USD):     " . number_format($taxAmountInUSD, 2) . " USD\n";
        echo "Net Interest:            " . number_format($results['net_interest'], 2) . " {$results['currency']}\n";
        echo "--------------------------------------------------\n\n";

    } catch (Exception $e) {
        echo "--------------------------------------------------\n";
        echo "ERROR for Account ID: {$account['account_id']}\n";
        echo "Issue: " . $e->getMessage() . "\n";
        echo "------------------------------------------------------------------\n\n";
    }
}

echo "====================================\n";
echo "TOTAL TAX PAID ACROSS ALL ACCOUNTS: " . number_format($overallTotalTaxUSD, 2) . " USD\n";
echo "====================================\n";

?>