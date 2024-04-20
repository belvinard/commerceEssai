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
    <title>Dasboard</title>

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

    <!-- admin dashboard section starts -->
    <section class="dashboard">
        <h1 class="heading">dashboard</h1>

        <div class="box-container">

            <div class="box">
                    <h3>Welcome</h3>
                    <p><?= $fetch_profile['name'];?></p>
                    <a href="update_profile.php" class="btn">update porfile</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_pendings = 0;
                        $select_pendings = $conn ->prepare("SELECT * FROM `oders` WHERE payment_status = ?");
                        $select_pendings->execute(['pending']);
                        while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                        $total_pendings += $fetch_pendings['total_price '];
                        }
                    ?>
                    <h3><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
                    <p>total pendings</p>
                    <a href="placed_orders.php" class="btn">see orders</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_completes = 0;
                        $select_completes = $conn ->prepare("SELECT * FROM `oders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                            $total_completes += $fetch_completes['total_price '];
                        }
                    ?>
                    <h3><span>$</span><?= $total_completes; ?><span>/-</span></h3>
                    <p>total completes</p>
                    <a href="placed_orders.php" class="btn">see orders</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_orders = 0;
                        $select_orders = $conn ->prepare("SELECT * FROM `oders`");
                        $select_orders->execute();
                        $numbers_of_orders = $select_orders->rowCount();
                        /*while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                            $total_pendings += $fetch_pendings['total_price '];
                        }*/
                    ?>
                    <h3><?= $numbers_of_orders;?></h3>
                    <p>total orders</p>
                    <a href="placed_orders.php" class="btn">see orders</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_products = 0;
                        $select_products = $conn ->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $numbers_of_products = $select_products->rowCount();
                    ?>
                    <h3><?= $numbers_of_products;?></h3>
                    <p>products added</p>
                    <a href="products.php" class="btn">see products</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_users = 0;
                        $select_users = $conn ->prepare("SELECT * FROM `users`");
                        $select_users->execute();
                        $numbers_of_users = $select_users->rowCount();
                    ?>
                    <h3><?= $numbers_of_users;?></h3>
                    <p>users accounts</p>
                    <a href="users_accounts.php" class="btn">see accounts</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_admins = 0;
                        $select_admins = $conn ->prepare("SELECT * FROM `admins`");
                        $select_admins->execute();
                        $numbers_of_admins = $select_admins->rowCount();
                    ?>
                    <h3><?= $numbers_of_admins;?></h3>
                    <p>total admins</p>
                    <a href="admin_accounts.php" class="btn">see admins</a>
                </div>

                <div class="box">
                    <?php
                        // Reporting error
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);

                        $total_messages = 0;
                        $select_messages = $conn ->prepare("SELECT * FROM `messages`");
                        $select_messages->execute();
                        $numbers_of_messages = $select_messages->rowCount();
                    ?>
                    <h3><?= $numbers_of_messages;?></h3>
                    <p>new messages</p>
                    <a href="messages.php" class="btn">see messages</a>
                </div>
            </div>
        </div>

    
    </section>
    
    <!-- custom js file link -->
    <script src="../js/admin_script.js"></script>
</body>
</html>
