<!DOCTYPE html>

<!-- 
Group Project - ISYS 288
5/3/2026
Authors:
    Index: Josephine Hunter
    Database: Jonathan, Joseph
    Select: Bennett
    Delete: Chloe
    Insert: Brandon
    Update: Quaivion
-->

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Movie Mayhem</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <nav class="navbar">
        <header class="site-header">

            <div class="logo">
                Movie Mayhem
            </div>


            <a href="index.php">Home</a>

            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Crud operations
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../pages/select.php">Select from database</a></li>
                    <li><a class="dropdown-item" href="../pages/insert.php">Insert data</a></li>
                    <li><a class="dropdown-item" href="../pages/update.php">Update selections</a></li>
                    <li><a class="dropdown-item" href="../pages/delete.php">Delete from database</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    More
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../pages/database.php">Database</a></li>
                </ul>
            </li>

        </header>
    </nav>