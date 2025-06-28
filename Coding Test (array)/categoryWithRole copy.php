<?php

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
    'director' => 1000,
    'manager' => 500,
];

// ... your existing $sales, COMMISSION_RULES and BONUS_RULES go here ...

$commissions = [];
$teamSales = []; // <--- To track team sales for bonus

function calculateCommissions($sales, &$commissions, $upline = [], &$teamSales = [])
{
    foreach ($sales as $seller) {
        $sellerId = $seller['seller_id'];//A //B //C
        $role = $seller['role'];//director //manager //agent
        $products = $seller['products'];//software,hardware //software //harware

        if (!isset($commissions[$sellerId])) {
            $commissions[$sellerId] = 0; //A=0 //B=0 //C=0
        }

        foreach ($products as $product) {
            $category = $product['category'];//software //hardware //software(B) //hardware(C)
            $amount = $product['amount'];//1000 //500 //800 //600

            
            $selfRate = COMMISSION_RULES[$category]['self'][$role] ?? 0;//10% //8% //7%(B) //4%(C)
            $commissions[$sellerId] += $amount * $selfRate; //A=100 //A=100+40 //B=0+56 //C=0+24

          
            upline($commissions, $category, $upline, $amount, $sellerId);

            // team sales 
            foreach ($upline as $uplvl => $uplineSeller) { //[A] //[B,A]
                $id = $uplineSeller['seller_id'];//A //B,A
                $teamSales[$id] = ($teamSales[$id] ?? 0) + $amount;//A=800 //B=600,A=800+600=1400,
            }
        }

        
        $newUplines = array_merge([['seller_id' => $sellerId, 'role' => $role]], $upline);//[A] //[B,A]
        if (!empty($seller['referrals'])) {
            calculateCommissions($seller['referrals'], $commissions, $newUplines, $teamSales);//B,0,[A],[], //C,0,[B,A],[A]
        }
    }
}

function upline(&$commissions, $category, $upline, $amount, $sellerId)
{
    foreach ($upline as $level => $uplineSeller) {//[A] //[B,A]
        $uplineId = $uplineSeller['seller_id']; //A //B,A
        $uplineRole = $uplineSeller['role']; //director //manager,director

        $rate = COMMISSION_RULES[$category]['upline'][$level][$uplineRole]
            ?? COMMISSION_RULES[$category]['upline']['default'];//3% //1.5%,1%

        $commissions[$uplineId] = ($commissions[$uplineId] ?? 0) + $amount * $rate;//A=140+(800*3%)=164 //B=32+(600*1.5%)=41,A=164+(600*1%)=170
        $commissions[$sellerId] -= $amount * $rate; //B=56-(800*3%)=32 //C=24-(600*1.5%)=15,C=15-(600*1%)=9
    }
}

function getRoleById($sales, $id)
{
    foreach ($sales as $seller) {
        if ($seller['seller_id'] === $id) return $seller['role'];//A===B,B===B(manager) //A===A(director)
        if (!empty($seller['referrals'])) {
            $role = getRoleById($seller['referrals'], $id);//B
            if ($role) return $role;
        }
    }
    return null;
}


calculateCommissions($sales, $commissions, [], $teamSales);

// Add bonuses
foreach ($teamSales as $sellerId => $totalTeamSale) { //[B=>600,A=>1400]
    $role = getRoleById($sales, $sellerId); //manager //director
    if (isset(BONUS_RULES[$role])) {
        $threshold = BONUS_RULES[$role];//500 //1000
        $bonus = $totalTeamSale / $threshold * 100;//(600/500)*100 //(1400/1000)*100
        $commissions[$sellerId] += $bonus;//B=41+100=141 //A=170+100=270
    }
}


echo "<h3>Commission per Seller (including Bonus):</h3>";
foreach ($commissions as $seller => $commission) {
    echo "$seller: $" . $commission . "<br>";
}