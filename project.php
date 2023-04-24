<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h3>View Projects</h3>

<h3><a href = "index.php">Login</a></h3>
<h3><a href = "register.php">Register</a></h3>

</head>
<body>
<form method="GET">
    <label for="search">Search:</label>
    <input type="text" id="search" name="search">
    <button type="submit">Submit</button>
    <?php if (!empty($search)) { ?>
        <a href="view_projects.php">Show All</a>
    <?php } ?>
</form>

</body>
</html>
<?php
    // Step 1: start the session
    session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Step 2: include the connectdb.php to connect to the database, the PDO object is called $db and run the query to get all the course information
require_once('connectdb.php');  

// Step 3: handle search query
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $query = "SELECT p.*, u.email FROM projects p JOIN users u ON p.uid = u.uid WHERE p.title LIKE '%$search%' OR p.start_date LIKE '%$search%'";
} else {
    $query = "SELECT p.*, u.email FROM projects p JOIN users u ON p.uid = u.uid";
}

try {
    // Run the query
    $rows = $db->query($query);

    // Step 4: display the course list in a table     
    if ($rows && $rows->rowCount() > 0) {
        echo '<table cellspacing="0" cellpadding="5" id="myTable">';
        echo '<tr><th align="left"><b>Title</b></th><th align="left"><b>Start Date</b></th><th align="left"><b>Description</b></th><th align="left"><b>Email</b></th><th></th></tr>';

        // Fetch and print all the records.
        while ($row = $rows->fetch()) {
            echo '<tr>';
            echo '<td align="left">' . $row['title'] . '</td>';
            echo '<td align="left">' . $row['start_date'] . '</td>';
            echo '<td align="left">' . $row['description'] . '</td>';
            echo '<td><button onclick="showPopup(\''. $row['title'] .'\', \''. $row['start_date'] .'\', \''. $row['end_date'] .'\', \''. $row['phase'] .'\', \''. $row['description'] .'\', \''. $row['email'] .'\')">View Details</button></td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p>No course in the list.</p>';
    }
} catch (PDOexception $ex) {
    echo 'Sorry, a database error occurred!<

br>';
echo 'Error message: ' . $ex->getMessage();
}

// Step 5: close the database connection
$db = null;

?>
<script>
// Step 6: add a JavaScript function to display project details in a popup
function showPopup(title, start_date, end_date, phase, description, email) {
    alert('Title: ' + title + '\nStart Date: ' + start_date + '\nEnd Date: ' + end_date + '\nPhase: ' + phase + '\nDescription: ' + description + '\nContact Email: ' + email);
}
</script>