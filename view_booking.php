<?php 
// Start the session and include necessary files
session_start();
require 'connect.php'; // Database connection
require 'navbar.php'; // Navbar (optional)

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_booking'])) {
    $booking_id = intval($_POST['booking_id']); // Get booking ID from the form

    // SQL to delete booking
    $sql = "DELETE FROM booking WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo "<p style='text-align: center; color: green;'>Booking cancelled successfully.</p>";
    } else {
        echo "<p style='text-align: center; color: red;'>Error cancelling booking. Please try again.</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booking</title>
    <style>
        /* CSS styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #EDF7ED;
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
        .booking-header {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
            color: #333;
        }
        .add-booking-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            text-decoration: none;
        }
        .add-booking-icon {
            background-color: #4AA583;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>
    <script>
        // Function to confirm booking cancellation
        function confirmCancellation() {
            return confirm("Are you sure you want to cancel this booking?");
        }
    </script>
</head>
<body>

<h2 class="booking-header">My Bookings</h2>

<!-- Add Booking Button -->
<a href="booking.php" class="add-booking-button">
    <div class="add-booking-icon">+</div>
</a>

<?php
// Query to fetch bookings for the logged-in user
$sql = "SELECT b.booking_id, b.name, b.phoneNum, b.date, b.time, b.status, nu.name AS nutritionist_name 
FROM booking b, nutritionist nu 
WHERE b.nutritionistID = nu.nutritionistID AND b.email = '" . $_SESSION['email'] . "' 
ORDER BY b.date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $date = DateTime::createFromFormat('Y-m-d', $row['date']);
        $day = $date ? $date->format('d') : 'XX';
        $month = $date ? strtoupper($date->format('M')) : 'XXX';

        $statusClass = strtolower($row['status']); // Convert status to lowercase for class matching

        echo '
        <div class="booking-card">
            <div class="booking-date">
                <div class="day">' . $day . '</div>
                <div class="month">' . $month . '</div>
            </div>
            <div class="booking-details">
                <div class="booking-tags">
                    <span class="tag badminton">APPOINTMENT</span>
                    <span class="tag tag ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span>
                </div>
                <div class="booking-title">' . htmlspecialchars($row['name']) . '</div>
                <div class="booking-time">' . htmlspecialchars($row['time']) . '</div>
                <div class="booking-location">Huan Fitness Centre</div>

                <!-- Cancel Booking Form -->
                <form method="POST" action="">
                    <input type="hidden" name="booking_id" value="' . htmlspecialchars($row['booking_id']) . '">
                    <button type="submit" class="cancel-btn" name="cancel_booking" onclick="return confirmCancellation()">Cancel</button>
                </form>
            </div>
        </div>';
    }
} else {
    echo "<p style='text-align: center; color: #888;'>No bookings found.</p>";
}

$stmt->close();
$conn->close();
?>

</body>
</html>
