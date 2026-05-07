<?php include("../includes/ssi-header.php"); ?>
<?php include("../includes/ssi-conn.php"); ?>


<div class="container" style="margin-top:100px;">

    <h2>Database Connection</h2>
    
    <?php
    // Check connection 
    if ($conn) {
        echo "<p>Connected successfully to the database.</p>";
    }

    // Count records 
    $sql = "SELECT COUNT(*) AS total FROM movies";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "<p>Total Records: " . $row['total'] . "</p>";
    } else {
        echo "<p>Error retrieving record count.</p>";
    }
    ?>
</div>

<?php include("../includes/ssi-footer.php"); ?>
