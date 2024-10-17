<?php
require 'connect.php';

$successMessage = ''; // Initialize a variable to hold success message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phoneNum = $_POST['phoneNum'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $nutritionist = $_POST['nutritionist'];

    // Convert the date to the format YYYY-MM-DD
    $dateTime = DateTime::createFromFormat('F d, Y', $date);
    if ($dateTime) {
        $date = $dateTime->format('Y-m-d'); // Format to YYYY-MM-DD
    } else {
        // Handle error: unable to parse date
        echo "Invalid date format.";
        exit; // Stop further execution if date is invalid
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO booking (name, phoneNum, email, date, time, nutritionist) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Bind parameters (s for string)
    $stmt->bind_param("ssssss", $name, $phoneNum, $email, $date, $time, $nutritionist);

    // Execute the query
    if ($stmt->execute()) {
        // Set a success message to be displayed
        $successMessage = "Booking Successful!";
        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <style>
        /* Same styles as before */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: "Inter", Arial, Helvetica, sans-serif;
        }
        .formbold-mb-5 {
            margin-bottom: 20px;
        }
        .formbold-pt-3 {
            padding-top: 12px;
        }
        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }
        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
        }
        .formbold-form-label {
            display: block;
            font-weight: 500;
            font-size: 16px;
            color: #07074d;
            margin-bottom: 12px;
        }
        .formbold-form-input,
        .formbold-form-select {
            width: 100%;
            padding: 12px 24px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: white;
            font-weight: 500;
            font-size: 16px;
            color: #6b7280;
            outline: none;
        }
        .formbold-btn {
            text-align: center;
            font-size: 16px;
            border-radius: 6px;
            padding: 14px 32px;
            border: none;
            font-weight: 600;
            background-color: #6a64f1;
            color: white;
            width: 100%;
            cursor: pointer;
        }
        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <div class="formbold-mb-5">
                    <label for="name" class="formbold-form-label">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Full Name" class="formbold-form-input" required />
                </div>

                <div class="formbold-mb-5">
                    <label for="phoneNum" class="formbold-form-label">Phone Number</label>
                    <input type="text" name="phoneNum" id="phoneNum" placeholder="Enter your phone number" class="formbold-form-input" required />
                </div>

                <div class="formbold-mb-5">
                    <label for="email" class="formbold-form-label">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" class="formbold-form-input" required />
                </div>

                <div class="formbold-mb-5">
                    <label for="date" class="formbold-form-label">Select Date</label>
                    <select name="date" id="date" class="formbold-form-select" required>
                        <option value="October 11, 2024">October 11, 2024</option>
                        <option value="October 12, 2024">October 12, 2024</option>
                        <option value="October 13, 2024">October 13, 2024</option>
                    </select>
                </div>

                <div class="formbold-mb-5">
                    <label for="time" class="formbold-form-label">Select Time Slot</label>
                    <select name="time" id="time" class="formbold-form-select" required>
                        <option value="1:00 PM - 2:30 PM">1:00 PM - 2:30 PM</option>
                        <option value="3:00 PM - 4:30 PM">3:00 PM - 4:30 PM</option>
                        <option value="5:00 PM - 6:30 PM">5:00 PM - 6:30 PM</option>
                    </select>
                </div>

                <div class="formbold-mb-5">
                    <label for="nutritionist" class="formbold-form-label">Select Your Nutritionist</label>
                    <select name="nutritionist" id="nutritionist" class="formbold-form-select" required>
                        <option value="MR DICKSON DUCK">MR DICKSON DUCK</option>
                        <option value="MISS EMILY TAN">MISS EMILY TAN</option>
                        <option value="MR JAY CHOU">MR JAY CHOU</option>
                    </select>
                </div>

                <div>
                    <button class="formbold-btn">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Booking Success Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 style="color: #3bd373; margin-bottom: 3%;"><?php if (!empty($successMessage)) echo $successMessage; ?></h2>
            <p>Your booking has been confirmed. You will be redirected shortly.</p>
        </div>
    </div>

    <script>
        // Show the modal if the booking was successful
        <?php if (!empty($successMessage)): ?>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = document.getElementById("bookingModal");
                modal.style.display = "block";
                setTimeout(function() {
                    window.location.href = "view_booking.php"; // Redirect after 3 seconds
                }, 3000); // 3000 milliseconds = 3 seconds
            });

            // Close the modal when the user clicks on <span> (x)
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
                modal.style.display = "none";
                window.location.href = "view_booking.php"; // Redirect immediately on close
            }

            // Close the modal when the user clicks anywhere outside of the modal
            window.onclick = function(event) {
                var modal = document.getElementById("bookingModal");
                if (event.target == modal) {
                    modal.style.display = "none";
                    window.location.href = "view_booking.php"; // Redirect immediately on close
                }
            }
        <?php endif; ?>
    </script>
</body>
</html>
