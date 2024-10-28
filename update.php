<?php
// Get form data
$detailsID = isset($_POST["detailsID"]) ? $_POST["detailsID"] : "";

$routine = empty($_POST["routine"]) ? "" : $_POST["routine"];
$rdate = empty($_POST["rdate"]) ? "" : $_POST["rdate"];
$stime = empty($_POST["stime"]) ? "" : $_POST["stime"];
$duration = empty($_POST["duration"]) ? "" : $_POST["duration"];
$sets = empty($_POST["sets"]) ? "" : $_POST["sets"];
$level = isset($_POST["level"]) ? $_POST["level"] : "";
$weight = empty($_POST["weight"]) ? "" : $_POST["weight"];
$watercon = empty($_POST["watercon"]) ? "" : $_POST["watercon"];

// Ensure that the date format is correct
$record = date_create($rdate);
$date = date_format($record, "Y-m-d");

// Connect to the database
require 'connect.php';

// Debugging: Output form data to ensure it's correct
echo "<pre>";
var_dump($_POST);
echo "</pre>";

// SQL query to update the record
$sql = "UPDATE details SET 
    routine = ?, 
    rdate = ?, 
    stime = ?, 
    duration = ?, 
    sets = ?, 
    level = ?, 
    weight = ?, 
    watercon = ? 
WHERE id = ?";

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Check if the statement prepared correctly
if ($stmt === false) {
    die("MySQL prepare failed: " . $conn->error);
}

// Bind the parameters to the SQL query
$stmt->bind_param('ssssssiii', $routine, $date, $stime, $duration, $sets, $level, $weight, $watercon, $detailsID);

// Execute the statement and check if it was successful
if ($stmt->execute()) {
    echo "Record updated successfully";
    // Redirect to the home page after successful update
    header("Location: home.php");
    exit;
} else {
    // If there's an error, output it for debugging
    echo "Error executing query: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>