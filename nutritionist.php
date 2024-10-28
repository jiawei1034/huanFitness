<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
        }
        .booking-card {
            display: flex;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
        }
        .booking-date {
            width: 70px;
            text-align: center;
            border-right: 1px solid #e0e0e0;
            padding-right: 15px;
        }
        .booking-date .day {
            font-size: 36px;
            font-weight: bold;
            color: #6366F1;
        }
        .booking-date .month {
            font-size: 16px;
            color: #4B5563;
        }
        .booking-details {
            flex-grow: 1;
            padding-left: 15px;
        }
        .booking-tags {
            margin-bottom: 5px;
        }
        .booking-tags .tag {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 5px;
        }
        .tag.pending {
            background-color: #ebf46c;
            color: #000;
        }
        .tag.confirmed {
            background-color: #DCFCE7;
            color: #16A34A;
        }
        .tag.cancelled {
            background-color: #FEE2E2;
            color: #B91C1C;
        }
        .booking-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #111827;
        }
        .booking-time, .booking-location {
            font-size: 14px;
            color: #6B7280;
        }
        .cancel-btn {
            margin-top: 10px;
            font-size: 14px;
            background-color: #EF4444;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }
        .cancel-btn:hover {
            background-color: #DC2626;
        }

        .accept-btn {
            margin-top: 10px;
            font-size: 14px;
            background-color: #65eb32;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }

        .accept-btn:hover {
            background-color: #4db924;
        }

        #booking-header {
            margin-left: 30%;
        }
    </style>
</head>
<body>
<?php
// Include the connection to your database
require 'connect.php';
// Query to fetch the latest booking or a specific one based on criteria
$sql = "SELECT name, booking_id, phoneNum, email, date, name, time, status FROM booking ORDER BY date DESC"; // Modify query as needed to filter results
$result = $conn->query($sql);

echo '<h2 id="booking-header">My Appointments</h2>';
// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row (for now, just one row since we're limiting it to 1 booking)
    while($row = $result->fetch_assoc()) {
        // Assuming 'date' is stored as 'YYYY-MM-DD' or similar in the database
        $date = DateTime::createFromFormat('Y-m-d', $row['date']);
        
        // Check if $date was successfully parsed
        if ($date !== false) {
            $day = $date->format('d');
            $month = strtoupper($date->format('M')); // Convert month to uppercase
        } else {
            // Default values if date parsing fails
            $day = 'XX';
            $month = 'XXX';
        }

        // Determine the class for the status tag based on the status
        $statusClass = strtolower($row['status']); // Convert status to lowercase for class matching

        // Display booking details in HTML structure
        echo '
        <div class="booking-card">
            <div class="booking-date">
                <div class="day">' . $day . '</div>
                <div class="month">' . $month . '</div>
            </div>
            <div class="booking-details">
                <div class="booking-tags">
                    <span class="tag badminton">APPOINTMENT</span>
                    <span class="tag ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span>
                </div>
                <div class="booking-title">' . htmlspecialchars($row['name']) . '</div>
                <div class="booking-time">' . htmlspecialchars($row['time']) . '</div>
                <div class="booking-location">Huan Fitness Centre</div>
                 <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST">
                    <input type="hidden" name="update_status" value="COMFIRMED">
                    <button class="accept-btn" type="submit">Accept</button>
                </form>
                <button class="cancel-btn">Cancel</button>
            </div>
        </div>';
    }
} else {
    echo "No bookings found.";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_status = $_POST['update_status'];
    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE booking set status = 'CONFIRMED' WHERE booking_id = 100004");
    
    // Execute the query
    if ($stmt->execute()) {
        // Set a success message to be displayed
        $successMessage = "Updated Successful!";
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Error: " . $stmt->error;
    }
    
}
?>

    <!-- Include Font Awesome for the arrow icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
</body>
</html>
