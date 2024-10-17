<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//retrieve & checked element's value using ?:
$user=empty($_POST["user"])?"":$_POST["user"];
$routine=empty($_POST["routine"])?"":$_POST["routine"];
$rdate=empty($_POST["rdate"])?"":$_POST["rdate"];
$height=empty($_POST["height"])?"":$_POST["height"];
$weight=empty($_POST["weight"])?"":$_POST["weight"];
$watercon=empty($_POST["watercon"])?"":$_POST["watercon"];

$record = date_create($rdate);
$sdate = date_format($record,"Y-m-d"); //convert date from timestamp to string

//set-up db connection
$servername="localhost";
$username="root";
$password="";
$dbname="huanfitness";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO details
(user,routine,rdate,day,month,height,weight,watercon) 
VALUES 
('$user','$routine','$rdate','$day','$month','$height','$weight','$watercon');";
echo $sql;

if(mysqli_query($conn,$sql)){
	echo "New record added sucessfully.";
}else{
	echo "Error: $sql<br>" . mysqli_error($conn);
}

mysqli_close($conn);
}
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

form {
    background-color: white;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 800px;
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

input[type="text"], input[type="number"], input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border 0.3s;
}

input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus {
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
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

		<h2>Fitness Information</h2>

		<!--Name Input-->
		<label for="name">Name</label>
        <input type="text" size="35" id="user" name="user" 
		maxlength="30" placeholder="eg. Jackson Wang" required><br><br>

		<div class="container">
			<div class="item">
				<label for="routine">Routine</label>
        		<input type="text" size="25" id="routine" name="routine" 
				maxlength="30" placeholder="eg. Push Up" required>
			</div>
			<div class="item">
				<!--calendar-->
				<label for="rdate">Date</label>
				<input type="date" id="rdate" name="rdate" value="<?=date("Y-m-d")?>"
				max="2025-12-31" min="<?php echo date("Y-m-d")?>"><br><br>
			</div>
		</div>

		<label for="height">Height(cm)</label>
        <input type="number" id="height" name="height">
        <label for="weight">Weight(kg)</label>
        <input type="number" id="weight" name="weight"><br><br>

		<!--drop-down list / combobox-->
		<label for="water">Water Consumtion(Litre)</label>
		<input type="number" id="watercon" name="watercon"><br><br>
		
			<div class="buttons">
				<button type="submit" formaction="h.php" value="Add" id="submit" name="submit">Add</button>
				<button type="reset" value="Clear" id="reset" name="reset" class="clear">Clear</button>	
			</div>
	</form>
</div>
</body>
</html>