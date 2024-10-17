<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "huanfitness";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM details";
$result = mysqli_query($conn,$sql);

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Added for better box sizing */
    font-family: sans-serif;
}

body {
    background: white;
    height: 100vh;
    margin: 0;
}

.container {
    margin: 70px auto;
    margin-top: 0;
    height: auto;
    overflow: auto;
    display: flex;
    justify-content: center;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);
    width: 70%; 
}

.box {
    width: 100%;
    height: auto; 
    position: relative;
    background-color: rgb(236, 239, 240);
    padding: 20px; 
}

.logo{
    width: 80px;
    cursor: pointer;
}

.navbar {
    width: 90%;
    margin: auto;
    padding: 15px 0; 
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar ul li {
    list-style: none;
    display: inline-block;
    margin: 0 20px;
    position: relative;
}

.navbar ul li a {
    text-decoration: none;
    color: black;
    text-transform: uppercase;
}

.navbar ul li::after {
    content: '';
    height: 3px;
    width: 0%;
    background: #009688;
    position: absolute;
    left: 0;
    bottom: -10px;
    transition: 0.5s;
}

.navbar ul li:hover::after {
    width: 100%;
}

.content {
    position: relative; 
    width: 100%;
    text-align: left; 
    color: black;
}

.content h1 {
    font-size: 40px;
    margin-left: 44%;
    color: #000000a5;
}

button {
    width: 200px;
    padding: 15px 0;
    text-align: center;
    margin: 20px 10px;
    border-radius: 25px;
    font-weight: bold;
    border: 2px solid #aaa0eee4;
    background: transparent;
    color: black;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

span {
    background: #aaa0eee4;
    height: 100%;
    width: 0%;
    border-radius: 25px;
    position: absolute;
    left: 0;
    bottom: 0;
    z-index: -1;
    transition: 0.5s;
}

button:hover span {
    width: 100%;
}

button:hover {
    border: none;
}

.card {
    display: flex;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
    padding: 20px;
    max-width: 800px;
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
    color: #6366F1;
}
.date .month {
    font-size: 16px;
    color: #4B5563;
}

.details {
    flex-grow: 1;
    padding-left: 15px;
}

.exercise-routine {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #111827;
}
.water-consumtion, .body-weight {
    font-size: 14px;
    color: #6B7280;
}
.update-btn {
    width: 100px;
    margin-top: 10px;
    margin-left:65%;
    font-size: 14px;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}
.update-btn:hover {
    background-color: #26dc5d;
}

.delete-btn {
    width: 100px;
    margin-top: -6.75%;
    float: right;
    font-size: 14px;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}
.delete-btn:hover {
    background-color: #fb0400;
}

.add-btn {
    width: 62px;
    font-size: 20px;
    margin-left: 45%;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 200px;
    padding: 20px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}

a{
    text-decoration: none;
}

</style>
    <head><title>Huan Fitness</title></head>
    <body>
        <div class="navbar">
            <img src="logo.jpg" class="logo">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Physical Training</a></li>
                <li><a href="#">Membership</a></li>
                <li><a href="#">Book Now</a></li>
            </ul>
        </div>

            <div class="box">
                <div class="content">
                    <h1>Dashboard</h1>
                    <div class="card">
                        <div class="details">
                            <div class="exercise-routine"></div>
                            <div class="water-consumtion"></div>
                            <div class="body-weight"></div>
                            <a href="add.php"><button class="add-btn">+</button></a>
                        </div>
                    </div>
                <?php
                 if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        $date = $row['rdate'];
                        $day = (int)date('d', strtotime($date));
                        $month = date('M', strtotime($date));
                ?>                
                    <div class="card">
                        <div class="date">
                        <div class="day"><?= $day ?></div>
                        <div class="month"><?= $month ?></div>
                        </div>
                        <div class="details">
                            <div class="exercise-routine">Exercise Routine: <?=$row['routine']?></div>
                            <div class="water-consumtion">Water Consumtion: <?=$row['watercon']?></div>
                            <div class="body-weight">Body Weight(kg): <?=$row['weight']?></div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>
                <?php
                        }
                    } else {
                            echo "<p>No records found.</p>";
                    }
                ?>
            </div>
         </div>
    </body>
</html>