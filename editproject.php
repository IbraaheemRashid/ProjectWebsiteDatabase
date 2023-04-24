<?php
session_start();

require_once('connectdb.php');

if (!empty($_SESSION['username'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = $_POST['phase'];
    $description = $_POST['description'];

    $query = "UPDATE projects SET title = :title, start_date = :start_date, end_date = :end_date, phase = :phase, description = :description WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':phase', $phase);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

$db = null;
?>
