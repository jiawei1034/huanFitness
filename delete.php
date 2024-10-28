<?php
$detailsID= isset($_GET["detailsID"])?$_GET["detailsID"]:"";

// Debugging output
if ($detailsID <= 0) { 
    echo "Invalid detailsID.";
    exit(); 
}

require 'connect.php';

$stmt = $conn->prepare("DELETE FROM details WHERE ID = ?");
$stmt->bind_param('i', $detailsID); 

if ($stmt->execute()) {
    header("Location: home.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
mysqli_close($conn);
?>