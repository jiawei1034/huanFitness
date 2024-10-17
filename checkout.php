<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : "";
    $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : "";
    $zip = isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : "";
    $cardName = isset($_POST['card_name']) ? htmlspecialchars($_POST['card_name']) : "";
    $cardNumber = isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : "";
    $expiryDate = isset($_POST['expiry_date']) ? htmlspecialchars($_POST['expiry_date']) : "";
    $cvv = isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : "";

    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";
        $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
        $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : "";
        $city = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : "";
        $zip = isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : "";
        $cardName = isset($_POST['card_name']) ? htmlspecialchars($_POST['card_name']) : "";
        $cardNumber = isset($_POST['card_number']) ? htmlspecialchars($_POST['card_number']) : "";
        $expiryDate = isset($_POST['expiry_date']) ? htmlspecialchars($_POST['expiry_date']) : "";
        $cvv = isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : "";
    
        // Additional validations
        if (empty($name) || empty($email) || empty($address) || empty($city) || empty($zip) || empty($cardName) || empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
            echo "<div class='error'><h2>Please fill in all the required fields.</h2></div>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='error'><h2>Invalid email format.</h2></div>";
        } elseif (!is_numeric($cardNumber) || strlen($cardNumber) < 13 || strlen($cardNumber) > 19) {
            echo "<div class='error'><h2>Invalid card number.</h2></div>";
        } else {
            // Process payment...
        }
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 35%; /* Made it narrower */
            margin: auto;
            padding: 20px; /* Reduced padding */
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px; /* Reduced margin between fields */
        }

        label {
            display: block;
            margin-bottom: 5px; /* Reduced label spacing */
            font-size: 16px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px; /* Reduced input padding */
            margin-top: 3px; /* Reduced margin between label and input */
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px; /* Reduced font size */
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="date"]:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .card-details {
            margin-top: 20px; /* Reduced spacing above card details */
        }

        button {
            width: 100%;
            padding: 12px; /* Reduced button padding */
            background-color: #007BFF;
            color: white;
            font-size: 16px; /* Reduced button font size */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .confirmation, .error {
            text-align: center;
            padding: 15px; /* Reduced padding */
            margin-top: 15px;
            border-radius: 8px;
        }

        .confirmation {
            background-color: #e0f7e9;
            color: #2e7d32;
        }

        .error {
            background-color: #ffe9e9;
            color: #d32f2f;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%; /* Adjust for smaller screens */
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<form method = "post" action = "success.php">
<div class="container">
    <h2>Secure Payment Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- Billing Information -->
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <input type="text" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="zip">Zip Code</label>
            <input type="text" id="zip" name="zip" required>
        </div>

        <!-- Payment Information -->
        <div class="card-details">
            <h3>Card Details</h3>

            <div class="form-group">
                <label for="card_name">Name on Card</label>
                <input type="text" id="card_name" name="card_name" required>
            </div>

            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="number" id="card_number" name="card_number" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="number" id="cvv" name="cvv" required>
            </div>
        </div>

        <button type="submit">Submit Payment</button>
    </form>
</div>

</body>
</html>
