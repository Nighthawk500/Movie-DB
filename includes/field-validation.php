<?php
// Validation helpers for text, number, email, password, and date inputs
// These functions return true when user input meets the expected rules.
    
// Validate that a value is a string and within a specified length range
function is_text($value, $min, $max) {
    return is_string($value) && strlen($value) >= $min && strlen($value) <= $max; // Checks if it's a string and within the specified length range
}

// Validate that a value is a number and within a specified range
function is_number($value, $min, $max) {
    return is_numeric($value) && $value >= $min && $value <= $max; // Checks if it's numeric and within the specified range
}


// Validate that a value is selected from a dropdown and within a specified length range
function is_selected($value, $min, $max) {
    return !empty($value) && strlen($value) >= $min && strlen($value) <= $max; // Checks if a value is selected (not empty) and within the specified length range
}

// Validate date input in YYYY-MM-DD format and check if it's within a specified range
function is_date($date, $min = null, $max = null) {

    if (empty($date)) {
        return false;
    }

    // Must match YYYY-MM-DD format exactly
    $parts = explode('-', $date);

    if (count($parts) !== 3) {
        return false;
    }

    $year  = (int)$parts[0];
    $month = (int)$parts[1];
    $day   = (int)$parts[2];

    // Check that all parts are numeric
    if (!is_numeric($year) || !is_numeric($month) || !is_numeric($day)) {
        return false;
    }

        // Validate real calendar date
    if (!checkdate($month, $day, $year)) {
        return false;
    }

    if ($min !== null && $date < $min) {
        return false;
    }

    if ($max !== null && $date > $max) {
        return false;
    }

    return true;
}

