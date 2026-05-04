<?php
require '../includes/field-validation.php';

// Declare data variables
$rank = "";
$title = "";
$opening = "";
$total_gross = "";
$opening_percentage = "";
$theaters = "";
$average = "";
$release_date = "";
$distributor = "";

// Declare error variables
$errors = [
    'rank' => '',
    'title' => '',
    'opening' => '',
    'total_gross' => '',
    'opening_percentage' => '',
    'theaters' => '',
    'average' => '',
    'release_date' => '',
    'distributor' => ''
];

// Declare message and record found variables
$message = '';
$recordFound = false;

// Declare existence variables
$existing_title = "";
$existing_opening = "";
$existing_total_gross = "";
$existing_opening_percentage = "";
$existing_theaters = "";
$existing_average = "";
$existing_release_date = "";
$existing_distributor = "";

// ============== Form processing logic ============== //
if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    // Require database connection
    require_once '../includes/ssi-conn.php';

    // Determine which action was triggered by the form
    $action = $_POST['action'] ?? 'load';

    // Get rank from form input
    $rank = trim($_POST['rank'] ?? '');

    // Rank error catch
    $errors['rank'] = is_number($rank, 1, 30) ? '' : 'Please enter a whole number between 1 and 30.';

    // Error message
    if (!empty($errors['rank'])) {
        $message = 'Please enter a valid rank number.';
    }

    /* ===================== LOAD ===================== */
    if ($action === 'load' && empty($errors['rank'])) {

        $query = 'SELECT Title, Opening, Total_Gross, Opening_Percentage, Theaters, `Average`, Release_Date, Distributor
                  FROM movies
                  WHERE `Rank` = ?';

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $rank);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,
            $title,
            $opening,
            $total_gross,
            $opening_percentage,
            $theaters,
            $average,
            $release_date,
            $distributor
        );

        if (mysqli_stmt_fetch($stmt)) {
            $recordFound = true;

            $existing_title = $title;
            $existing_opening = $opening;
            $existing_total_gross = $total_gross;
            $existing_opening_percentage = $opening_percentage;
            $existing_theaters = $theaters;
            $existing_average = $average;
            $existing_release_date = $release_date;
            $existing_distributor = $distributor;

        } else {
            $message = 'No record found for Rank ' . htmlspecialchars($rank) . '.';
        }

        mysqli_stmt_close($stmt);
    }

    /* ===================== UPDATE ===================== */
    elseif ($action === 'update' && empty($errors['rank'])) {

        // Get movie data from form input
        $title = trim($_POST['title'] ?? '');
        $opening = trim($_POST['opening'] ?? '');
        $total_gross = trim($_POST['total_gross'] ?? '');
        $opening_percentage = trim($_POST['opening_percentage'] ?? '');
        $theaters = trim($_POST['theaters'] ?? '');
        $average = trim($_POST['average'] ?? '');
        $release_date = trim($_POST['release_date'] ?? '');
        $distributor = trim($_POST['distributor'] ?? '');

        // Update existence variables from hidden fields
        $existing_title = $_POST['existing_title'] ?? '';
        $existing_opening = $_POST['existing_opening'] ?? '';
        $existing_total_gross = $_POST['existing_total_gross'] ?? '';
        $existing_opening_percentage = $_POST['existing_opening_percentage'] ?? '';
        $existing_theaters = $_POST['existing_theaters'] ?? '';
        $existing_average = $_POST['existing_average'] ?? '';
        $existing_release_date = $_POST['existing_release_date'] ?? '';
        $existing_distributor = $_POST['existing_distributor'] ?? '';

        // Fallback to existing values if fields left empty
        if ($title === '') $title = $existing_title;
        if ($opening === '') $opening = $existing_opening;
        if ($total_gross === '') $total_gross = $existing_total_gross;
        if ($opening_percentage === '') $opening_percentage = $existing_opening_percentage;
        if ($theaters === '') $theaters = $existing_theaters;
        if ($average === '') $average = $existing_average;
        if ($release_date === '') $release_date = $existing_release_date;
        if ($distributor === '') $distributor = $existing_distributor;

        // Validation
        $errors['title'] = is_text($title, 1, 45) ? '' : 'Title is required and must be under 45 characters.';
        $errors['opening'] = is_number($opening, 0, 999999999) ? '' : 'Opening must be a valid number.';
        $errors['total_gross'] = is_number($total_gross, 0, 999999999) ? '' : 'Total Gross must be a valid number.';
        $errors['opening_percentage'] = is_number($opening_percentage, 0, 100) ? '' : 'Opening Percentage must be between 0 and 100.';
        $errors['theaters'] = is_number($theaters, 0, 99999) ? '' : 'Theaters must be a valid number.';
        $errors['average'] = is_number($average, 0, 999999) ? '' : 'Average must be a valid number.';
        $errors['release_date'] = is_date($release_date, '1900-01-01', '2100-12-31') ? '' : 'Release Date must be a valid date.';        
        $errors['distributor'] = is_text($distributor, 1, 50) ? '' : 'Distributor is required and must be under 50 characters.';

        if (!array_filter($errors)) {

            $query = 'UPDATE movies
                      SET Title = ?,
                          Opening = ?,
                          Total_Gross = ?,
                          Opening_Percentage = ?,
                          Theaters = ?,
                          `Average` = ?,
                          Release_Date = ?,
                          Distributor = ?
                      WHERE `Rank` = ?';

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $query);
            
            mysqli_stmt_bind_param($stmt, 'siidiissi',
                $title,
                $opening,
                $total_gross,
                $opening_percentage,
                $theaters,
                $average,
                $release_date,
                $distributor,
                $rank
            );
            mysqli_stmt_execute($stmt);

            // Check if any rows were updated
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $message = 'Record with Rank ' . htmlspecialchars($rank) . ' updated successfully.';
            } else {
                $message = 'No changes were made — the submitted values may be identical to the existing record.';
            }

            mysqli_stmt_close($stmt);

            // Keep form visible after update
            $recordFound = true;

            // Update existence variables to reflect changes
            $existing_title = $title;
            $existing_opening = $opening;
            $existing_total_gross = $total_gross;
            $existing_opening_percentage = $opening_percentage;
            $existing_theaters = $theaters;
            $existing_average = $average;
            $existing_release_date = $release_date;
            $existing_distributor = $distributor;

        } else {
            $message = 'Please correct the errors in the form.';
            $recordFound = true;
        }
    }

} else {
    $message = 'Welcome! Please enter a Rank and click "Load Record" to view and update a movie record.';
}
?>

<!-- //////////// CSS //////////// -->
<style>

.form-control {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin: 3px;
    width: 100%;
    box-sizing: border-box;
}


.rank-btn {
    background: none;
    border: none;
    color: #4a6fa5;
    font-weight: bold;
    cursor: pointer;
    padding: 0;
    text-decoration: underline;
}
.rank-btn:hover {
    color: #2a3f6a;
}
.error-text {
    color: #c0392b;
    font-size: 0.8rem;
}
</style>

<!--includes files-->
<?php include '../includes/ssi-header.php'; ?>
<?php include '../includes/ssi-conn.php'; ?>

<!-- //////////// HTML //////////// -->
<main class="container">

    <h1>Update Movie Through Table View</h1>

    <div class="container">

        <!-- ===== MESSAGE ===== -->
        <?php if (!empty($message)) { ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <!-- ===== EDIT FORM ===== -->
        <?php if ($recordFound) { ?>

        <p><strong>Editing Rank:</strong> <?= htmlspecialchars($rank) ?> — <?= htmlspecialchars($existing_title) ?></p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <input type="hidden" name="rank" value="<?= htmlspecialchars($rank) ?>">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="existing_title" value="<?= htmlspecialchars($existing_title) ?>">
            <input type="hidden" name="existing_opening" value="<?= htmlspecialchars($existing_opening) ?>">
            <input type="hidden" name="existing_total_gross" value="<?= htmlspecialchars($existing_total_gross) ?>">
            <input type="hidden" name="existing_opening_percentage" value="<?= htmlspecialchars($existing_opening_percentage) ?>">
            <input type="hidden" name="existing_theaters" value="<?= htmlspecialchars($existing_theaters) ?>">
            <input type="hidden" name="existing_average" value="<?= htmlspecialchars($existing_average) ?>">
            <input type="hidden" name="existing_release_date" value="<?= htmlspecialchars($existing_release_date) ?>">
            <input type="hidden" name="existing_distributor" value="<?= htmlspecialchars($existing_distributor) ?>">

            <!-- Title field -->
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="<?= htmlspecialchars($existing_title) ?>">
                <?php if (!empty($errors['title'])) { ?><div class="error-text"><?= $errors['title'] ?></div><?php } ?>
            </div>

            <!-- Opening field -->
            <div class="mb-3">
                <label class="form-label">Opening</label>
                <input type="number" class="form-control" name="opening" placeholder="<?= htmlspecialchars($existing_opening) ?>">
                <?php if (!empty($errors['opening'])) { ?><div class="error-text"><?= $errors['opening'] ?></div><?php } ?>
            </div>

            <!-- Total gross field -->
            <div class="mb-3">
                <label class="form-label">Total Gross</label>
                <input type="number" class="form-control" name="total_gross" placeholder="<?= htmlspecialchars($existing_total_gross) ?>">
                <?php if (!empty($errors['total_gross'])) { ?><div class="error-text"><?= $errors['total_gross'] ?></div><?php } ?>
            </div>

            <!-- Opening percentage field -->
            <div class="mb-3">
                <label class="form-label">Opening Percentage</label>
                <input type="number" class="form-control" name="opening_percentage" step="0.1" placeholder="<?= htmlspecialchars($existing_opening_percentage) ?>">
                <?php if (!empty($errors['opening_percentage'])) { ?><div class="error-text"><?= $errors['opening_percentage'] ?></div><?php } ?>
            </div>

            <!-- Theaters field -->
            <div class="mb-3">
                <label class="form-label">Theaters</label>
                <input type="number" class="form-control" name="theaters" placeholder="<?= htmlspecialchars($existing_theaters) ?>">
                <?php if (!empty($errors['theaters'])) { ?><div class="error-text"><?= $errors['theaters'] ?></div><?php } ?>
            </div>

            <!-- Average field -->
            <div class="mb-3">
                <label class="form-label">Average</label>
                <input type="number" class="form-control" name="average" placeholder="<?= htmlspecialchars($existing_average) ?>">
                <?php if (!empty($errors['average'])) { ?><div class="error-text"><?= $errors['average'] ?></div><?php } ?>
            </div>

            <!-- Release date field -->
            <div class="mb-3">
                <label class="form-label">Release Date</label>
                <input type="date" class="form-control" name="release_date" value="<?= htmlspecialchars($existing_release_date) ?>">
                <?php if (!empty($errors['release_date'])) { ?><div class="error-text"><?= $errors['release_date'] ?></div><?php } ?>
            </div>

            <!-- Distributor field -->
            <div class="mb-3">
                <label class="form-label">Distributor</label>
                <input type="text" class="form-control" name="distributor" placeholder="<?= htmlspecialchars($existing_distributor) ?>">
                <?php if (!empty($errors['distributor'])) { ?><div class="error-text"><?= $errors['distributor'] ?></div><?php } ?>
            </div>

            <button type="submit" class="btn-primary">Update Record</button>

        </form>

        <br>
        <?php } ?>

        <div class="table-wrapper">
            <?php
            // Retrieve table values using select query
            $result = mysqli_query($conn, 'SELECT * FROM movies');

            // Display columns
            if (mysqli_num_rows($result) > 0) {
                echo '<table movie-table>
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

                // Display rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td>
                                <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" style="margin:0">
                                    <input type="hidden" name="rank" value="' . htmlspecialchars($row["Rank"]) . '">
                                    <input type="hidden" name="action" value="load">
                                    <button type="submit" class="rank-btn">' . htmlspecialchars($row["Rank"]) . '</button>
                                </form>
                            </td>
                            <td>' . htmlspecialchars($row["Title"]) . '</td>
                            <td>$' . number_format($row["Opening"]) . '</td>
                            <td>$' . number_format($row["Total_Gross"]) . '</td>
                            <td>' . $row["Opening_Percentage"] . '%</td>
                            <td>' . number_format($row["Theaters"]) . '</td>
                            <td>$' . number_format($row["Average"]) . '</td>
                            <td>' . date('M j, Y', strtotime($row["Release_Date"])) . '</td>
                            <td>' . htmlspecialchars($row["Distributor"]) . '</td>
                        </tr>';
                }

                echo '</tbody></table>';
            } else {
                echo '<p>No results found.</p>';
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</main>

<?php include '../includes/ssi-footer.php'; ?>
