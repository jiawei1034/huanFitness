<?php
session_start();
$detailsID = isset($_GET["detailsID"]) ? $_GET["detailsID"] : "";

require 'connect.php';

$date = isset($_GET['date']) ? $_GET['date'] : '';

$sql = "SELECT * FROM details WHERE rdate = ? AND userID = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('si', $date, $_SESSION['userID']);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("Query preparation failed: " . $conn->error);
}
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
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #edf7ed;
            display: flex;
            flex-direction: column;
            align-items: center; 
            padding: 20px; 
        }

        h1 {
            font-size: 36px;
            color: #333;
            padding: 20px;
        }

        .container {
            margin-top: 30px;
            max-width: 800px; 
            width: 100%;
            background-color: white; 
            border-radius: 8px; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); 
            padding: 15px; 
        }

        .exercise-card { 
            background-color: #f9f9f9; 
            padding: 15px; 
            margin: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
        }

        h2 { 
            text-align: left; 
            margin-bottom: 15px; 
            color: black; 
        }
        
        p {
            line-height: 1;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
            color: #333; 
            font-weight: bold;
            font-size: 16px; 
            padding: 10px; 
            border-radius: 5px; 
            border-left: 5px solid #009688; 
        }

        .btn { 
            margin-top: 10px;
            display: inline-block;
            background-color: #009688; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 5px; 
            text-align: center;
            text-decoration: none; 
        }

        .btn:hover {
            opacity: 0.8;
        }

        .search-container {
            text-align: center;
        }

        .search-box {
            width: 81%; 
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
    </style>
</head>
<body>
<?php require 'navbar.php'; ?>

<div class="container">
    <?php
    $fDate = date('M d', strtotime($date));
    ?>
    <h1>Exercise Records for <?php echo htmlspecialchars($fDate); ?></h1>

    <div class="search-container">
        <form action="viewSearch.php" method="GET">
            <input type="hidden" name="date" value="<?php echo htmlspecialchars($date); ?>">
            <input type="text" name="search" placeholder="Search by routine..." class="search-box">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="exercise-card">
                <h2>Routine: <?php echo htmlspecialchars($row['routine']); ?></h2>
                <p>Water Consumption: <?php echo htmlspecialchars($row['watercon']); ?> liters</p>
                <p>Weight: <?php echo htmlspecialchars($row['weight']); ?> kg</p>
                <p>Duration: <?php echo htmlspecialchars($row['duration']); ?>s</p>
                <p>Starting Time: <?php echo htmlspecialchars($row['stime']); ?></p>
                <p>Sets: <?php echo htmlspecialchars($row['sets']); ?></p>
                <p>Intensity Level: <?php echo htmlspecialchars($row['level']); ?></p>

                <?php if (isset($row['id'])): ?> <!-- Changed from detailsID to id based on your table structure -->
                    <a class="btn" href="updateform.php?detailsID=<?php echo urlencode($row['id']); ?>">Update</a>
                    <a class="btn" href="delete.php?detailsID=<?php echo urlencode($row['id']); ?>">Delete</a>
                <?php else: ?>
                    <p>Error: detailsID not found for this record.</p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No exercises recorded for this date.</p>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>
</body>
</html>