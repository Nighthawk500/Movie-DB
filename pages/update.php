<?php
require '../includes/field-validation.php';

// Helper function to shorten cash values
function shortMoney($value) {
    if ($value >= 1000000) {
        return '$' . number_format($value / 1000000, 1) . 'M';
    } elseif ($value >= 1000) {
        return '$' . number_format($value / 1000, 1) . 'K';
    } else {
        return '$' . number_format($value);
    }
}

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

    require_once '../includes/ssi-conn.php';

    $action = $_POST['action'] ?? 'load';
    $rank = trim($_POST['rank'] ?? '');

    $errors['rank'] = is_number($rank, 1, 30) ? '' : 'Please enter a whole number between 1 and 30.';

    if (!empty($errors['rank'])) {
        $message = 'Please enter a valid rank number.';
    }

    /* ===================== LOAD ===================== */
    if ($action === 'load' && empty($errors['rank'])) {

        $query = 'SELECT title, opening, total_gross, percent_total, theaters, average, release_date, distributor
                  FROM movies
                  WHERE rank_num = ?';

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

        $title = trim($_POST['title'] ?? '');
        $opening = trim($_POST['opening'] ?? '');
        $total_gross = trim($_POST['total_gross'] ?? '');
        $opening_percentage = trim($_POST['opening_percentage'] ?? '');
        $theaters = trim($_POST['theaters'] ?? '');
        $average = trim($_POST['average'] ?? '');
        $release_date = trim($_POST['release_date'] ?? '');
        $distributor = trim($_POST['distributor'] ?? '');

        $existing_title = $_POST['existing_title'] ?? '';
        $existing_opening = $_POST['existing_opening'] ?? '';
        $existing_total_gross = $_POST['existing_total_gross'] ?? '';
        $existing_opening_percentage = $_POST['existing_opening_percentage'] ?? '';
        $existing_theaters = $_POST['existing_theaters'] ?? '';
        $existing_average = $_POST['existing_average'] ?? '';
        $existing_release_date = $_POST['existing_release_date'] ?? '';
        $existing_distributor = $_POST['existing_distributor'] ?? '';

        if ($title === '') $title = $existing_title;
        if ($opening === '') $opening = $existing_opening;
        if ($total_gross === '') $total_gross = $existing_total_gross;
        if ($opening_percentage === '') $opening_percentage = $existing_opening_percentage;
        if ($theaters === '') $theaters = $existing_theaters;
        if ($average === '') $average = $existing_average;
        if ($release_date === '') $release_date = $existing_release_date;
        if ($distributor === '') $distributor = $existing_distributor;

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
                      SET title = ?,
                          opening = ?,
                          total_gross = ?,
                          percent_total = ?,
                          theaters = ?,
                          average = ?,
                          release_date = ?,
                          distributor = ?
                      WHERE rank_num = ?';

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

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $message = '✅ Record with Rank ' . htmlspecialchars($rank) . ' updated successfully.';
            } else {
                $message = 'No changes were made — the submitted values may be identical to the existing record.';
            }

            mysqli_stmt_close($stmt);

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
            $message = 'Please correct the errors in the form.';
            $recordFound = true;
        }
    }

} else {
    $message = 'Welcome! Please enter a Rank and click "Load Record" to view and update a movie record.';
}
?>

<!--includes files-->
<?php include '../includes/ssi-header.php'; ?>
<?php require_once '../includes/ssi-conn.php'; ?>

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

/* Load form container */
.load-form-box {
    background: #1a1a1a;
    border: 1px solid #444;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: flex-end;
    gap: 16px;
    flex-wrap: wrap;
}

.load-form-box label {
    color: #ffd700;
    font-weight: bold;
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
}

.load-form-box input {
    padding: 8px 12px;
    border: 1px solid #444;
    border-radius: 5px;
    background: #111;
    color: #f5f5f5;
    font-size: 15px;
    width: 100px;
}

.load-form-box input:focus {
    outline: none;
    border-color: #ffd700;
    box-shadow: 0 0 5px #ffd700;
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
}

.btn-primary:hover {
    background: #8b0000;
}

.rank-btn {
    background: none;
    border: none;
    color: #ffd700;
    font-weight: bold;
    cursor: pointer;
    padding: 0;
    text-decoration: underline;
    font-size: 14px;
}

.rank-btn:hover {
    color: #fff;
}

/* Message */
.page-message {
    background: #1a1a1a;
    border-left: 4px solid #ffd700;
    padding: 12px 16px;
    color: #f5f5f5;
    border-radius: 4px;
    margin-bottom: 24px;
}

/* Error text */
.error-text {
    color: #ff6b6b;
    font-size: 0.8rem;
    margin-top: 4px;
}

/* Editing label */
.editing-label {
    color: #ccc;
    font-size: 15px;
    margin-bottom: 16px;
}

.editing-label strong {
    color: #ffd700;
}

/* Table wrapper — extended slightly */
.table-wrapper {
    margin-top: 30px;
    max-width: 100%;
    overflow-x: auto;
}
</style>

<main class="container" style="max-width: 1300px;">

    <h1>Update Movie Record</h1>

    <?php if (!empty($message)) { ?>
        <div class="page-message"><?= htmlspecialchars($message) ?></div>
    <?php } ?>

    <!-- ===== LOAD FORM ===== -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="action" value="load">
        <div class="load-form-box">
            <div>
                <label>Enter Rank to Load</label>
                <input type="number" name="rank" value="<?= htmlspecialchars($rank) ?>" min="1" max="30">
                <?php if (!empty($errors['rank'])) { ?>
                    <div class="error-text"><?= $errors['rank'] ?></div>
                <?php } ?>
            </div>
            <button type="submit" class="btn-primary">Load Record</button>
        </div>
    </form>

    <!-- ===== EDIT FORM ===== -->
    <?php if ($recordFound) { ?>

    <div class="update-form-box">

        <h2>Editing Record</h2>

        <p class="editing-label"><strong>Rank:</strong> <?= htmlspecialchars($rank) ?> — <?= htmlspecialchars($existing_title) ?></p>

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

            <div class="form-grid">

                <div class="mb-3 form-grid-full">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" placeholder="<?= htmlspecialchars($existing_title) ?>">
                    <?php if (!empty($errors['title'])) { ?><div class="error-text"><?= $errors['title'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Opening ($)</label>
                    <input type="number" class="form-control" name="opening" placeholder="<?= htmlspecialchars($existing_opening) ?>">
                    <?php if (!empty($errors['opening'])) { ?><div class="error-text"><?= $errors['opening'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Gross ($)</label>
                    <input type="number" class="form-control" name="total_gross" placeholder="<?= htmlspecialchars($existing_total_gross) ?>">
                    <?php if (!empty($errors['total_gross'])) { ?><div class="error-text"><?= $errors['total_gross'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Opening Percentage (%)</label>
                    <input type="number" class="form-control" name="opening_percentage" step="0.1" placeholder="<?= htmlspecialchars($existing_opening_percentage) ?>">
                    <?php if (!empty($errors['opening_percentage'])) { ?><div class="error-text"><?= $errors['opening_percentage'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Theaters</label>
                    <input type="number" class="form-control" name="theaters" placeholder="<?= htmlspecialchars($existing_theaters) ?>">
                    <?php if (!empty($errors['theaters'])) { ?><div class="error-text"><?= $errors['theaters'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Average ($)</label>
                    <input type="number" class="form-control" name="average" placeholder="<?= htmlspecialchars($existing_average) ?>">
                    <?php if (!empty($errors['average'])) { ?><div class="error-text"><?= $errors['average'] ?></div><?php } ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Release Date</label>
                    <input type="date" class="form-control" name="release_date" value="<?= htmlspecialchars($existing_release_date) ?>">
                    <?php if (!empty($errors['release_date'])) { ?><div class="error-text"><?= $errors['release_date'] ?></div><?php } ?>
                </div>

                <div class="mb-3 form-grid-full">
                    <label class="form-label">Distributor</label>
                    <input type="text" class="form-control" name="distributor" placeholder="<?= htmlspecialchars($existing_distributor) ?>">
                    <?php if (!empty($errors['distributor'])) { ?><div class="error-text"><?= $errors['distributor'] ?></div><?php } ?>
                </div>

                <div class="form-grid-full">
                    <button type="submit" class="btn-primary">Update Record</button>
                </div>

            </div>
        </form>
    </div>

    <?php } ?>

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
                        <td>
                            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" style="margin:0">
                                <input type="hidden" name="rank" value="' . htmlspecialchars($row["rank_num"]) . '">
                                <input type="hidden" name="action" value="load">
                                <button type="submit" class="rank-btn">' . htmlspecialchars($row["rank_num"]) . '</button>
                            </form>
                        </td>
                        <td>' . htmlspecialchars($row["title"]) . '</td>
                        <td>' . shortMoney($row["opening"]) . '</td>
                        <td>' . shortMoney($row["total_gross"]) . '</td>
                        <td>' . $row["percent_total"] . '%</td>
                        <td>' . number_format($row["theaters"]) . '</td>
                        <td>' . shortMoney($row["average"]) . '</td>
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

<?php include '../includes/ssi-footer.php'; ?>
