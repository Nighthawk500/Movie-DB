<!--includes files-->
<?php include '../includes/ssi-header.php'; ?>
<?php include '../includes/ssi-conn.php'; ?>

<!--start of main page content-->
<main class="container">

    <h1>Movies</h1>

    <p>
        Browse the current movie collection from the database.
    </p>

    <!--table wrapper for styling + scroll support-->
    <div class="table-wrapper">

        <!--start movie table-->
        <table class="movie-table">
            <thead>
                <tr>
                    <th>rank</th>
                    <th>title</th>
                    <th>opening</th>
                    <th>total gross</th>
                    <th>% opening</th>
                    <th>theaters</th>
                    <th>average</th>
                    <th>release date</th>
                    <th>distributor</th>
                </tr>
            </thead>

            <!--table body where database rows will show up-->
            <tbody>

            <?php
            // grab all movies from the database ordered by rank
            $sql = "SELECT * FROM movies ORDER BY rank_num ASC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {

                // loop through each movie row
                while ($row = mysqli_fetch_assoc($result)) {

                    echo "<tr>
                        <!-- movie rank -->
                        <td>{$row['rank_num']}</td>

                        <!-- movie title -->
                        <td>{$row['title']}</td>

                        <!-- opening weekend formatted as money -->
                        <td>$" . number_format($row['opening']) . "</td>

                        <!-- total gross formatted as money -->
                        <td>$" . number_format($row['total_gross']) . "</td>

                        <!-- opening percentage -->
                        <td>{$row['percent_total']}%</td>

                        <!-- number of theaters -->
                        <td>" . number_format($row['theaters']) . "</td>

                        <!-- average per theater -->
                        <td>$" . number_format($row['average']) . "</td>

                        <!-- release date -->
                        <td>{$row['release_date']}</td>

                        <!-- distributor -->
                        <td>{$row['distributor']}</td>
                    </tr>";
                }

            } else {
                // fallback message if no data exists
                echo "<tr><td colspan='9'>no records found</td></tr>";
            }
            ?>

            </tbody>
        </table>
    </div>
</main>

<!--include footer-->
<?php include '../includes/ssi-footer.php'; ?>
