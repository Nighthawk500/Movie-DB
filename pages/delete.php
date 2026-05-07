<?php include("../includes/ssi-header.php"); ?>

<?php include("../includes/ssi-conn.php"); ?>



<div class="container" style="margin-top:100px;">



    <h2> Delete Movie Record </h2>



    <?php

    //Delete Logic 
    


    if (isset($_POST['delete'])) {

        $id = $_POST['movie_id'];



        $stmt = $conn->prepare("DELETE FROM movies WHERE id=?");

        $stmt->bind_param("i", $id);



        if ($stmt->execute()) {

            echo "<p style='color:green;'> Movie deleted successfully.</p>";

        } else {

            echo "<p style='color:red;'> Error deleting record.</p>";

        }



        $stmt->close();

    }



    ?>



    <!-- Dropdown Form -->



    <form method="POST">



        <label>Select Movie:</label><br><br>



        <select name="movie_id" required style="padding:10px; width:300px;">

            <option value="">--Select Movie--</option>



            <?php



            $result = mysqli_query($conn, "SELECT id, title FROM movies");



            while ($row = mysqli_fetch_assoc($result)) {

                echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";

            }

            ?>



        </select>



        <br><br>



        <button type="submit" name="delete" style="padding:10px;">Delete</button>



    </form>



    <hr>



    <h2> Current Movie Records </h2>



    <div class="table-wrapper">

        <table class="movie-table">



            <thead>

                <tr>

                    <th>ID</th>

                    <th>Title</th>

                    <th>Opening</th>

                    <th>Total Gross</th>

                    <th>%</th>

                    <th>Theaters</th>

                    <th>Average</th>

                    <th>Release Date</th>

                    <th>Distributor</th>



                </tr>



            </thead>



            <tbody>



                <?php



                $result = mysqli_query($conn, "SELECT * FROM movies");



                if (mysqli_num_rows($result) > 0) {



                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "<tr> 

            <td>{$row['id']}</td> 

            <td>{$row['title']}</td> 

            <td>{$row['opening']}</td> 

            <td>{$row['total_gross']}</td> 

            <td>{$row['percent_total']}</td> 

            <td>{$row['theaters']}</td> 

            <td>{$row['average']}</td> 

            <td>{$row['release_date']}</td> 

            <td>{$row['distributor']}</td> 

           

            </tr>";



                    }

                } else {

                    echo "<tr><td colspan='9'>No records found</td></tr>";

                }



                ?>



            </tbody>



        </table>



    </div>



</div>



<?php include("../includes/ssi-footer.php"); ?>