<?php

$sales = [
    [
        'seller_id' => 'A',
        'sale_amount' => 1000,
        'referrals' => [
            [
                'seller_id' => 'B',
                'sale_amount' => 800,
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'sale_amount' => 600,
                        'referrals' => [
                            [
                                'seller_id' => 'H',
                                'sale_amount' => 600,
                                'referrals' => []
                            ]
                        ]
                    ]
                ]
            ],
            [
                'seller_id' => 'D',
                'sale_amount' => 500,
                'referrals' => [
                    [
                        'seller_id' => 'G',
                        'sale_amount' => 600,
                        'referrals' => []
                    ]
                ]
            ]
        ]
    ]
];

function getPercentageByLevel($level) {
    if ($level == 0) return 0.05;
    if ($level == 1) return 0.03;
    return 0.01;
}

function calculateCommissions($sales, &$commissions, $upline = []) {
    foreach ($sales as $sale) {
        $seller = $sale['seller_id'];
        $amount = $sale['sale_amount'];
        if (!isset($commissions[$seller])) 
        $commissions[$seller] = 0.0;
        $commissions[$seller] += $amount * 0.10;
        foreach ($upline as $i => $uplineSeller) {
            $percent = getPercentageByLevel($i);
            if (!isset($commissions[$uplineSeller])) $commissions[$uplineSeller] = 0.0;
            $commissions[$uplineSeller] += $amount * $percent;
            $commissions[$seller] -= $amount * $percent;
        }
        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([$seller], $upline);
            calculateCommissions($sale['referrals'], $commissions, $newUpline);
        }
    }
}

$commissions = [];
calculateCommissions($sales, $commissions);

echo "Commission per Seller:<br>";
foreach ($commissions as $seller => $commission) {
    echo "$seller: $commission<br>";
}
?>
