<?php
// PHP opening tag: Indicates the start of PHP code.

// Example sales tree data
// This is the main data structure representing sellers and their referral networks.
// It's an array of arrays, where each inner array represents a seller.
$sales = [
    [ // This is the top-level seller 'A'
        'seller_id' => 'A',     // Unique identifier for the seller.
        'sale_amount' => 1000,  // The amount of sales this specific seller made.
        'referrals' => [        // An array of sellers directly referred by 'A'.
            [ // This is seller 'B', referred by 'A'
                'seller_id' => 'B',
                'sale_amount' => 800,
                'referrals' => [ // 'B' referred 'C'
                    [ // This is seller 'C', referred by 'B'
                        'seller_id' => 'C',
                        'sale_amount' => 600,
                        'referrals' => [] // 'C' referred no one.
                    ]
                ]
            ],
            [ // This is seller 'D', also referred by 'A'
                'seller_id' => 'D',
                'sale_amount' => 500,
                'referrals' => [ // 'D' referred 'C' (Note: 'C' is referred by both 'B' and 'D' in this tree structure)
                    [ // This is seller 'C', referred by 'D'
                        'seller_id' => 'C',
                        'sale_amount' => 600, // Sale amount for C (same as above, assumed to be unique seller ID, one sale)
                        'referrals' => []
                    ]
                ]
            ]
        ]
    ]
];

// --- Function Definition: buildSellerTree ---
// This function recursively traverses the nested $sales array
// and flattens it into a single associative array ($tree).
// The $tree array will map each seller_id to an array containing their amount,
// their direct parent's ID, and an array of their direct children's IDs.
function buildSellerTree($sellers, $parent = null, &$tree = []) {
    // $sellers: The current array of seller nodes to process (e.g., $sales, or a 'referrals' array).
    // $parent: The seller_id of the direct parent of the current $sellers being processed. Default is null for top-level.
    // &$tree: A reference to the main tree array. This allows the function to modify the same array across all recursive calls.

    foreach ($sellers as $seller) {
    // Loop through each seller node in the current $sellers array.
        $id = $seller['seller_id'];
        // Extracts the 'seller_id' (e.g., 'A', 'B', 'D', 'C').

        // Initialize this seller in the tree map.
        // This is where each seller's consolidated information (amount, parent, children) is stored.
        $tree[$id] = [
            'amount'   => $seller['sale_amount'], // Stores the seller's own sale amount.
            'parent'   => $parent,               // Stores the ID of their direct referrer.
            'children' => []                     // Initializes an empty array for their direct referrals.
        ];

        // Add this seller as a child of their parent, if a parent exists.
        if ($parent !== null) {
        // Checks if the current seller has a parent (i.e., not a top-level seller).
            $tree[$parent]['children'][] = $id;
            // Adds the current seller's $id to the 'children' array of their $parent in the $tree.
            // Example: When processing 'B', 'B' is added to $tree['A']['children'].
            // Example: When processing 'C' (referred by B), 'C' is added to $tree['B']['children'].
        }

        // Recurse for referrals: Process nested 'referrals' arrays.
        if (!empty($seller['referrals'])) {
        // Checks if the current seller has any referrals.
            buildSellerTree($seller['referrals'], $id, $tree);
            // Recursive call:
            // - Passes the 'referrals' array as the new $sellers.
            // - Passes the current seller's $id as the new $parent.
            // - Continues to pass the $tree by reference.
        }
    }

    return $tree; // Returns the complete, flattened seller tree map.
}

// --- Main Script Execution - Part 1: Build the Seller Tree ---

// Call buildSellerTree to process the initial $sales data.
// $sellerTree will become an associative array like:
// [
//   'A' => ['amount' => 1000, 'parent' => null, 'children' => ['B', 'D']],
//   'B' => ['amount' => 800, 'parent' => 'A', 'children' => ['C']],
//   'C' => ['amount' => 600, 'parent' => 'B', 'children' => []], // C from B
//   'D' => ['amount' => 500, 'parent' => 'A', 'children' => ['C']] // C from D
// ]
// Note: 'C' appears twice in the sales tree structure, but buildSellerTree will overwrite
// the 'C' entry if it encounters it again, or simply store it based on the first path found.
// Given the provided structure, C will be processed through B first, then D will also have a 'C'.
// This specific buildSellerTree treats 'C' as a single entity with its sale_amount and last-seen parent/children.
// For example, if D refers C, C's parent becomes D in the final $sellerTree map.
// If the goal is unique C (sale of 600) referred by both, a more complex data structure might be needed.
// For this code, the last assignment wins for 'C' if it appears multiple times.
// Let's trace carefully:
// Initial call: buildSellerTree($sales, null, $sellerTree (empty))
//   Loop 1 (seller A):
//     id = 'A'
//     $sellerTree['A'] = ['amount' => 1000, 'parent' => null, 'children' => []]
//     $parent is null, so no child addition
//     !empty($seller['referrals']) (true) -> recursive call buildSellerTree($sales[0]['referrals'], 'A', $sellerTree)
//       Loop 1 (seller B):
//         id = 'B'
//         $sellerTree['B'] = ['amount' => 800, 'parent' => 'A', 'children' => []]
//         $parent ('A') is not null -> $sellerTree['A']['children'][] = 'B' -> ['B']
//         !empty($seller['referrals']) (true) -> recursive call buildSellerTree($sales[0]['referrals'][0]['referrals'], 'B', $sellerTree)
//           Loop 1 (seller C):
//             id = 'C'
//             $sellerTree['C'] = ['amount' => 600, 'parent' => 'B', 'children' => []]
//             $parent ('B') is not null -> $sellerTree['B']['children'][] = 'C' -> ['C']
//             !empty($seller['referrals']) (false) -> no further recursion for C
//           Return $sellerTree from C's recursion
//       Back to B's loop:
//       Loop 2 (seller D):
//         id = 'D'
//         $sellerTree['D'] = ['amount' => 500, 'parent' => 'A', 'children' => []]
//         $parent ('A') is not null -> $sellerTree['A']['children'][] = 'D' -> ['B', 'D']
//         !empty($seller['referrals']) (true) -> recursive call buildSellerTree($sales[0]['referrals'][1]['referrals'], 'D', $sellerTree)
//           Loop 1 (seller C):
//             id = 'C'
//             $sellerTree['C'] = ['amount' => 600, 'parent' => 'D', 'children' => []] // OVERWRITES C from B!
//             $parent ('D') is not null -> $sellerTree['D']['children'][] = 'C' -> ['C']
//             !empty($seller['referrals']) (false) -> no further recursion for C
//           Return $sellerTree from C's recursion
//       Return $sellerTree from B's recursion
// Return $sellerTree from A's recursion

// Final $sellerTree state after buildSellerTree:
// [
//   'A' => ['amount' => 1000, 'parent' => null, 'children' => ['B', 'D']],
//   'B' => ['amount' => 800, 'parent' => 'A', 'children' => ['C']], // B now refers to C, but C's parent is D
//   'C' => ['amount' => 600, 'parent' => 'D', 'children' => []], // C's parent overwritten to D
//   'D' => ['amount' => 500, 'parent' => 'A', 'children' => ['C']]
// ]

$sellerTree = buildSellerTree($sales);

// Initialize an empty array to store the calculated commissions for each seller.
$commissions = [];

// --- Main Script Execution - Part 2: Calculate Commissions ---
// Iterate through each seller in the flattened $sellerTree map.
foreach ($sellerTree as $id => $info) {
    // $id: Current seller's ID (e.g., 'A', 'B', 'C', 'D').
    // $info: An array containing 'amount', 'parent', and 'children' for the current seller.
    $amount = $info['amount'];       // Current seller's own sale amount.
    $parent = $info['parent'];       // Current seller's direct parent (referrer) ID.
    $children = $info['children'];   // Array of direct referral IDs made by current seller.

    // 1. Calculate 10% of their own sales (self-commission).
    $selfCommission = 0.10 * $amount;

    // 2. Calculate 5% from direct referrals (children).
    $childCommission = 0; // Initialize to 0 for accumulation.
    foreach ($children as $childId) {
    // Loop through each direct child (referral) ID of the current seller.
        $childAmount = $sellerTree[$childId]['amount'];
        // Get the sale amount of the current child from the $sellerTree.
        $childCommission += 0.05 * $childAmount;
        // Add 5% of the child's sale amount to the current seller's $childCommission.
    }

    // 3. Calculate 3% from indirect referrals (grandchildren).
    $grandchildCommission = 0; // Initialize to 0.
    foreach ($children as $childId) {
    // Loop through each direct child again.
        foreach ($sellerTree[$childId]['children'] as $grandchildId) {
        // For each child, loop through their children (grandchildren of the current seller).
            $grandchildAmount = $sellerTree[$grandchildId]['amount'];
            // Get the sale amount of the current grandchild.
            $grandchildCommission += 0.03 * $grandchildAmount;
            // Add 3% of the grandchild's sale amount to the current seller's $grandchildCommission.
        }
    }

    // 4. Calculate negative commission: 5% of own sales paid to parent.
    $parentCommission = 0; // Initialize to 0.
    if ($parent !== null) {
    // Checks if the current seller has a parent.
        $parentCommission = -0.05 * $amount;
        // If they have a parent, subtract 5% of *their own* sale amount from their commission.
    }

    // 5. Calculate negative commission: 3% of own sales paid to grandparent.
    $grandParentCommission = 0; // Initialize to 0.
    if ($parent !== null && $sellerTree[$parent]['parent'] !== null) {
    // Checks if the current seller has a parent AND that parent also has a parent (i.e., a grandparent exists).
        $grandParentCommission = -0.03 * $amount;
        // If a grandparent exists, subtract 3% of *their own* sale amount from their commission.
    }

    // Calculate the total commission for this seller by summing all components.
    $total = $selfCommission + $childCommission + $grandchildCommission + $parentCommission + $grandParentCommission;
    $commissions[$id] = $total; // Store the total commission under the seller's ID.
}

// --- Main Script Execution - Part 3: Output Commissions ---
// Loop through the final $commissions array to print each seller's calculated commission.
foreach ($commissions as $id => $commission) {
    // printf: A built-in PHP function for formatted output.
    // "%s": Placeholder for a string (seller ID).
    // "%.2f": Placeholder for a floating-point number, formatted to 2 decimal places.
    printf("Seller %s commission: %.2f\n", $id, $commission);
}

?>