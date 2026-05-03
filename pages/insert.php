<?php include("Ssi-header.php"); ?>

<?php include("Ssi-conn.php"); ?>



<style>
    html,
    body {

        height: 100%;

        margin: 0;

        font-family: Arial, sans-serif;

        background-color: #f4f6f9;

    }



    .main-content {

        min-height: 100vh;

        display: flex;

        justify-content: center;

        align-items: center;

    }





    .container {

        width: 90%;

        max-width: 900px;

        background: white;

        padding: 40px;

        border-radius: 12px;

        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);

    }



    h2 {

        text-align: center;

        margin-bottom: 25px;

    }





    form {

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 20px;

    }



    label {

        font-weight: bold;

    }



    input {

        width: 100%;

        padding: 10px;

        border-radius: 6px;

        border: 1px solid #ccc;

    }





    button {

        grid-column: span 2;

        padding: 12px;

        font-size: 18px;

        background-color: #007BFF;

        color: white;

        border: none;

        border-radius: 6px;

        cursor: pointer;

    }



    button:hover {

        background-color: #0056b3;

    }



    /* Messages */

    .success {

        color: green;

        text-align: center;

        margin-bottom: 15px;

    }



    .error {

        color: red;

        text-align: center;

        margin-bottom: 15px;

    }
</style>



<div class="main-content">



    <div class="container">



        <h2>Add Movie Record</h2>



        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {



            $title = $_POST['title'];

            $opening = $_POST['opening'];

            $total = $_POST['total_gross'];

            $percent = $_POST['percent_total'];

            $theaters = $_POST['theaters'];

            $average = $_POST['average'];

            $date = $_POST['release_date'];

            $distributor = $_POST['distributor'];



            $rankQuery = $conn->prepare("SELECT COUNT(*) + 1 AS rank_num FROM movies WHERE opening > ?");

            $rankQuery->bind_param("i", $opening);

            $rankQuery->execute();

            $result = $rankQuery->get_result();

            $row = $result->fetch_assoc();

            $rank = $row['rank_num'];



            $stmt = $conn->prepare("INSERT INTO movies  

            (rank_num, title, opening, total_gross, percent_total, theaters, average, release_date, distributor) 

            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");



            $stmt->bind_param(
                "isiiidiss",

                $rank,

                $title,

                $opening,

                $total,

                $percent,

                $theaters,

                $average,

                $date,

                $distributor

            );



            if ($stmt->execute()) {

                echo "<p class='success'>✅ Record inserted! Assigned Rank: $rank</p>";

            } else {

                echo "<p class='error'>❌ Error: " . $stmt->error . "</p>";

            }



            $stmt->close();

        }

        ?>



        <form method="post">



            <div>

                <label>Title</label>

                <input type="text" name="title" required>

            </div>



            <div>

                <label>Opening ($)</label>

                <input type="number" name="opening" required>

            </div>



            <div>

                <label>Total Gross ($)</label>

                <input type="number" name="total_gross" required>

            </div>



            <div>

                <label>% of Total</label>

                <input type="number" step="0.01" name="percent_total" required>

            </div>



            <div>

                <label>Theaters</label>

                <input type="number" name="theaters" required>

            </div>



            <div>

                <label>Average</label>

                <input type="number" name="average" required>

            </div>



            <div>

                <label>Release Date</label>

                <input type="date" name="release_date" required>

            </div>



            <div>

                <label>Distributor</label>

                <input type="text" name="distributor" required>

            </div>



            <button type="submit">Insert Record</button>



        </form>



    </div>



</div>