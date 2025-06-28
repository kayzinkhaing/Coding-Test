<?php
// $sales = [
//     [
//         'seller_id' => 'A',
//         'role' => 'director',
//         'products' => [
//             ['category' => 'software', 'amount' => 1000],// 10% for software=100 
//             ['category' => 'hardware', 'amount' => 500],// 8% for hardware =40
//             //100+40=140 +8( getting from B )=148 + 18(getting from C) = 166 +100 (from bonus) =266
//         ],
//         'referrals' => [
//             [
//                 'seller_id' => 'B',//7% =56 for software //
//                 'role' => 'manager',
//                 'products' => [
//                     ['category' => 'software', 'amount' => 800]//software level 1% to A (56-8=48)   , getting from C 6 +48 =54 +50(bouns)=104
//                 ],
//                 'referrals' => [
//                     [
//                         'seller_id' => 'C',
//                         'role' => 'agent',
//                         'products' => [
//                             ['category' => 'hardware', 'amount' => 600]//agent 4% = 24 //hardware 1Level 1% to B = 6, (24-6=18) , 3% to A (18-18=0)
//                         ],
//                         'referrals' => []
//                     ]
//                 ]
//             ]
//         ]
//     ]
// ];
// const COMMISSION_RULES = [
//     'software' => [
//         'self' => ['agent' => 0.05, 'manager' => 0.07, 'director' => 0.10],
//         'upline' => [
//             0 => ['agent' => 0.01, 'manager' => 0.02, 'director' => 0.03],
//             1 => ['agent' => 0.005, 'manager' => 0.01, 'director' => 0.02],
//             'default' => 0.005
//         ]
//     ],
//     'hardware' => [
//         'self' => ['agent' => 0.04, 'manager' => 0.06, 'director' => 0.08],
//         'upline' => [
//             0 => ['agent' => 0.01, 'manager' => 0.015, 'director' => 0.025],
//             1 => ['agent' => 0.005, 'manager' => 0.007, 'director' => 0.01],
//             'default' => 0.003
//         ]
//     ]
// ];
// const BONUS_RULES = [
//     'director' => 1000, // gets $100 bonus for every $1000 in team sales
//     'manager' => 500,
// ];


const COMMISSION_RULES = [
    'software' => [
        'self' => ['agent' => 0.05, 'manager' => 0.07, 'director' => 0.10],
        'upline' => [
            0 => ['agent' => 0.01, 'manager' => 0.02, 'director' => 0.03],
            1 => ['agent' => 0.005, 'manager' => 0.01, 'director' => 0.02],
            'default' => 0.005
        ]
    ],
    'hardware' => [
        'self' => ['agent' => 0.04, 'manager' => 0.06, 'director' => 0.08],
        'upline' => [
            0 => ['agent' => 0.01, 'manager' => 0.015, 'director' => 0.025],
            1 => ['agent' => 0.005, 'manager' => 0.007, 'director' => 0.01],
            'default' => 0.003
        ]
    ]
];

const BONUS_RULES = [
    'director' => 1000, // gets $100 bonus for every $1000 in team sales
    'manager' => 500,  // gets a bonus for every $500 in team sales (assuming $50 per $500)
];

$sales = [
    [
        'seller_id' => 'A',
        'role' => 'director',
        'products' => [
            ['category' => 'software', 'amount' => 1000],
            ['category' => 'hardware', 'amount' => 500],
        ],
        'referrals' => [
            [
                'seller_id' => 'B',
                'role' => 'manager',
                'products' => [
                    ['category' => 'software', 'amount' => 800]
                ],
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'role' => 'agent',
                        'products' => [
                            ['category' => 'hardware', 'amount' => 600]
                        ],
                        'referrals' => []
                    ]
                ]
            ]
        ]
    ]
];

function calculateCommissions($sales, &$commissions, &$teamSales, $upline = [])
{
    foreach ($sales as $sale) {
        $seller = $sale['seller_id'];//A //B //C
        $role = $sale['role'];//director //manager  //agent 
        $products = $sale['products'];
        // print_r($products);
        $currentSellerDirectSales = 0; //A = 1000+ 500=1500 //B =800 //C=600

        $commissions[$seller] = $commissions[$seller] ?? 0.0;//A  //B  //C

        foreach ($products as $product) {
            $category = $product['category'];//A =software,hardware  //B =software  //C=hardware
            $amount = $product['amount'];//1000 //500  //800  //600

            $selfRate = COMMISSION_RULES[$category]['self'][$role] ?? 0;//software director 10% // hardware director 8% //software manager 7%  // hardware agent 4%
            $selfCommission = $amount * $selfRate;//A=1000*10%=100 //A=500 *8%=40 //B=800* 7% =56 //C=600*4% =24 -9= 15-6=9
            $commissions[$seller] += $selfCommission;//A=100 +40 =140  //B = 56-24=32  //C=24-9=15-6=9
            $currentSellerDirectSales += $amount; //A=1000 +500 //B=800 //C=600

            uplineCommissionDistribution($commissions, $upline, $amount, $seller, $category);
        }

        if (!isset($teamSales[$seller])) {
            $teamSales[$seller] = 0;
        }
        $teamSales[$seller] += $currentSellerDirectSales;//A=1500 //B= 800

        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([['seller_id' => $seller, 'role' => $role]], $upline);//A=director //B =manager
            calculateCommissions($sale['referrals'], $commissions, $teamSales, $newUpline);//ref=B, //ref =C
        }
    }
}

function uplineCommissionDistribution(&$commissions, $upline, $amount, $currentSellerId, $category)
{
    foreach ($upline as $level => $uplineSeller) {//level 0 for C to B //level 1 for C to A
        $uplineSellerId = $uplineSeller['seller_id'];//A //B //A from C
        $uplineSellerRole = $uplineSeller['role'];//director //manager  //director 

        $rate = COMMISSION_RULES[$category]['upline'][$level][$uplineSellerRole] ?? COMMISSION_RULES[$category]['upline']['default'];//software upline A level 0 director = 3%  //hardware upline B level 0 manager 0.015% //hardware upline A level1 director =1% 

        $uplineCommission = $amount * $rate;//for B to A = 800 * 3 =24 //for C=600 *0.015%=9 to B //for C to A = 600 *1% =6

        $commissions[$uplineSellerId] = ($commissions[$uplineSellerId] ?? 0) + $uplineCommission;//$commissions['A'] = (140.0 ?? 0) + 24 = 164.0 from B //$commissions['B'] = (32 ?? 0) + 9 = 41 from C //$commissions['A'] = (164.0 ?? 0) + 6 = 170.0

        $commissions[$currentSellerId] -= $uplineCommission;//B =56-24=32 to A //C =24-9=15 to B //C=15 -4 =9 to A

    }
}

function findSellerRole($salesData, $sellerId) {//$sales , A
    foreach ($salesData as $saleEntry) {
        if ($saleEntry['seller_id'] === $sellerId) {//A=A
            return $saleEntry['role'];//director
        }
        if (!empty($saleEntry['referrals'])) {
            $foundRole = findSellerRole($saleEntry['referrals'], $sellerId);
            if ($foundRole) {
                return $foundRole;
            }
        }
    }
    return null;
}

function calculateBonuses(&$commissions, $teamSales)
{
    global $sales; 

    foreach ($teamSales as $seller => $totalSales) {
        $sellerRole = findSellerRole($sales, $seller);//1500 ,A =>director

        if ($sellerRole && array_key_exists($sellerRole, BONUS_RULES)) {
            $threshold = BONUS_RULES[$sellerRole];
            if ($totalSales >= $threshold) {
                $bonusMultiplier = floor($totalSales / $threshold);

                $bonusPerThreshold = 0;
                if ($sellerRole === 'director') {
                    $bonusPerThreshold = 100; // Director gets $100 for every $1000
                } elseif ($sellerRole === 'manager') {
                    $bonusPerThreshold = 50; // Manager gets $50 for every $500
                }

                $bonus = $bonusMultiplier * $bonusPerThreshold;
                $commissions[$seller] = ($commissions[$seller] ?? 0) + $bonus;
            }
        }
    }
}

// --- Main execution ---

$commissions = [];
$teamSales = []; // To store total sales for each seller's team (for bonus calculation)

// $commissions = ['A' => 170.0, 'B' => 41.0, 'C' => 9.0]

// $teamSales = ['A' => 1500, 'B' => 800, 'C' => 600]

// BONUS_RULES = ['director' => 1000, 'manager' => 500]

// Step 1: Calculate self and upline commissions, and populate teamSales
calculateCommissions($sales, $commissions, $teamSales);

// Step 2: Calculate and apply bonuses based on accumulated team sales
calculateBonuses($commissions, $teamSales);//A = 170 ,1500, B=41 , 800 //C=9,600
// Output the final commissions
echo "Commission per Seller:<br>";
foreach ($commissions as $seller => $commission) {
    echo "$seller: $" . number_format($commission, 2) . "<br>";
}

// For debugging/verification, you can uncomment these lines:
// echo "<br>Team Sales:<br>";
// foreach ($teamSales as $seller => $total) {
//     echo "$seller: $" . number_format($total, 2) . "<br>";
// }


//teamsaleamount for director , manager all downline teamsale , how can i get the downline amount 
?>