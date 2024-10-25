<?php
$detailsID= isset($_GET["detailsID"])?$_GET["detailsID"]:"";

require 'connect.php';

$sql = "SELECT * FROM details WHERE detailsID=$detailsID";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
	$detailsID=$row["detailsID"]; 
	$routine=$row["routine"];
	$date=$row["rdate"];
	$stime=$row["stime"];
	$duration = $row["duration"];
	$sets = $row["sets"];
	$level=$row["level"];
	$weight = $row["weight"];
    $watercon = $row["watercon"];
  }
} 

mysqli_close($conn);
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

button.cancel {
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
	<form name="update" action="update.php" method="POST">
		<h2>Exercise Info</h2>

        <input type="hidden" name="detailsID" value="<?php echo htmlspecialchars($detailsID); ?>">

        <label for="routine">Routine:</label>
        <input type="text" size="25" id="routine" name="routine" 
		maxlength="30" placeholder="eg. Push Up" required value="<?php echo htmlspecialchars($routine); ?>"><br><br>

        <label for="rdate">Date:</label>
		<input type="date" id="rdate" name="rdate" readonly value="<?php echo htmlspecialchars($date); ?>" max="2025-12-31"><br><br>

        <label for="stime">Starting Time:</label>
        <input type="time" size="25" id="stime" name="stime" value="<?php echo htmlspecialchars($stime); ?>"><br><br>

		<div class="container">
			<div class="item">
            <label for="duration">Durations(Minutes):</label>
		        <select name="duration" id="type">
				    <option value="10min" <?php echo ($duration == "10min") ? 'selected' : ''; ?>>10</option>
				    <option value="20min" <?php echo ($duration == "20min") ? 'selected' : ''; ?>>20</option>
				    <option value="30min" <?php echo ($duration == "30min") ? 'selected' : ''; ?>>30</option>
				    <option value="40min" <?php echo ($duration == "40min") ? 'selected' : ''; ?>>40</option>
				    <option value="50min" <?php echo ($duration == "50min") ? 'selected' : ''; ?>>50</option>
				    <option value="60min" <?php echo ($duration == "60min") ? 'selected' : ''; ?>>60</option>
		        </select>
			</div>

			<div class="item">
                <label for="sets">Sets:</label>
                <input type="number" id="sets" name="sets" value="<?php echo htmlspecialchars($sets); ?>"><br><br>
			</div>
		</div>

        <label for="Intensity">Intensity Level:</label>
        <div class="container">
            <div class="item radio-container">	
                <label for="low">Low</label> 
                <input type="radio" id="low" name="level" value="low" <?php echo ($level == "low") ? 'checked' : ''; ?> checked>
            </div>
            <div class="item radio-container">
                <label for="medium">Medium</label>
		        <input type="radio" id="medium" name="level" value="medium" <?php echo ($level == "low") ? 'checked' : ''; ?>>
            </div>
            <div class="item radio-container">
                <label for="high">High</label>
                <input type="radio" id="high" name="level" value="high" <?php echo ($level == "low") ? 'checked' : ''; ?>><br><br><br><br>
            </div>
        </div>

        <label for="weight">Weight(kg):</label>
        <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($weight); ?>"><br><br>


		<label for="water">Water Consumtion(Litre):</label>
		<input type="number" id="watercon" name="watercon" value="<?php echo htmlspecialchars($watercon); ?>"><br><br>
		
			<div class="buttons">
				<button type="submit" id="submit" name="submit">Update</button>
				<button type="button" onclick="window.history.back();" class="cancel">Cancel</button>   
			</div>
	</form>
</div>
</body>
</html>


