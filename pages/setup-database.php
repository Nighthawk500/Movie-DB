<?php

// Database setup file
// This file creates the movie_db database and the movies table if they do not already exist.

// MySQL server information
$servername = "localhost";
$username = "root";
$password = ""; // Use "" or "mysql" depending on your AMPPS MySQL password

// Create a connection to the MySQL server.
// At this point, we are not connecting to a specific database yet.
$conn = new mysqli($servername, $username, $password);

// Check if the server connection failed.
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL command to create the database if it does not already exist.
$sql = "CREATE DATABASE IF NOT EXISTS movie_db";

// Run the database creation query.
if ($conn->query($sql) === TRUE) {
    echo "Database movie_db created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Select the movie_db database so the table can be created inside it.
$conn->select_db("movie_db");

// SQL command to create the movies table if it does not already exist.
// This table matches the columns used by Index.php and import-csv.php.
$sql = "CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rank_num INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    opening INT NOT NULL,
    total_gross INT NOT NULL,
    percent_total DECIMAL(5,2) NOT NULL,
    theaters INT NOT NULL,
    average INT NOT NULL,
    release_date VARCHAR(50) NOT NULL,
    distributor VARCHAR(255) NOT NULL
)";

// Run the table creation query.
if ($conn->query($sql) === TRUE) {
    echo "Table movies created successfully or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

// Close the MySQL connection after setup is complete.
$conn->close();

// Final confirmation message.
echo "Database setup complete.";

?>
