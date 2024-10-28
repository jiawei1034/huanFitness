<?php
// Get the detailsID from the URL
$detailsID = isset($_GET["detailsID"]) ? $_GET["detailsID"] : "";

// Connect to the database
require 'connect.php';

// Fetch the data for the given detailsID
$sql = "SELECT * FROM details WHERE id = $detailsID";
$result = mysqli_query($conn, $sql);

// Initialize variables to hold the data
$routine = $date = $stime = $duration = $sets = $level = $weight = $watercon = "";

// If the query returns a result, populate the form fields
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $detailsID = $row["id"]; 
        $routine = $row["routine"];
        $date = $row["rdate"];
        $stime = $row["stime"];
        $duration = $row["duration"];
        $sets = $row["sets"];
        $level = $row["level"];
        $weight = $row["weight"];
        $watercon = $row["watercon"];
    }
} else {
    echo "No data found for this ID.";
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Huan Fitness</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
        body { background: #edf7ed; height: 100vh; margin: 0; margin-top: -50px; }
        .container { display: flex; gap: 40px; }
        .item { flex: 1; }
        .box { width: 100%; height: auto; position: relative; padding: 20px; }
        form { background-color: white; padding: 15px 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; width: 100%; margin: 100px auto; }
        form h2 { margin-bottom: 20px; text-align: center; color: #333; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, input[type="radio"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; outline: none; transition: border 0.3s; }
        input[type="text"]:focus, input[type="number"]:focus, input[type="date"]:focus, input[type="time"]:focus, select:focus { border-color: #009688; }
        button { width: 100%; padding: 10px; background-color: #009688; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; margin-top: 10px; }
        button.cancel { background-color: #f44336; }
        button:hover { opacity: 0.9; }
        button:active { transform: scale(0.98); }
        .buttons { display: flex; gap: 40px; justify-content: space-between; }
        .radio-container { display: flex; align-items: center; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <?php require 'navbar.php'; ?>

    <div class="box">
        <form name="update" action="update.php" method="POST">
            <h2>Exercise Info</h2>

            <input type="hidden" name="detailsID" value="<?php echo htmlspecialchars($detailsID); ?>">

            <label for="routine">Routine:</label>
            <input type="text" id="routine" name="routine" maxlength="30" required value="<?php echo htmlspecialchars($routine); ?>"><br><br>

            <label for="rdate">Date:</label>
            <input type="date" id="rdate" name="rdate" value="<?php echo htmlspecialchars($date); ?>" readonly><br><br>

            <label for="stime">Starting Time:</label>
            <input type="time" id="stime" name="stime" value="<?php echo htmlspecialchars($stime); ?>"><br><br>

            <div class="container">
                <div class="item">
                    <label for="duration">Duration (Minutes):</label>
                    <select name="duration">
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

            <label for="level">Intensity Level:</label>
            <div class="container">
                <div class="item radio-container">
                    <label for="low">Low</label> 
                    <input type="radio" id="low" name="level" value="low" <?php echo ($level == "low") ? 'checked' : ''; ?>>
                </div>
                <div class="item radio-container">
                    <label for="medium">Medium</label>
                    <input type="radio" id="medium" name="level" value="medium" <?php echo ($level == "medium") ? 'checked' : ''; ?>>
                </div>
                <div class="item radio-container">
                    <label for="high">High</label>
                    <input type="radio" id="high" name="level" value="high" <?php echo ($level == "high") ? 'checked' : ''; ?>>
                </div>
            </div><br><br>

            <label for="weight">Weight (kg):</label>
<input type="number" id="weight" name="weight" step="0.01" value="<?php echo htmlspecialchars($weight); ?>"><br><br>

<label for="watercon">Water Consumption (Litre):</label>
<input type="number" id="watercon" name="watercon" step="0.01" value="<?php echo htmlspecialchars($watercon); ?>"><br><br>


            <div class="buttons">
                <button type="submit">Update</button>
                <button type="button" onclick="window.history.back();" class="cancel">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>