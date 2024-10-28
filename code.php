<?php
session_start();
include('connect.php');

// Delete User
if (isset($_POST['delete_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_user']);

    $query = "DELETE FROM userdata WHERE userID='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "User Deleted Successfully";
    } else {
        $_SESSION['message'] = "User Not Deleted";
    }
    header("Location: admin.php");
    exit(0);
}

// Update User
if (isset($_POST['update_user'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $is_admin = mysqli_real_escape_string($conn, $_POST['is_admin']);

    $query = "UPDATE userdata SET email='$email', phoneNum='$phone', gender='$gender', dateOfBirth='$date_of_birth', is_admin='$is_admin' WHERE userID='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "User Updated Successfully";
    } else {
        $_SESSION['message'] = "User Not Updated";
    }
    header("Location: admin.php");
    exit(0);
}

// Add User
if (isset($_POST['add_user'])) {
    // Get the next user ID
    $query = "SELECT MAX(userID) as max_id FROM userdata";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $next_user_id = $row['max_id'] + 1; // Increment by 1

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $is_admin = mysqli_real_escape_string($conn, $_POST['is_admin']);

    $query = "INSERT INTO userdata (userID, email, phoneNum, gender, dateOfBirth, is_admin) VALUES ('$next_user_id', '$email', '$phone', '$gender', '$date_of_birth', '$is_admin')";
    $query_run = mysqli_query($conn, $query);
    
    if ($query_run) {
        $_SESSION['message'] = "User Created Successfully";
    } else {
        $_SESSION['message'] = "User Not Created";
    }
    header("Location: user-create.php");
    exit(0);
}
?>