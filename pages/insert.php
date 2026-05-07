<?php include("../includes/ssi-header.php"); ?>
<?php include("../includes/ssi-conn.php"); ?>

<style>
    /* Form inputs */
    .form-control {
        padding: 8px 12px;
        border: 1px solid #444;
        border-radius: 5px;
        width: 100%;
        box-sizing: border-box;
        background: #1a1a1a;
        color: #f5f5f5;
        font-size: 15px;
    }

    .form-control:focus {
        outline: none;
        border-color: #ffd700;
        box-shadow: 0 0 5px #ffd700;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        color: #ffd700;
        font-weight: bold;
        font-size: 14px;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    /* Form grid layout */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-grid-full {
        grid-column: span 2;
    }

    /* Update form container */
    .update-form-box {
        background: #1a1a1a;
        border: 2px solid #b30000;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .update-form-box h2 {
        color: #ffd700;
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 22px;
        border-bottom: 1px solid #333;
        padding-bottom: 10px;
    }

    /* Buttons */
    .btn-primary {
        padding: 10px 24px;
        background: #b30000;
        color: #ffd700;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
        width: 100%;
    }

    .btn-primary:hover {
        background: #8b0000;
    }

    /* Messages */
    .success {
        background: #1a1a1a;
        border-left: 4px solid #00cc00;
        padding: 12px 16px;
        color: #f5f5f5;
        border-radius: 4px;
        margin-bottom: 24px;
    }

    .error {
        background: #1a1a1a;
        border-left: 4px solid #ff0000;
        padding: 12px 16px;
        color: #f5f5f5;
        border-radius: 4px;
        margin-bottom: 24px;
    }

    /* Table wrapper */
    .table-wrapper {
        margin-top: 30px;
        max-width: 100%;
        overflow-x: auto;
    }
</style>

<main class="container" style="max-width: 1300px;">

    <h1>Add Movie Record</h1>

    <div class="update-form-box">
        <h2>Insert New Record</h2>

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
                echo "<p class='success'>Record inserted! Assigned Rank: $rank</p>";
            } else {
                echo "<p class='error'> Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }
        ?>

        <form method="post" class="form-grid">
            <div class="mb-3 form-grid-full">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Opening ($)</label>
                <input type="number" class="form-control" name="opening" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Gross ($)</label>
                <input type="number" class="form-control" name="total_gross" required>
            </div>
            <div class="mb-3">
                <label class="form-label">% of Total</label>
                <input type="number" step="0.01" class="form-control" name="percent_total" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Theaters</label>
                <input type="number" class="form-control" name="theaters" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Average ($)</label>
                <input type="number" class="form-control" name="average" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Release Date</label>
                <input type="date" class="form-control" name="release_date" required>
            </div>
            <div class="mb-3 form-grid-full">
                <label class="form-label">Distributor</label>
                <input type="text" class="form-control" name="distributor" required>
            </div>
            <div class="form-grid-full">
                <button type="submit" class="btn-primary">Insert Record</button>
            </div>
        </form>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="table-wrapper">
        <?php
        $result = mysqli_query($conn, 'SELECT * FROM movies ORDER BY rank_num ASC');

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<table class="movie-table">
            <thead>
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
            </thead>
            <tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                        <td>' . htmlspecialchars($row["rank_num"]) . '</td>
                        <td>' . htmlspecialchars($row["title"]) . '</td>
                        <td>$' . number_format($row["opening"]) . '</td>
                        <td>$' . number_format($row["total_gross"]) . '</td>
                        <td>' . $row["percent_total"] . '%</td>
                        <td>' . number_format($row["theaters"]) . '</td>
                        <td>$' . number_format($row["average"]) . '</td>
                        <td>' . date('M j, Y', strtotime($row["release_date"])) . '</td>
                        <td>' . htmlspecialchars($row["distributor"]) . '</td>
                    </tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No results found.</p>';
        }

        mysqli_close($conn);
        ?>
    </div>

</main>

<?php include("../includes/ssi-footer.php"); ?>