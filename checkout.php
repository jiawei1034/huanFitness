<?php
session_start(); // Start the session
require 'connect.php'; // Ensure you have a connect.php file to handle database connection



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve userID from session, if not available use a default (for testing)
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : 100002;

// Variables to hold form data
$name = $email = $address = $city = $zip = $cardName = $cardNumber = $expiryDate = $cvv = "";
$selected_plan = $price = "";

// On form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle membership update first
    if (isset($_POST['selected_plan']) && isset($_POST['price'])) {
        $selected_plan = $_POST['selected_plan'];
        $price = $_POST['price'];

        // Calculate expiry date (1 month from now)
        $date = new DateTime();
        $date->modify('+1 month');
        $expiryDate = $date->format('Y-m-d');

        // 1. Select current points from the database
        $stmt = $conn->prepare("SELECT total_point FROM membership WHERE userID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($currentPoints);
        $stmt->fetch();
        $stmt->close();

        // 2. Calculate the new total points
        $newPoints = $price; // Assume price is the new points earned
        $totalPoints = $currentPoints + $newPoints;

        // 3. Update the total points in the database
        $stmt = $conn->prepare("UPDATE membership SET membership_exp = ?, membership_status = ?, total_point = ? WHERE userID = ?");
        $stmt->bind_param("ssii", $expiryDate, $selected_plan, $totalPoints, $userID);
        
        if ($stmt->execute()) {
            // Store this info in session
            $_SESSION['selected_plan'] = $selected_plan;
            $_SESSION['price'] = $price;
        } else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }

    // Handle form data submission
    if (isset($_POST['name'])) {
        // Sanitize and store form values in variables
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $address = htmlspecialchars($_POST['address']);
        $city = htmlspecialchars($_POST['city']);
        $zip = htmlspecialchars($_POST['zip']);
        $cardName = htmlspecialchars($_POST['card_name']);
        $cardNumber = htmlspecialchars($_POST['card_number']);
        $expiryDate = htmlspecialchars($_POST['expiry_date']);
        $cvv = htmlspecialchars($_POST['cvv']);

        // Perform validation checks
        if (empty($name) || empty($email) || empty($address) || empty($city) || empty($zip) || empty($cardName) || empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
            echo "<script>alert('Please fill in all the required fields.');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.');</script>";
        } elseif (!is_numeric($cardNumber) || strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            echo "<script>alert('Invalid card number.');</script>";
        } elseif (!is_numeric($cvv) || (strlen($cvv) !== 3 && strlen($cvv) !== 4)) {
            echo "<script>alert('CVV must be 3 or 4 digits.');</script>";
        } else {
            // Redirect to success page if validation passes
            header("Location: success.php");
            exit;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            display: flex;
            align-items: flex-start; 
            height: 100vh;
            background-color: #edf7ed;
            margin: 0;
        }

        .container {
            display: flex; /* Use flexbox for layout */
            width: 100%;
        }

        .plan-group {
            width: 20%;
            height: 250px;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-top: 20%;
            margin-right:400px;
            margin-left: 200px;
        }

        .form-group {
            flex: 1; /* Allow the form to take up the remaining space */
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 3%;
        }

        h2 {
            font-size: 40px;
            color: #000000a5;
            margin-top: 5px; 
            margin-bottom: 10px;
            text-align: center; 
        }

        h3 {
            font-size: 40px;
            color: #000000a5;
            margin-top: 20px; 
            margin-bottom: 10px;
            text-align: center; 
        }

        p {
            font-size: 40px;
            color: #000000a5;
            margin-top: 20px; 
            margin-bottom: 10px;
            text-align: center; 
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
            color: #555;
            font-family: Arial, sans-serif;
        }

        input[type="text"], input[type="email"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="date"]:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .card-details {
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #019871;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #019871;
        }

        .confirmation, .error {
            text-align: center;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            font-size: 14px;
        }

        .confirmation {
            background-color: #e0f7e9;
            color: #2e7d32;
        }

        .error {
            background-color: #ffe9e9;
            color: #d32f2f;
        }

        /* Responsive styling for smaller screens */
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="plan-group">
        <h2>Selected Plan</h2><hr>
        <p><?= isset($_SESSION['selected_plan']) ? $_SESSION['selected_plan'] : ''; ?></p>
        <p><?= "RM" . (isset($_SESSION['price']) ? $_SESSION['price'] : '0') . ".00"; ?></p>
    </div>
    <div class="form-group">
        <h2>Secure Payment Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Billing Information -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>" required>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?php echo $city; ?>" required>
            </div>
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" id="zip" name="zip" value="<?php echo $zip; ?>" required>
            </div>
            <!-- Payment Information -->
            <div class="card-details">
                <h2>Card Details</h2>
                <div class="form-group">
                    <label for="card_name">Name on Card</label>
                    <input type="text" id="card_name" name="card_name" value="<?php echo $cardName; ?>" required>
                </div>
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="number" id="card_number" name="card_number" value="<?php echo $cardNumber; ?>" required>
                </div>
                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="date" id="expiry_date" name="expiry_date" value="<?php echo $expiryDate; ?>" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="number" id="cvv" name="cvv" value="<?php echo $cvv; ?>" required>
                </div>
            </div>
            <button type="submit">Submit Payment</button>
        </form>
    </div>
</div>
</body>
</html>
