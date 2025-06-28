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
                        'referrals' => []
                    ]
                ]
            ],
            [
                'seller_id' => 'D',
                'sale_amount' => 500,
                'referrals' => []
            ]
        ]
    ]
];

// Helper to find a seller by ID
function findSeller($sales, $id) {
    foreach ($sales as $seller) {
        if ($seller['seller_id'] === $id) return $seller;
        if (!empty($seller['referrals'])) {
            $found = findSeller($seller['referrals'], $id);
            if ($found) return $found;
        }
    }
    return null;
}

// Get all sellers
function getAllSellers($sales, &$result = []) {
    foreach ($sales as $seller) {
        $result[$seller['seller_id']] = $seller['sale_amount'];
        if (!empty($seller['referrals'])) {
            getAllSellers($seller['referrals'], $result);
        }
    }
    return $result;
}

$seller_amounts = getAllSellers($sales);

// Calculate commissions
$commissions = [];
// A
$commissions['A'] = 0.10 * $seller_amounts['A']
    + 0.05 * ($seller_amounts['B'] ?? 0)
    + 0.05 * ($seller_amounts['D'] ?? 0)
    + 0.05 * ($seller_amounts['C'] ?? 0);
// B
$commissions['B'] = 0.10 * $seller_amounts['B']
    - 0.05 * $seller_amounts['A']
    + 0.03 * ($seller_amounts['C'] ?? 0);
// C
$commissions['C'] = 0.10 * $seller_amounts['C']
    - 0.03 * $seller_amounts['B']
    - 0.05 * $seller_amounts['A'];
// D
$commissions['D'] = 0.10 * $seller_amounts['D']
    + 0.05 * $seller_amounts['A'];

// Output
foreach ($commissions as $seller => $commission) {
    echo "Seller $seller commission: $commission<br>";
}
