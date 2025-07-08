<?php

function validateAccounts($accounts)
{
    $errors = [];

    if (!is_array($accounts) || empty($accounts)) {
        $errors[] = "Accounts data must be a non-empty array.";
        return $errors;
    }

    foreach ($accounts as $index => $acc) {
        // Check required fields
        $requiredFields = ['originalRate', 'balance', 'start_date', 'end_date', 'seasonal-Rate'];
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $acc)) {
                $errors[] = "Account #$index is missing required field: '$field'.";
            }
        }

        // Numeric fields
        if (isset($acc['originalRate']) && !is_numeric($acc['originalRate'])) {
            $errors[] = "Account #$index: 'originalRate' must be numeric.";
        }

        if (isset($acc['balance']) && !is_numeric($acc['balance'])) {
            $errors[] = "Account #$index: 'balance' must be numeric.";
        }

        // Date format validation
        $startDateValid = isset($acc['start_date']) && isValidDate($acc['start_date']);
        $endDateValid = isset($acc['end_date']) && isValidDate($acc['end_date']);

        if (!$startDateValid) {
            $errors[] = "Account #$index: 'start_date' must be in 'Y-m-d' format.";
        }

        if (!$endDateValid) {
            $errors[] = "Account #$index: 'end_date' must be in 'Y-m-d' format.";
        }

        // Date logic check: start_date <= end_date
        if ($startDateValid && $endDateValid) {
            $start = new DateTime($acc['start_date']);
            $end = new DateTime($acc['end_date']);
            if ($start > $end) {
                $errors[] = "Account #$index: 'start_date' cannot be after 'end_date'.";
            }
        }

        // Seasonal Rate validation
        if (isset($acc['seasonal-Rate']) && is_array($acc['seasonal-Rate'])) {
            foreach ($acc['seasonal-Rate'] as $sIndex => $seasonalRate) {
                if (!isset($seasonalRate['from'], $seasonalRate['to'], $seasonalRate['rate_modifier'])) {
                    $errors[] = "Account #$index > Seasonal Rate #$sIndex: Missing 'from', 'to', or 'rate_modifier'.";
                    continue;
                }

                if (!isValidDate($seasonalRate['from'])) {
                    $errors[] = "Account #$index > Seasonal Rate #$sIndex: 'from' date is not valid (Y-m-d).";
                }

                if (!isValidDate($seasonalRate['to'])) {
                    $errors[] = "Account #$index > Seasonal Rate #$sIndex: 'to' date is not valid (Y-m-d).";
                }

                if (!is_numeric($seasonalRate['rate_modifier'])) {
                    $errors[] = "Account #$index > Seasonal Rate #$sIndex: 'rate_modifier' must be numeric.";
                }
            }
        } else {
            $errors[] = "Account #$index: 'seasonal-Rate' must be an array.";
        }
    }

    return $errors;
}

function isValidDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
