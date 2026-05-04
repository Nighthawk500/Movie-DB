<?php

// Include the database connection file.
// __DIR__ makes the path start from the folder this file is in.
include __DIR__ . '/../includes/ssi-conn.php';

// Set the path to the CSV file.
// This goes up one folder, then into the data folder.
$csvFile = __DIR__ . '/../data/data.csv';

// Check if the CSV file exists before trying to open it.
if (!file_exists($csvFile)) {
    die("CSV file not found: " . $csvFile);
}

// Open the CSV file for reading.
$file = fopen($csvFile, "r");

// Stop the script if the CSV file could not be opened.
if ($file === false) {
    die("Could not open CSV file.");
}

// Skip the first row because it contains the column headings.
fgetcsv($file);

// Prepare the SQL INSERT statement.
// The question marks are placeholders for the values from each CSV row.
$stmt = $conn->prepare("
    INSERT INTO movies 
    (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Check if the SQL statement was prepared correctly.
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Loop through each remaining row in the CSV file.
while (($row = fgetcsv($file)) !== false) {

    // Get the rank number from column 1.
    $rank_num = (int)$row[0];

    // Get the movie title from column 2.
    $title = $row[1];

    // Remove dollar signs and commas, then convert opening gross to a number.
    $opening = (int)str_replace(['$', ','], '', $row[2]);

    // Remove dollar signs and commas, then convert total gross to a number.
    $total_gross = (int)str_replace(['$', ','], '', $row[3]);

    // Remove the percent sign and convert the opening percentage to a decimal number.
    $percent_total = (float)str_replace('%', '', $row[4]);

    // Remove commas and convert theaters to a number.
    $theaters = (int)str_replace(',', '', $row[5]);

    // Remove dollar signs and commas, then convert average to a number.
    $average = (int)str_replace(['$', ','], '', $row[6]);

    // Convert the release date into the MySQL date format: YYYY-MM-DD.
    $release_date = date("Y-m-d", strtotime($row[7]));

    // Get the distributor from the last column.
    $distributor = $row[8];

    // Bind the cleaned values to the SQL statement.
    // i = integer, s = string, d = decimal/double.
    $stmt->bind_param(
        "isiiidiss",
        $rank_num,
        $title,
        $opening,
        $total_gross,
        $percent_total,
        $theaters,
        $average,
        $release_date,
        $distributor
    );

    // Execute the insert statement.
    // If a row fails, display which movie caused the error.
    if (!$stmt->execute()) {
        echo "Error inserting row for " . htmlspecialchars($title) . ": " . $stmt->error . "<br>";
    }
}

// Close the CSV file after reading all rows.
fclose($file);

// Close the prepared SQL statement.
$stmt->close();

// Close the database connection.
$conn->close();

// Display success message after import is complete.
echo "CSV data imported successfully.";

?>
