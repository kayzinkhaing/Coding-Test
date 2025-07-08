<?php

require_once 'validator.php';

$accounts = [
    [
        'originalRate' => 0.05,
        'balance' => 30000,
        'start_date' => '2023-01-01',
        'end_date' => '2023-12-31',
        'seasonal-Rate' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ]
    ]
];

function getSeasonalRate($seasonal_rates = [], $start, $end)
{
    $allDays = $start->diff($end)->days + 1;
    $totals = 0;
    foreach ($seasonal_rates as $seasonal_rate) {
        $seasonStart = new DateTime($seasonal_rate['from']);
        $seasonEnd = new DateTime($seasonal_rate['to']);
        $overstart = $seasonStart > $start ? $seasonStart : $start;
        $overEnd = $seasonEnd < $end ? $seasonEnd : $end;
        if ($overstart <= $overEnd) {
            $days = $overstart->diff($overEnd)->days + 1;
            $totals += $days * $seasonal_rate['rate_modifier'];
        }
    }
    return $allDays > 0 ? $totals / $allDays : 0;
}

function calculateSeasonalRate($accounts)
{
    validateAccounts($accounts); 

    $breakDown = [];
    foreach ($accounts as $acc) {
        $originalRate = $acc['originalRate'];
        $balance = $acc['balance'];
        $startDate = new DateTime($acc['start_date']);
        $endDate = new DateTime($acc['end_date']);
        $seasonalRates = $acc['seasonal-Rate'];

        $totalInterest = 0;
        $current = clone $startDate;
        $current->modify('first day of this month');

        while ($current <= $endDate) {
            $monthStart = clone $current;
            $monthEnd = (clone $current)->modify('last day of this month');
            $daysInMonth = $monthStart->diff($monthEnd)->days + 1;

            $modifier = getSeasonalRate($seasonalRates, $monthStart, $monthEnd);
            $effectiveRate = $originalRate + $modifier;
            $monthlyInterest = $effectiveRate * $balance * ($daysInMonth / 365);
            $totalInterest += $monthlyInterest;

            $breakDown[] = [
                $monthStart->format('F') . ' Days' => $daysInMonth,
                'Seasonal Modifier' => $modifier,
                'Rate' => $effectiveRate,
                'Monthly Interest' => $monthlyInterest,
                'Total Interest' => $totalInterest,
            ];

            $current->modify('first day of next month');
        }
    }
    return $breakDown;
}

try {
    $breakDown = calculateSeasonalRate($accounts);
    header('Content-Type: application/json');
    echo json_encode($breakDown, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
