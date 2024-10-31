<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leaderboard</title>
<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #edf7ed;
    }
    .leaderboard {
        width: 100%;
        height: 100%;
        max-width: 800px;
        border: 1px solid #ccc;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
        background-color: #fff;
    }
    .leaderboard-header {
        background-color: #000;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        font-size: 2em;
        font-weight: bold;
    }
    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    .leaderboard-item:last-child {
        border-bottom: none;
    }
    .circle {
        width: 50px;
        height: 50px;
        background-color: #009688;
        border-radius: 50%;
        margin-right: 20px;
    }
    .name {
        flex: 1;
        font-size: 1.5em;
    }
    .email {
        flex: 1.5;
        font-size: 1.5em;
    }
    .score {
        font-weight: bold;
        font-size: 1.5em;
    }
</style>
</head>
<body>
<?php
require 'navbar.php';
require 'connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get memberid, email, and total_price, only if total_price is not null and the user is not an admin
$sql = "SELECT SQL_NO_CACHE m.memberid, u.email, m.total_point
        FROM membership m
        JOIN userdata u ON m.userid = u.userid 
        WHERE m.total_point IS NOT NULL 
        AND u.is_admin != 1 
        ORDER BY m.total_point DESC";

$result = $conn->query($sql);
?>

<div class="leaderboard">
    <div class="leaderboard-header">LEADERBOARD</div>
    <div class="leaderboard-item" style="font-weight: bold; background-color: #e0e0e0;">
        <div class="circle" style="background-color: transparent;"></div>
        <div class="name" style="text-align: left;">Member ID</div>
        <div class="email" style="text-align: left;">Email</div>
        <div class="score">Points</div>
    </div>

    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='leaderboard-item'>";
            echo "<div class='circle'></div>";
            echo "<div class='name'>" . htmlspecialchars($row["memberid"]) . "</div>";
            echo "<div class='email'>" . htmlspecialchars($row["email"]) . "</div>";
            echo "<div class='score'>" . htmlspecialchars($row["total_point"]) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='leaderboard-item'>No data available</div>";
    }
    $conn->close();
    ?>
</div>



</body>
</html>
