<?php

// Include database connection
include '../component/connection.php';
// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:admin_login.php');
    exit;
}

// Get the admin ID from the session
$admin_id = $_SESSION['admin_id'];

// Fetch the admin's current details from the database
$select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Initialize an array to store error messages
$errorMessage = [];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form inputs
    $name = $_POST['name'];
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Validate form inputs
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if there's at least one field to update
    if (!empty($name) || !empty($old_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        // Check if old password is provided and matches the stored password
        if (!empty($old_pass) && !password_verify($old_pass, $fetch_profile['password'])) {
            $errorMessage[] = 'Invalid old password';
        }

        // Check if new password and confirm password match
        if (!empty($new_pass) && $new_pass != $confirm_pass) {
            $errorMessage[] = 'New password and confirm password do not match';
        }

        // If there are no errors, update the admin's profile
        if (empty($errorMessage)) {
            // Update name if provided
            if (!empty($name)) {
                $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
                $update_name->execute([$name, $admin_id]);
            }

            // Update password if provided
            if (!empty($new_pass)) {
                // Hash the new password
                $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

                $update_password = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
                $update_password->execute([$hashed_password, $admin_id]);
            }

            // Redirect to a success page or display a success message
            header('Location: update_profile.php');
            exit;
        }
    } else {
        // Display a message indicating that no changes were made
        $errorMessage[] = 'No changes were made.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>

    <!-- link to css file -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <!-- link font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <?php
    // Include the header
    include '../component/admin_header.php';
    ?>

    <!-- Admin profile section starts -->
    <section class="form_container">
        <form action="" method="post">
            <h3>Update Profile</h3>

            <input type="text" name="name" value="<?= $fetch_profile['name'] ?>" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">

            <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="password" name="confirm_pass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">

            <input type="submit" value="Update Now" class="btn" name="submit">

            <!-- Display error messages -->
            <?php
            /*if (!empty($errorMessage)) {
                echo '<div class="error">';
                foreach ($errorMessage as $error) {
                    echo '<p>' . $error . '</p>';
                }
                echo '</div>';
            }*/
            ?>
        </form>
    </section>
    <!-- Admin profile section ends -->

    <!-- custom js file link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>
