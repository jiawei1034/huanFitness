<?php
session_start();
include('connect.php');

if(isset($_POST['delete user']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete user']);

    $query = "DELETE FROM user WHERE id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Users Deleted Sucessfully";
        header("Location: admin.php");
        exit(0);

    }
    else
    {
        $_SESSION['message'] = "Users Not Deleted";
        header("Location: admin.php");
        exit(0);

    }
    

}

if(isset($_POST['update_user']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['user id']);

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);


$query = "UPDATE users SET name='$name', email = '$email', phone='$phone', address='$email' 
           WHERE id='$user_id'";
           $query_run = mysqli_query($conn, $query);

           if($query_run)
           {
            $_SESSION['message'] = "Users Updated Succesfully";
            header("Location: admin.php");
            exit(0);

           }
           else
           {
            $_SESSION['message'] = "Users Not Updated";
            header("Location: admin.php");
            exit(0);

           }

}

if(isset($_POST['add_user'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $query = "INSERT INTO users (name,email,phone,address) VALUES 
    ('$name','$email','$phone','$address')";

    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Users Created Sucessfully";
        header("Location: user-create.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Users Not Created";
        header("Location: user-create.php");
        exit(0);
    }
}


?>