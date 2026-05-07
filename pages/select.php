<?php include("Ssi-header.php"); ?>



<?php include("Ssi-conn.php"); ?>





<?php

$conn = new mysqli("localhost", "root", "mysql", "movies");



if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



$sql = "SELECT * FROM movies ORDER BY rank_num ASC";

$result = $conn->query($sql);

?>



<!DOCTYPE html>

<html>

<head>

    <title>Movie Table</title>

    <style>
        table {

            border-collapse: collapse;

            width: 100%;

        }

        th,
        td {

            border: 1px solid black;

            padding: 8px;

            text-align: left;

        }

        th {

            background-color: #ddd;

        }
    </style>

</head>

<body>



    <h2>Top Movies</h2>



    <table>

        <tr>

            <th>Rank</th>

            <th>Title</th>

            <th>Opening</th>

            <th>Total Gross</th>

            <th>Opening %</th>

            <th>Theaters</th>

            <th>Average</th>

            <th>Release Date</th>

            <th>Distributor</th>

        </tr>



        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                echo "<tr> 

            <td>{$row['rank_num']}</td> 

            <td>{$row['title']}</td> 

            <td>{$row['opening']}</td> 

            <td>{$row['total_gross']}</td> 

            <td>{$row['opening_percent']}%</td> 

            <td>{$row['theaters']}</td> 

            <td>{$row['average']}</td> 

            <td>{$row['release_date']}</td> 

            <td>{$row['distributor']}</td> 

        </tr>";

            }

        } else {

            echo "<tr><td colspan='9'>No results</td></tr>";

        }

        $conn->close();

        ?>



    </table>



</body>

</html>



<?php include("includes/Ssi-footer.php"); ?>