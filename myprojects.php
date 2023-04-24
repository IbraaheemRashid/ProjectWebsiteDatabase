<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="editProject.js"></script>


<?php if (!empty($_SESSION['username'])) { ?>
    <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>
<?php } else { ?>
    <h3><a href = "project2.php">View Projects</a></h3>

    <h3>My Projects</></h3>
    <h3><a href = "addproject.php">Add a Project</a></h3>
<?php } ?>

</head>
<body>
<form method="GET">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search">
    <button type="submit">Submit</button>
    <?php if (!empty($search)) { ?>
        <a href="project2.php">Show All</a>
    <?php } ?>
</form>
<?php
// Step 1: start the session
session_start();

// Step 2: include the connectdb.php to connect to the database, the PDO object is called $db and run the query to get all the course information
require_once('connectdb.php');

// Step 3: handle search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($_SESSION['username'])) {
    $query = "SELECT p.*, u.email FROM projects p JOIN users u ON p.uid = u.uid WHERE u.username = '{$_SESSION['username']}'";

    if (!empty($search)) {
        $query .= " AND (p.title LIKE '%$search%' OR p.start_date LIKE '%$search%')";
    }
} else {
    $query = "SELECT p.*, u.email FROM projects p JOIN users u ON p.uid = u.uid";

    if (!empty($search)) {
        $query .= " WHERE p.title LIKE '%$search%' OR p.start_date LIKE '%$search%'";
    }
}

try {
    // Run the query
    $rows = $db->query($query);
    
    // Step 4: display the project list in a table
    if ($rows && $rows->rowCount() > 0) {
        echo '<table cellspacing="0" cellpadding="5" id="myTable">';
        echo '<tr><th align="left"><b>Title</b></th><th align="left"><b>Start Date</b></th><th align="left"><b>Description</b></th><th align="left"><b></b></th><th></th></tr>';
        
        // Fetch and print all the records.
        while ($row = $rows->fetch()) {
            echo '<tr>';
            echo '<td align="left">' . $row['title'] . '</td>';
            echo '<td align="left">' . $row['start_date'] . '</td>';
            echo '<td align="left">' . $row['description'] . '</td>';

            echo '<td><button onclick="showPopup(\''. $row['title'] .'\', \''. $row['start_date'] .'\', \''. $row['end_date'] .'\', \''. $row['phase'] .'\', \''. $row['description'] .'\', \''. $row['email'] .'\')">View Details</button></td>';
            echo '<td><button onclick="editProject(' . $row['pid'] . ')">Edit</button></td>';

            echo '</tr>';
}


    echo '</table>';
} else {
    echo '<p>No projects found.</p>';
}

} catch (PDOException $ex) {
echo '<p>An error occurred while retrieving project data: ' . $ex->getMessage() . '</p>';
}

// Step 5: close the database connection
$db = null;
?>
<script>
function showPopup(title, start_date, end_date, phase, description) {
    alert("Title: " + title + "\nStart Date: " + start_date + "\nEnd Date: " + end_date + "\nPhase: " + phase + "\nDescription: " + description);
}
</script>
<p>Would like to log out? <a href="logout.php">Log out</a>  </p>
</body>
</html>