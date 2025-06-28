<?php

const COMMISSION_RULES = [
    'self' => [
        'agent' => 0.08,
        'manager' => 0.10,
        'director' => 0.12
    ],
    'upline' => [
        0 => [
            'agent' => 0.02,
            'manager' => 0.04,
            'director' => 0.05
        ],
        1 => [
            'agent' => 0.01,
            'manager' => 0.02,
            'director' => 0.03
        ],
        'default' => 0.01
    ]
];

$sales = [
    [
        'seller_id' => 'A',
        'role' => 'director',
        'sale_amount' => 1000,
        'referrals' => [
            [
                'seller_id' => 'B',
                'role' => 'manager',
                'sale_amount' => 800,
                'referrals' => [
                    [
                        'seller_id' => 'C',
                        'role' => 'agent',
                        'sale_amount' => 600,
                        'referrals' => []
                    ]
                ]
            ],
            [
                'seller_id' => 'D',
                'role' => 'agent',
                'sale_amount' => 500,
                'referrals' => []
            ]
        ]
    ]
];

function calculateCommissions($sales, &$commissions, $upline = [])
{
    foreach ($sales as $sale) {
        $seller = $sale['seller_id'];//A,B, C //D
        $role = $sale['role'];//director,manager,Agent ,Agent 
        $amount = $sale['sale_amount'];//1000, 800 , 600 ,500

        // Self commission
        $commissions[$seller] = 0.0;//A,B ,C  //D 
        $rate = COMMISSION_RULES['self'][$role] ?? 0;// 12% ,10% ,8%  //8%
        $commissions[$seller] += $amount * $rate;//A=1000*0.12=120 // B= 800 * 10% =80 // C = 600 * 8 =48 //D= 500 * 8% =40 

        // Upline commissions
        upline($commissions, $upline, $amount, $seller);

        // Recurse
        if (!empty($sale['referrals'])) {
            $newUpline = array_merge([['seller_id' => $seller, 'role' => $role]], $upline);//0=>A,director,//B,A,Manager
            calculateCommissions($sale['referrals'], $commissions, $newUpline);//B,A
        }
    }
}

function upline(&$commissions, $upline, $amount, $seller)
{
    foreach ($upline as $level => $uplineSeller) {//A  //B,A  //A
        $id = $uplineSeller['seller_id'];//A //B ,A  //A
        $role = $uplineSeller['role'];//director //Manager , director //Agent  //director 

        // Rate by level and role
        $rate = COMMISSION_RULES['upline'][$level][$role] ?? COMMISSION_RULES['upline']['default'];//5%  //4%  //3%  //5%

        $commissions[$id] = ($commissions[$id] ?? 0) + $amount * $rate;// A= 120 + 40  =160 //B = 40+ 24 =64 //A = 160 + 18  =178 //A = 178 + 25 =203
        $commissions[$seller] -= $amount * $rate;//B  =80 -40 // c= 48-24 = 24 , c= 24- 18 = 6 //D = 40 - 25 =15
    }
}

// Run
$commissions = []; 
calculateCommissions($sales, $commissions);

// Output
echo "Commission per Seller:<br>";
foreach ($commissions as $seller => $commission) {
    echo "$seller: $" . number_format($commission, 2) . "<br>";
}