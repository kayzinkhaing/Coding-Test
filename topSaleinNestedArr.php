<?php

$sales = [
    ['Phone' => 1000],
    ['Tablet' => 9000],
    ['Laptop' => 7000],
    ['Desktop' => 4000],
    ['Smartwatch' => [
        ['Headphones' => 3000],
        ['Camera' => 6000],
        ['Speaker' => 2000],
        ['Monitor' => 8000],
        ['Keyboard' => 3500]
    ]]
];

$totalSales = 0; // Global variable
$sortedSales = []; // Global variable


/**
 * Recursively processes sales data to flatten it and calculate total sales.
 * This function uses global variables to update totalSales and sortedSales,
 * allowing it to accept only one argument.
 *
 * @param array $items The current array of sales items to process.
 */
function processSalesRecursive(array $items): void
{
    // Declare global variables to be accessible and modifiable within this function.
    global $totalSales;
    global $sortedSales;

    // This is the single *primary* foreach for data processing within the whole code.
    foreach ($items as $item) {
        $productName = key($item);
        $amount = $item[$productName];

        if (is_array($amount)) {
            // Recursive call, now passing only the array argument.
            processSalesRecursive($amount);
        } else {
            // Modify the global $totalSales variable.
            $totalSales += $amount;
            // Modify the global $sortedSales array.
            $sortedSales[$productName] = $amount;
        }
    }
}

/**
 * Recursively displays the sales data in the order it receives.
 * This function has only one argument. It does not handle "Top Sale" special lines,
 * sorting, or initial headers; it simply prints each item it processes.
 *
 * @param array $salesData The array of sales to display for the current recursive step.
 */
function displaySortedSales(array $salesData): void
{
    // Base case for recursion: if the array is empty, stop.
    if (empty($salesData)) {
        return;
    }

    // Get the first element of the current array slice.
    reset($salesData); // Reset pointer to the start for reliable key().
    $product = key($salesData); // Get the key (product name).
    $amount = $salesData[$product]; // Get the amount (no current() or other iteration methods).

    // Print the current item.
    echo "$product: $amount\n";

    // Prepare the rest of the array for the next recursive call.
    $remainingSales = $salesData; // Create a copy.
    unset($remainingSales[$product]); // Remove the processed item from the copy.

    // Recursive call to process the remaining elements.
    displaySortedSales($remainingSales); // Continue recursion with the rest of the data.
}


// --- Main Script Execution ---

// 1. Process the raw sales data to calculate total sales and flatten individual sales.
processSalesRecursive($sales);

// 2. Sort the sales data once to determine the top sale and for the descending list.
arsort($sortedSales);

// 3. Get the top sale details (needed for the combined top line).
$topProduct = '';
$topAmount = 0;
if (!empty($sortedSales)) { // Ensure there's at least one sale
    reset($sortedSales); // Point to the highest sale
    $topProduct = key($sortedSales); // Get its product name
    $topAmount = $sortedSales[$topProduct]; // Get its amount
}

// 4. Output the combined "Total Sales" and "Top Sale" on a single line.
echo "Total Sales: " . $totalSales . "  *** Top Sale: " . $topProduct . ": " . $topAmount . "\n";

// 5. Output the separator line.
echo "*******************************************************\n";

// 6. Print the header for the sales list.
echo "Sales in Descending Order:\n"; // No extra newline here, as per the desired output example

// 7. Call the display function to print the entire sorted list.
// Since 'sortedSales' is already ordered descending and contains the top item first,
// 'displaySortedSales' will print the list correctly starting with the top sale.
displaySortedSales($sortedSales);

?>