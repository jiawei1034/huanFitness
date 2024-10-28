<?php
session_start();
require 'connect.php';

// Prepare the SQL query for fetching records from the last week for the current user
$sqlLastWeek = "SELECT * FROM details WHERE rdate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND userID = ?";
$stmt = $conn->prepare($sqlLastWeek);
$stmt->bind_param('i', $_SESSION['userID']);
$stmt->execute();
$resultLastWeek = $stmt->get_result();

// Handle search functionality
$key = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($key)) {
    // Modify the query to include a search condition
    $sqlLastWeek = "SELECT * FROM details WHERE rdate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND routine LIKE ? AND userID = ?";
    $stmt = $conn->prepare($sqlLastWeek);
    
    // Using '%' for wildcards around the search key
    $likeKey = "%" . $key . "%";
    $stmt->bind_param('si', $likeKey, $_SESSION['userID']);
    $stmt->execute();
    $resultLastWeek = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Huan Fitness</title>
    <style>
        /* Your existing styles */
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
            box-shadow: 0 4px 6px rgba(0,0,0,0.3); 
            padding: 15px; 
        }

        .exercise-card { 
            background-color: #f9f9f9; 
            padding: 15px; 
            margin: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.2); 
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
            width: 82%;
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
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php require 'navbar.php'; ?>

<div class="container">
    <h1>Exercise Last Week</h1>

    <div class="search-container">
        <form action="viewLastWeek.php" method="GET">
           <input type="text" name="search" placeholder="Search by routine..." class="search-box">
           <button type="submit" class="search-btn">Search</button>
       </form>
    </div>

    <?php if ($resultLastWeek && mysqli_num_rows($resultLastWeek) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($resultLastWeek)): ?>
            <div class="exercise-card">
                <h2>Routine: <?php echo htmlspecialchars($row['routine']); ?></h2>
                <p>Water Consumption: <?php echo htmlspecialchars($row['watercon']); ?> liters</p>
                <p>Weight: <?php echo htmlspecialchars($row['weight']); ?> kg</p>
                <p>Duration: <?php echo htmlspecialchars($row['duration']); ?> minutes</p>
                <p>Starting Time: <?php echo htmlspecialchars($row['stime']); ?></p>
                <p>Sets: <?php echo htmlspecialchars($row['sets']); ?></p>
                <p>Intensity Level: <?php echo htmlspecialchars($row['level']); ?></p>

                <!-- Ensure that you have the correct field name for the unique identifier -->
                <a class="btn" href="updateform.php?detailsID=<?php echo $row['id']; ?>">Update</a>
                <a class="btn" href="delete.php?detailsID=<?php echo $row['id']; ?>">Delete</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No exercises recorded for the last week.</p>
    <?php endif; ?>

</div>

<?php
$conn->close();
?>
</body>
</html>