<?php

// require 'vendor/autoload.php'; // Only include if you are using Composer dependencies

// Define the tax rate for interest in Myanmar (15%)
const TAX_RATE = 0.15;

$accounts = [
    [
        'account_id' => 'A1001',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'yearly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1003',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'monthly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1004',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'weekly',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1005',
        'balance' => 12000,
        'interest_type' => 'compound',
        'rate' => 0.05,
        'compounding' => 'daily',
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
    ],
    [
        'account_id' => 'A1002',
        'balance' => 5000,
        'interest_type' => 'simple',
        'rate' => 0.03,
        'compounding' => 'daily', // Compounding type is not directly used for simple interest but kept for consistency
        'start_date' => '2024-06-01',
        'end_date' => '2024-09-01',
    ]
];

function isWeekend(DateTime $date): bool {
    return $date->format('N') >= 6; // Saturday (6) and Sunday (7)
}

/**
 * This function is modified to always return false,
 * effectively excluding public holidays from business day calculations.
 *
 * @param DateTime $date
 * @param array $holidays
 * @return bool
 */
function isPublicHoliday(DateTime $date, array $holidays): bool {
    return false; // Public holidays are NOT considered for business day calculations as per request
}

function isBusinessDay(DateTime $date, array $publicHolidays): bool {
    // Only checks for weekends, as public holidays are now ignored.
    return !isWeekend($date);
}

function businessDaysBetween(DateTime $start, DateTime $end, array $publicHolidays): int {
    $businessDays = 0;
    $current = clone $start;
    // Loop includes the end date
    while ($current <= $end) {
        // Here, isBusinessDay now implicitly only excludes weekends
        if (isBusinessDay($current, $publicHolidays)) {
            $businessDays++;
        }
        $current->modify('+1 day');
    }
    return $businessDays;
}

/**
 * Generates a list of public holidays for Myanmar for a given year.
 * This version is simplified to return an empty array,
 * effectively ensuring no public holidays are considered.
 *
 * @param int $year The year for which to get holidays.
 * @return array An empty array, as public holidays are ignored.
 */
function getPublicHolidaysForMyanmarYear(int $year): array {
    return []; // No public holidays are returned as per request
}

/**
 * This function now just returns an empty array,
 * as public holidays are explicitly ignored for calculations.
 *
 * @param DateTime $startDate
 * @param DateTime $endDate
 * @return array An empty array.
 */
function getAllPublicHolidaysForMyanmarInRange(DateTime $startDate, DateTime $endDate): array {
    return []; // No public holidays are considered as per request
}

/**
 * Calculates interest (gross, tax, and net) for an account.
 * Tax is applied using the global TAX_RATE constant.
 *
 * @param array $account Account details.
 * @param array $publicHolidays Array of public holiday dates (will be ignored).
 * @return array Associative array with 'gross_interest', 'tax_amount', 'net_interest'.
 * @throws InvalidArgumentException
 */
function calculateInterest(array $account, array $publicHolidays): array {
    $start = new DateTime($account['start_date']);
    $end = new DateTime($account['end_date']);
    $balance = $account['balance'];
    $rate = $account['rate']; // Annual interest rate

    $grossInterest = 0; // Initialize gross interest
    $totalDays = 0; // To store total days or business days for output
    $calculatedDaysType = ""; // To indicate if it's business days or total days

    if ($account['interest_type'] === 'simple') {
        // Simple interest based on business days (only excluding weekends now)
        // Public holidays are effectively ignored by the modified isBusinessDay function
        $businessDays = businessDaysBetween($start, $end, $publicHolidays);
        $grossInterest = $balance * $rate * ($businessDays / 365);
        $totalDays = $businessDays;
        $calculatedDaysType = "Business Days (excluding weekends)";
    } else if ($account['interest_type'] === 'compound') {
        // Compound interest calculation based on total calendar days
        // 'n' is the number of compounding periods per year
        $n = match($account['compounding']) {
            'daily' => 365,
            'weekly' => 52,
            'monthly' => 12,
            'yearly' => 1,
            default => throw new InvalidArgumentException("Invalid compounding period: {$account['compounding']}")
        };

        // 't' is the total time in years (based on all calendar days)
        $interval = $start->diff($end);
        $daysDifference = $interval->days;
        $totalDays = $daysDifference + 1; // Include the end day for calculation

        $t = $totalDays / 365;

        // Compound interest formula: A = P(1 + r/n)^(nt)
        // Interest = A - P
        $A = $balance * pow(1 + $rate / $n, $n * $t);
        $grossInterest = $A - $balance;
        $calculatedDaysType = "Total Calendar Days";
    } else {
        throw new InvalidArgumentException("Invalid interest type: {$account['interest_type']}");
    }

    // Apply fixed tax rate to the gross interest
    $taxAmount = $grossInterest * TAX_RATE;
    $netInterest = $grossInterest - $taxAmount;

    return [
        'gross_interest' => $grossInterest,
        'tax_amount' => $taxAmount,
        'net_interest' => $netInterest,
        'days_calculated' => $totalDays, // Add this for detailed output
        'days_type' => $calculatedDaysType // Add this for detailed output
    ];
}

foreach ($accounts as $account) {
    $accountStartDate = new DateTime($account['start_date']);
    $accountEndDate = new DateTime($account['end_date']);

    // Pass an empty array for holidays, as they are now ignored
    $relevantHolidays = [];

    try {
        $results = calculateInterest($account, $relevantHolidays);

        echo "<h2>Account ID: {$account['account_id']}</h2>";
        echo "<ul>";
        echo "<li>Initial Balance: " . number_format($account['balance'], 2) . "</li>";
        echo "<li>Annual Interest Rate: " . ($account['rate'] * 100) . "%</li>";
        echo "<li>Interest Type: " . ucfirst($account['interest_type']) . "</li>";
        if ($account['interest_type'] === 'compound') {
            echo "<li>Compounding Period: " . ucfirst($account['compounding']) . "</li>";
        }
        echo "<li>Period: {$account['start_date']} to {$account['end_date']}</li>";
        echo "<li>Number of Days for Calculation ({$results['days_type']}): {$results['days_calculated']}</li>";
        echo "<li><strong>Gross Interest: " . number_format($results['gross_interest'], 2) . "</strong></li>";
        echo "<li>Tax Rate Applied: " . (TAX_RATE * 100) . "%</li>";
        echo "<li>Tax Amount: " . number_format($results['tax_amount'], 2) . "</li>";
        echo "<li><strong>Net Interest (After Tax): " . number_format($results['net_interest'], 2) . "</strong></li>";
        echo "</ul>";
        echo "<hr>"; // Separator for clarity

    } catch (InvalidArgumentException $e) {
        echo "<h2>Error for Account ID: {$account['account_id']}</h2>";
        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<hr>";
    }
}