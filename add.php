<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$routine=empty($_POST["routine"])?"":$_POST["routine"];
$rdate=empty($_POST["rdate"])?"":$_POST["rdate"];
$stime=empty($_POST["stime"])?"":$_POST["stime"];
$duration=empty($_POST["duration"])?"":$_POST["duration"];
$sets=empty($_POST["sets"])?"":$_POST["sets"];

if(isset($_POST["level"]))
	$level=$_POST["level"];
else
	$level="";

$weight=empty($_POST["weight"])?"":$_POST["weight"];
$watercon=empty($_POST["watercon"])?"":$_POST["watercon"];

$record = date_create($rdate);
$date = date_format($record,"Y-m-d"); 

require 'connect.php';

$stmt = $conn->prepare("INSERT INTO details (USERID, rdate, stime, duration, sets, level, weight, watercon) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssiiii", $_SESSION['userID'], $rdate, $stime, $duration, $sets, $level, $weight, $watercon);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();

    header("Location: home.php");
    exit(); 
} else {
    echo "Error: " . $stmt->error;
}
}
?>

<!DOCTYPE html>
<html lang="en">
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
    margin-top: -50px;
}

.container {
	display: flex;
	gap: 40px;
}

.item {
	flex: 1;
}

.box {
    width: 100%;
    height: auto; 
    position: relative;
    padding: 20px; 
}

form {
    background-color: white;
    padding: 15px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
	margin: 100px auto;
}

form h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

input[type="checkbox"] {
    accent-color:red;
}

input[type="text"], input[type="number"], input[type="date"], select, input[type="radio"], input[type="time"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border 0.3s;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, select:focus, input[type="time"]:focus {
    border-color: #009688;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #009688;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10px;
}

button.clear {
    background-color: #f44336;
}

button:hover {
    opacity: 0.9;
}

button:active {
    transform: scale(0.98);
}

input::placeholder {
    color: #888;
}

.buttons {
    display: flex;
	gap: 40px;
    justify-content: space-between;
}

a{
    text-decoration: none;
}

.radio-container { 
			display:flex;
			align-items:center;
		}

</style>

<head><title>Huan Fitness</title></head>
<body>
        <!-- Navigation Bar -->
        <?php require 'navbar.php';?>

		<div class="box">
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
		<h2>Exercise Info</h2>
		<!--Name Input-->
        <label for="routine">Routine:</label>
        <input type="text" size="25" id="routine" name="routine" 
		maxlength="30" placeholder="eg. Push Up" required><br><br>

        <label for="rdate">Date:</label>
		<input type="date" id="rdate" name="rdate" value="<?=date("Y-m-d")?>"
		max="2025-12-31"><br><br>

        <label for="stime">Starting Time:</label>
        <input type="time" size="25" id="stime" name="stime"><br><br>

		<div class="container">
			<div class="item">
            <label for="duration">Durations(Minutes):</label>
		        <select name="duration" id="type">
				    <option value="10min">10</option>
				    <option value="20min">20</option>
				    <option value="30min">30</option>
				    <option value="40min">40</option>
				    <option value="50min">50</option>
				    <option value="60min">60</option>
		        </select>
			</div>

			<div class="item">
                <label for="sets">Sets:</label>
                <input type="number" id="sets" name="sets"><br><br>
			</div>
		</div>

        <label for="Intensity">Intensity Level:</label>
        <div class="container">
            <div class="item radio-container">	
                <label for="low">Low</label> 
                <input type="radio" id="low" name="level" value="low" checked>
            </div>
            <div class="item radio-container">
                <label for="medium">Medium</label>
		        <input type="radio" id="medium" name="level" value="medium">
            </div>
            <div class="item radio-container">
                <label for="high">High</label>
                <input type="radio" id="high" name="level" value="high"><br><br><br><br>
            </div>
        </div>

        <label for="weight">Weight(kg):</label>
        <input type="number" id="weight" name="weight"><br><br>

		<!--drop-down list / combobox-->
		<label for="water">Water Consumtion(Litre):</label>
		<input type="number" id="watercon" name="watercon"><br><br>
		
			<div class="buttons">
				<button type="submit" id="submit" name="submit">Add</button>
				<button type="reset" value="Clear" id="reset" name="reset" class="clear">Clear</button>	
			</div>
	</form>
</div>
</body>
</html>