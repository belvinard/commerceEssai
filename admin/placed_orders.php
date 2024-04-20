<?php
    // Reporting error
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../component/connection.php';

    // Start session
    session_start();

    // Print the entire session array for debugging
    /*echo '<pre>';
        print_r($_SESSION);
    echo '</pre>';*/

    // Check if admin_id is set in the session
    if (isset($_SESSION['admin_id'])) {
        //$admin_id = $_SESSION['admin_id'];
        //echo "Admin ID : " . $admin_id;
        //header('location:admin_login.php');
        
    } else {
        echo "Admin ID not set in the session.";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>placed orders</title>

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


    
    <!-- custom js file link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>
