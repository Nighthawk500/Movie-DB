<?php

include __DIR__ . '/../includes/ssi-conn.php';

// Redirect to index if data has already been imported
$check = $conn->query("SELECT COUNT(*) AS total FROM movies");
$countRow = $check->fetch_assoc();
if ($countRow['total'] > 0) {
    header('Location: ../pages/index.php');
    exit();
}

$csvFile = __DIR__ . '/../data/data.csv';

if (!file_exists($csvFile)) {
    die("CSV file not found: " . $csvFile);
}

$file = fopen($csvFile, "r");

if ($file === false) {
    die("Could not open CSV file.");
}

// Skip the header row
fgetcsv($file);

$stmt = $conn->prepare("
    INSERT INTO movies 
    (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

while (($row = fgetcsv($file)) !== false) {

    $rank_num      = (int)$row[0];
    $title         = $row[1];
    $opening       = (int)str_replace(['$', ','], '', $row[2]);
    $total_gross   = (int)str_replace(['$', ','], '', $row[3]);
    $percent_total = (float)str_replace('%', '', $row[4]);
    $theaters      = (int)str_replace(',', '', $row[5]);
    $average       = (int)str_replace(['$', ','], '', $row[6]);
    $release_date  = date("Y-m-d", strtotime($row[7]));
    $distributor   = $row[8];

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

    if (!$stmt->execute()) {
        echo "Error inserting row for " . htmlspecialchars($title) . ": " . $stmt->error . "<br>";
    }
}

fclose($file);
$stmt->close();
$conn->close();

echo "CSV data imported successfully." . "<p><a href='../pages/index.php' class='link'>Return Home</a></p>";

?>
