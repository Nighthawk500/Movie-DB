<?php
// Database connection parameters
$servername = "localhost";
$dbname = "movie_db";
$username = "root";
$password = "";
$charset = "utf8mb4";

$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset($charset);


