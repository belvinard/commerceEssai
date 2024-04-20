<?php
// Reporting error
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../component/connection.php';

// Start session
session_start();

$errorMessage = []; // Initialize an empty array for error messages

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //$pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Check if the user exists
    $query = "SELECT * FROM `admins` WHERE name = :name";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
        $_SESSION['admin_id'] = $row['id']; // Store the id in the session
        // Debugging statements
        //echo "Admin ID set in session: " . $_SESSION['admin_id'] . "<br>";
         
        //  print_r($row);
        //  echo "User data fetched: ";

        // Verify password
        if(password_verify($pass, $row['password'])){
            $_SESSION['name'] = $name;
            header("Location: dashboard.php");
            exit();
        } else {
            $errorMessage[] = "Invalid password"; // Append error message to the array
        }
    } else {
        $errorMessage[] = "User does not exist"; // Append error message to the array
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>

    <!-- link to css file -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <!-- link font awesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <!-- Display error message -->
    <?php
        if (!empty($errorMessage)) {
            foreach ($errorMessage as $error) {
                echo '
                <div class="message">
                    <span>' . $error . '</span>
                    <i class="fas fa-times" onclick="removeErrorMessage(this);"></i>
                </div>';
            }
        }
        echo "<script>
        function removeErrorMessage(element){
            element.parentElement.remove();
        }
        </script>"
    ?>
   
    <section class="form_container">

        <form action="" method="post">
            <h3>login now</h3>
            <p>default username = <span>fani</span> & password = <span>111</span></p>
       
            <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="submit" value="login now" class="btn" name="submit">

        </form>

    </section>

</body>
</html>
