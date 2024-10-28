<?php
session_start();
require 'connect.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Edit</title>
</head>
<body>
    <div class="container mt-5">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Edit
                            <a href="admin.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $user_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $query = "SELECT * FROM userdata WHERE userID='$user_id'";
                            $query_run = mysqli_query($conn, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $user = mysqli_fetch_array($query_run);
                        ?>
                        <form action="code.php" method="POST">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['userID']); ?>">
                            <div class="mb-3">
                                <label>User Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>User Phone</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user['phoneNum']); ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($user['dateOfBirth']); ?>" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Admin Status</label>
                                <select name="is_admin" class="form-control">
                                    <option value="1" <?= $user['is_admin'] ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0" <?= !$user['is_admin'] ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                            </div>
                        </form>
                        <?php
                            } else {
                                echo "<h4>No Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>