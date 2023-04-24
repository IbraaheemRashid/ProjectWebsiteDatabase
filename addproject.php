<?php
    // Step 1: start the session, check if the user is not logged in, redirect to start
    session_start();

    if (!isset($_SESSION['username'])){
        header("Location: index.php");
        exit();
    }

    // Step 2: include the connectdb.php to connect to the database, the PDO object is called $db 
    require_once('connectdb.php');

    // Step 3: select the uid from the users table where the username is equal to $username
    $username = $_SESSION['username'];
    $stmt = $db->prepare("SELECT uid FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Step 4: retrieve the uid from the query result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $uid = $row['uid'];

    // Step 5: handle the form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $phase = $_POST['phase'];
        $description = $_POST['description'];
        

        try {
            $query = "INSERT INTO projects (title, start_date, end_date, phase, description, uid) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$title, $start_date, $end_date, $phase, $description, $uid]);

            // Redirect to the same page to prevent form resubmission on refresh
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $ex) {
            echo 'Sorry, a database error occurred!<br>';
            echo 'Error details: <em>' . $ex->getMessage() . '</em>';
        }
    }
?>
<!-- Step 6: display the add project form -->
<form method="POST">
    <h3><a href="myprojects.php">Return Home</a></h3> 
    <h3>Add Project</h3>
    <label for="title">Title:</label>
    <input type="text" name="title" required><br><br>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" required><br><br>
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" required><br><br>
    <label for="phase">Phase:</label>
    <select name="phase" required>
        <option value="Design">Design</option>
        <option value="Development">Development</option>
        <option value="Testing">Testing</option>
        <option value="Deployment">Deployment</option>
        <option value="Complete">Complete</option>
    </select><br><br>
    <label for="description">Description:</label>
    <textarea name="description" rows="5" required></textarea><br><br>
    <input type="submit" value="Add Project">
</form>
