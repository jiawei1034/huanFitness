<?php
session_start();
require 'connect.php';
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>User View</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User View Details
                        <a href="admin.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div> 
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        if (!isset($conn)) {
                            die("<h4>Database connection not established.</h4>");
                        }
                        $user_id = mysqli_real_escape_string($conn, $_GET['id']);
                        
                        // Query to fetch user details
                        $query = "SELECT * FROM userdata WHERE userID = '$user_id'";
                        $query_run = mysqli_query($conn, $query) or die("Query failed: " . mysqli_error($conn));

                        if (mysqli_num_rows($query_run) > 0) {
                            $user = mysqli_fetch_assoc($query_run);
                            ?>
                            <!-- Display user details -->
                            <div class="mb-3">
                                <label>User ID</label>
                                <p class="form-control"><?php echo htmlspecialchars($user['userID']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>User Phone</label>
                                <p class="form-control"><?php echo htmlspecialchars($user['phoneNum']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>User Email</label>
                                <p class="form-control"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <p class="form-control"><?php echo htmlspecialchars($user['dateOfBirth']); ?></p>
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <p class="form-control"><?php echo htmlspecialchars($user['gender']); ?></p>
                            </div>
                            <?php
                        } else {
                            echo "<h4>No matching user ID found.</h4>";
                        }
                    } else {
                        echo "<h4>User ID not provided in URL.</h4>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>