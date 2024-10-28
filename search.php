<?php
session_start();
error_reporting(E_ALL & E_NOTICE);

$key = empty($_GET['search']) ? "" : $_GET['search'];

require 'connect.php';

if ($key != "") {
    $sql = "SELECT rdate, COUNT(*) as total_exercises, SUM(watercon) as total_watercon 
            FROM details 
            WHERE userID = ? AND (DAY(rdate) = ? OR MONTHNAME(rdate) LIKE ?) 
            GROUP BY rdate;";
    $stmt = mysqli_prepare($conn, $sql);

    $dayKey = (int)$key;
    $monthKey = '%' . mysqli_real_escape_string($conn, ucfirst(strtolower($key))) . '%';
    
    mysqli_stmt_bind_param($stmt, 'iis', $_SESSION['userID'], $dayKey, $monthKey); 
} else {
    $sql = "SELECT rdate, COUNT(*) as total_exercises, SUM(watercon) as total_watercon 
            FROM details 
            WHERE userID = ? 
            GROUP BY rdate 
            LIMIT 0, 3;";
    $stmt = mysqli_prepare($conn, $sql);
}


mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Huan Fitness</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
            font-family: sans-serif;
        }

        body {
            background: #edf7ed;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column; 
            align-items: center; 
        }

        h1 {
            font-size: 40px;
            color: #000000a5;
            margin-top: 20px; 
            margin-bottom: 20px;
            text-align: center; 
        }   

        .card-container {
            width: 700px;
        }

        .content {
            width: 100%;
            text-align: left; 
            color: black;
        }

        .card {
            display: flex;
            background-color: white;
            justify-content: space-between;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
            padding: 20px;
            max-width: 700px;
            width: calc(100% - 40px); 
            margin: 20px auto; 
        }

        .date {
            width: 70px;
            text-align: center;
            border-right: 1px solid #e0e0e0;
            padding-right: 15px;
        }
                
        .date .day {
            font-size: 36px;
            font-weight: bold;
            color: black;
        }
                
        .date .month {
            font-size: 16px;
            color: black;
        }

        .details {
            flex-grow: 1;
            padding-left: 15px;
        }

        .total-exercise-done, .total-water-consumption {
            font-size: 20px;
        }

        .view-btn {
            width: 100px;
            margin-top: 10px;
            margin-left: auto;
            font-size: 14px;
            background-color: #009688;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .view-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<?php require 'navbar.php'; ?>

<h1>Search Result For <?= htmlspecialchars($key); ?></h1>
<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date = $row['rdate'];
        $day = (int)date('d', strtotime($date));
        $month = date('M', strtotime($date));
        $total_exercises = $row['total_exercises'];
        $total_watercon = $row['total_watercon'];
?>
    <div class="card-container">
        <div class="content">
            <div class="card">
                <div class="date">
                    <div class="day"><?= htmlspecialchars($day) ?></div>
                    <div class="month"><?= htmlspecialchars($month) ?></div>
                </div>
                <div class="details">
                    <div class="total-exercise-done">
                        Total Exercise Done: <?= htmlspecialchars($total_exercises) ?>
                    </div>
                    <div class="total-water-consumption">
                        Total Water Consumption: <?= htmlspecialchars($total_watercon) ?> L
                    </div>
                </div>
                <a href="view.php?date=<?= urlencode($date) ?>"><button class="view-btn">View</button></a>
            </div>
        </div>
    </div>
<?php
    }
} else {
    echo "<p>No records found for the given day.</p>";
}

mysqli_close($conn);
?>
</body>
</html>
