<?php
    // Reporting error
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../component/connection.php';

    // Set session garbage collection max lifetime to 30 days (for example)
    ini_set('session.gc_maxlifetime', 30 * 24 * 60 * 60); // 30 days in seconds

    // Set session cookie lifetime to 30 days (for example)
    ini_set('session.cookie_lifetime', 30 * 24 * 60 * 60); // 30 days in seconds

    // Start session
    session_start();


    $admin_id = $_SESSION['admin_id'];
    //var_dump($_SESSION);
    


    if(!isset($admin_id)){
        header('location:admin_login.php');
    } else{
        //echo "Admin ID not set in the session.";
    }

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //$pass = filter_var($pass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Check if the user exists
        $query = "SELECT * FROM `admins` WHERE name = :name";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':name', $name);
        //$stmt->execute([$name]);
        $stmt->execute();
    
        if($stmt->rowCount() > 0){
           $errorMessage[] = 'User already exists !';
        } else {
            if($pass != $cpass){
                $errorMessage[] = 'confirm password not matched!';
            }else{
                // Hash the password
                $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

                // Insert the user into the database with hashed password
                $insert_admin = $conn->prepare("INSERT INTO `admins` (name, password) VALUES(?,?)");
                $insert_admin->execute([$name, $hashed_password]);
                //$insert_admin->execute([$name, $cpass]);

                $errorMessage[] = 'new admin registered!';
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- link to css file -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <!-- link font awesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <?php
        // Reporting error
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        include '../component/admin_header.php';
    ?>

    <!-- Register admin section starts -->
    <section class="form_container">

        <form action="" method="post">
            <h3>register new</h3>
            <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" autocomplete="off">
            <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="register now" class="btn" name="submit">
        </form>

    </section>
    <!-- Register admin section ends -->

    <!-- custom js file link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>