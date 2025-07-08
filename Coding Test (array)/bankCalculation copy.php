<?php

$accounts = [
    [
        'originalRate' => 0.05,
        'balance' => 30000,
        'start_date' => '2023-01-13',
        'end_date' => '2023-12-31',
        'seasonal-Rate' => [
            ['from' => '2023-06-01', 'to' => '2023-08-31', 'rate_modifier' => 0.01],
            ['from' => '2023-12-01', 'to' => '2023-12-31', 'rate_modifier' => -0.005],
        ]
    ]
];

function getSeasonalRate($seasonal_rates, $start, $end)
{
    $allDays = (int)$start->diff($end)->days + 1;
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
    foreach ($accounts as $acc) {
        $originalRate = $acc['originalRate'];
        $balance = $acc['balance'];
        $start_date = new DateTime($acc['start_date']);
        
        $end_date = new DateTime($acc['end_date']);
        $seasonal_rates = $acc['seasonal-Rate'];

        $start = clone $start_date;
       
        $end = clone $end_date;

        $current = clone $start;

        $results = [];
        $total = 0;

        echo "Monthly interest breakdown:\n";

        while ($current <= $end) {
            $monthStart = new DateTime($current->format('Y-m-01'));
            // var_dump($monthStart);
            // exit();
            $monthEnd = (clone $monthStart)->modify('last day of this month');
            // var_dump($monthEnd);
            // exit();

            $rangeStart = $monthStart < $start ? $start : $monthStart;
            // var_dump($rangeStart);
            // exit();
            $rangeEnd = $monthEnd > $end ? $end : $monthEnd;

            $data = getSeasonalRate($seasonal_rates, $rangeStart, $rangeEnd);
            $averagerate = $originalRate + $data;

            $days = $rangeStart->diff($rangeEnd)->days + 1;
            $interest = $averagerate * $balance * ($days / 365);

            $monthKey = $monthStart->format('Y-m');
            $results[$monthKey] = [
                'interest' => round($interest, 2),
                'rate' => round($averagerate * 100, 3)  // convert to percent
            ];
            $total += $interest;

            echo "$monthKey: \$" . round($interest, 2) . " and Rate is " . round($averagerate * 100, 3) . "%\n";

            $current->modify('first day of next month');
        }

        echo "Total Interest: \$" . round($total, 2) . "\n\n";
    }
}

calculateSeasonalRate($accounts);
?>
