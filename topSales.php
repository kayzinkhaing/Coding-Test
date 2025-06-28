
<?php
//sales=[['p1'=1000],['p2'=2000],['p3'=3000],['p4'=4000],['p5'=5000]] and this will return decending order of sales and total sales , no use built-in functions, no use array_map, no use array_filter, no use array_reduce, no use array_sum, can use sort function , cannot use current()

// $sales = [
//     ['Phone' => 1000],
//     ['Tablet' => 9000],
//     ['Laptop' => 7000],
//     ['Desktop' => 4000],
//     ['Smartwatch' => 5000]
// ];
// $totalSales = 0;
// $sortedSales = [];
// foreach ($sales as $sale) {
//     $product = key($sale);
//     $amount = $sale[$product];
//     $totalSales += $amount;
//     $sortedSales[$product] = $amount;
// }
// arsort($sortedSales);
// echo "Total Sales: $totalSales\n";
// echo "Sales in Descending Order:\n";
// foreach ($sortedSales as $product => $amount) {
//     echo "$product: $amount\n";
// }



// $sales = [
//     ['Phone' => 1000],
//     ['Tablet' => 9000],
//     ['Laptop' => 7000],
//     ['Desktop' => 4000],
//     ['Smartwatch' => 5000]
// ];

// $totalSales = 0;
// $sortedSales = [];

// foreach ($sales as $item) {
//     $productName = key($item);
    
//     $amount = $item[$productName];
    
//     $totalSales += $amount;
//     $sortedSales[$productName] = $amount;
// }

// arsort($sortedSales);

// echo "Total Sales: " . $totalSales . "\n";
// echo "Sales in Descending Order:\n";

// foreach ($sortedSales as $product => $amount) {
//     echo "$product: $amount\n";
// }


$sales = [
    ['Phone' => 1000],
    ['Tablet' => 9000],
    ['Laptop' => 7000],
    ['Desktop' => 4000],
    ['Smartwatch' => 5000]
    
];

$totalSales = 0;
$sortedSales = [];

foreach ($sales as $item) {
    $productName = key($item);
    $amount = $item[$productName];
    
    $totalSales += $amount;
    $sortedSales[$productName] = $amount;
}

arsort($sortedSales);

echo "Total Sales: " . $totalSales . "\n*******************************************************\n";
echo "Sales in Descending Order:\n\n";

$isFirstItem = true; 

foreach ($sortedSales as $product => $amount) {
    if ($isFirstItem) {
        echo "Top Sale =>  $product: $amount\n"; 
        $isFirstItem = false; 
    } else {
        echo "$product: $amount\n";
    }
}



// $sales = [
//     ['Phone' => 1000],
//     ['Tablet' => 9000],
//     ['Laptop' => 7000],
//     ['Desktop' => 4000],
//     ['Smartwatch' => 5000],
//     [
//         ['Headphones' => 3000],
//         ['Camera' => 6000],
//         ['Speaker' => 2000],
//         ['Monitor' => 8000],
//         ['Keyboard' => 3500 ]
//     ]
// ];

// $totalSales = 0;
// $sortedSales = [];
// foreach ($sales as $item) {

//     if (is_array($item) && !empty($item) && is_array(reset($item))) {
//         foreach ($item as $subItem) {
//             $productName = key($subItem);
//             $amount = $subItem[$productName];
            
//             $totalSales += $amount;
//             $sortedSales[$productName] = $amount;
//         }
//     } else {
//         $productName = key($item);
//         $amount = $item[$productName];
        
//         $totalSales += $amount;
//         $sortedSales[$productName] = $amount;
//     }
// }

// arsort($sortedSales);

// echo "Total Sales: " . $totalSales . "\n";
// echo "*******************************************************\n";
// echo "Sales in Descending Order:\n\n";

// $isFirstItem = true;

// foreach ($sortedSales as $product => $amount) {
//     if ($isFirstItem) {
//         echo "Top Sale: $product: $amount\n"; 
//         $isFirstItem = false; 
//     } else {
//         echo "$product: $amount\n";
//     }
// }

?>
