<?php
session_start();
require 'connect.php';

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to generate a random userID
function generateUserID() {
    return rand(100000, 999999); // Generates a random number between 100000 and 999999
}

if (isset($_POST['add_user'])) {
    // Get user details from the form
    $userID = generateUserID(); // Generate a random userID
    $phoneNum = mysqli_real_escape_string($conn, $_POST['phoneNum']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['dateOfBirth']);
    $is_admin = 0; // Default value for is_admin

    // Insert user into the database
    $query = "INSERT INTO userdata (userID, phoneNum, email, password, gender, dateOfBirth, is_admin) 
              VALUES ('$userID', '$phoneNum', '$email', '$password', '$gender', '$dateOfBirth', '$is_admin')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "User added successfully!";
        header("Location: admin.php"); // Redirect to admin page
        exit(0);
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add User</title>
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Add User</h4>
                <a href="admin.php" class="btn btn-danger">Back</a> <!-- Back button -->
            </div>
            <div class="card-body">
                <form action="user-create.php" method="POST">
                    <div class="mb-3">
                        <label>Phone Number</label>
                        <input type="text" name="phoneNum" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="dateOfBirth" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
