<?php

$server = "localhost";

$username = "root";

$password = "";

$database = "movie_db";



// Connect  

$conn = mysqli_connect($server, $username, $password, $database);



// Check errors  

if (!$conn) {

    die("Connection failed.");

}

?>