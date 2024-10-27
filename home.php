<?php
session_start();
require 'connect.php';

$totalLastWeek = "SELECT COUNT(*) as totalExerciseLastWeek FROM details WHERE rdate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND userID = ". $_SESSION['userID'] . "";

$resultLastWeek = mysqli_query($conn, $totalLastWeek);
$totalExerciseLastWeek = 0; 

if ($resultLastWeek) {
    $row = mysqli_fetch_assoc($resultLastWeek);
    $totalExerciseLastWeek = $row['totalExerciseLastWeek'];
}

$sql = "SELECT rdate, COUNT(*) as total_exercises FROM details WHERE userID = ". $_SESSION['userID'] . " GROUP BY rdate";

$totalwatercon = "SELECT rdate, SUM(watercon) as total_watercon FROM details WHERE userID = ". $_SESSION['userID'] . " GROUP BY rdate";

$resultTotalEcerciseDone = mysqli_query($conn, $sql);
$resultTotalWatercon = mysqli_query($conn, $totalwatercon);

$waterconData = [];
if ($resultTotalWatercon) {
    while ($row = mysqli_fetch_assoc($resultTotalWatercon)) {
        $waterconData[$row['rdate']] = $row['total_watercon'];
    }
}

mysqli_close($conn);
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
    margin-bottom: 10px;
    text-align: center; 
}

.search-container {
    width: 100%;
    text-align: center;
    padding: 10px;
    margin: 20px 0; 
    margin-bottom: -70px;
}

.search-box {
    width: 550px; 
    padding: 10px;
    font-size: 16px;
    border-radius: 8px; 
    border: 1px solid #ddd; 
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    outline: none;
}

.search-box:focus {
    border-color: #009688; 
}

.search-btn {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #009688; 
    color: white;
    border: none;
    border-radius: 8px;
    margin-left: 10px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); 
}

.search-btn:hover, .view-btn:hover, .add-btn:hover {
    opacity: 0.8; 
}

.container {
    display: flex; 
    justify-content: space-between; 
    margin: 100px auto;
    gap: 100px;
    width: 100%;
}

.left-container, .right-container {
    width: 350px;
    height: 300px;
    padding: 20px;
    margin-top:-5px;
}

.left-container {
    margin-left: 110px;
}

.right-container {
    margin-right: 110px;
}

.side-card {
    display: flex;
    flex-direction: column;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
    padding: 30px;
    margin-bottom: 50px;
}

.side-card:hover {
    transform: translateY(-5px); 
}

.side-card h2 {
    font-size: 24px; 
    color: #333; 
    margin-bottom: 10px; 
}

.side-card p {
    font-size: 20px; 
    color: #555;
    padding: 5px;
    font-weight: bold;
}

.middle-container {
    flex-grow: 1; 
    margin-left: 20px; 
    margin-right: 20px; 
    width: 700px;
    padding: 10px;
    max-height: 500px; 
    overflow-y: hidden; 
    scrollbar-gutter: stable;
}

.middle-container:hover {
    overflow-y: auto; 
}

.middle-container::-webkit-scrollbar {
    width: 10px;
}

.middle-container::-webkit-scrollbar-thumb {
    background-color: #888; 
    border-radius: 10px; 
}


.middle-container::-webkit-scrollbar-thumb:hover {
    background: #555; 
}

.content {
    position: relative; 
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
    padding-top: 5px;
}

.total-exercise-done, .total-water-consumption {
    font-size: 20px;
}

.view-btn {
    width: 100px;
    margin-top: 10px;
    margin-left:auto; 
    font-size: 14px;
    background-color: #009688;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.add-btn {
    width: 50px;
    height: 50px;
    font-size: 20px; 
    margin-left:45%;
    background-color:#009688; 
    color:white; 
    border:none; 
    border-radius: 200px; 
    padding : 10px ; 
    cursor:pointer ; 
    text-align:center ; 
    display:block ;
}

a{
    text-decoration:none ;
}

.button-container {
    display: flex;
    justify-content: flex-end; 
    margin-top: -40px;
}
    </style>
</head>
<body>
    <!--Nav Bar-->
    <?php require 'navbar.php';?>
    <h1>Your Exercise Record</h1>

    <div class="search-container">
        <form action="search.php" method="GET">
            <input type="text" name="search" placeholder="Search ..." class="search-box">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="container">
        <div class="left-container">
            <div class="side-card">
            <h2>Total Exercise Done Last Week</h2>
                <p><?php echo htmlspecialchars($totalExerciseLastWeek); ?></p>
                <div class="button-container">
                    <a href="viewLastWeek.php"><button class="view-btn">View All</button></a>
                </div>
            </div>
        </div>

        <div class="middle-container">
            <div class="content">
                    <div class="card">
                        <div class="details">
                            <a href="add.php"><button class="add-btn">+</button></a>
                         </div>
                    </div>
                <?php
                if (mysqli_num_rows($resultTotalEcerciseDone) > 0) {
                    while ($row = mysqli_fetch_assoc($resultTotalEcerciseDone)) {
                        $date = $row['rdate'];
                        $day = (int)date('d', strtotime($date));
                        $month = date('M', strtotime($date));
                        $total_exercises = $row['total_exercises'];
                        $total_watercon = isset($waterconData[$date]) ? $waterconData[$date] : 0;  
                ?>
                    <div class="card">
                        <div class="date">
                            <div class="day"><?= $day ?></div>
                            <div class="month"><?= $month ?></div>
                        </div>
                        <div class="details">
                            <div class="total-exercise-done">
                                Total Exercise Done: <?= htmlspecialchars($total_exercises) ?>
                            </div>
                            <div class="total-water-consumption">
                                Total Water Consumption: <?= htmlspecialchars($total_watercon) ?>L
                            </div>
                        </div>
                        <a href="view.php?date=<?= htmlspecialchars($date) ?>"><button class="view-btn">View</button></a>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>No records found.</p>";
                }
                ?>
            </div>
        </div>

        <div class="right-container">
            <div class="side-card">
                <h2>Our Service</h2>
                <p>At Huan Fitness, we are committed to helping you achieve your health and fitness goals.</p>
            </div>
        </div>

   </div>
</body>
</html>