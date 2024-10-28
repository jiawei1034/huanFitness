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
        .tag.badminton {
            background-color: #E0E7FF;
            color: #6366F1;
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
            margin-left: 43%;
        }
    </style>
</head>
<body>
<?php
// Include the connection to your database
require 'connect.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_status'])) {
        $booking_id = intval($_POST['booking_id']);
        // Prepare the SQL statement to update the status
        $stmt = $conn->prepare("UPDATE booking SET status = 'CONFIRMED' WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Booking confirmed successfully!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error updating booking: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }

    if (isset($_POST['cancel_booking'])) {
        $booking_id = intval($_POST['booking_id']);
        // Prepare the SQL statement to delete the booking
        $stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Booking cancelled successfully!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error cancelling booking: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Query to fetch bookings
$sql = "SELECT name, booking_id, phoneNum, email, date, time, status FROM booking ORDER BY date DESC";
$result = $conn->query($sql);

echo '<h2 id="booking-header">Manage Bookings</h2>';
// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
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
                <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to accept this booking?\');">
                    <input type="hidden" name="update_status" value="CONFIRMED">
                    <input type="hidden" name="booking_id" value="' . htmlspecialchars($row['booking_id']) . '">
                    <button class="accept-btn" type="submit">Accept</button>
                </form>
                <form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to cancel this booking?\');">
                    <input type="hidden" name="cancel_booking" value="1">
                    <input type="hidden" name="booking_id" value="' . htmlspecialchars($row['booking_id']) . '">
                    <button class="cancel-btn" type="submit">Cancel</button>
                </form>
            </div>
        </div>';
    }
} else {
    echo "No bookings found.";
}

$conn->close();
?>

<!-- Include Font Awesome for the arrow icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
</body>
</html>
