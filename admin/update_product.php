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
        //echo "Admin ID not set in the session.";
    }

    if(isset($_POST['update'])){
        $pid = $_POST['pid'] ?? '';
        $name = $_POST['name'] ?? '';
        $name = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = $_POST['price'] ?? '';
        $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $details = $_POST['details'] ?? '';
        $details = filter_var($details, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
        $update_product->execute([$name, $price, $details, $pid]);



        $errorMessage[] = 'product updated successfully!';

        $old_image_01 = $_POST['old_image_01'];
        $image_01 = $_FILES['image_01']['name'];
        $image_01 = filter_var($image_01, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_01_size = $_FILES['image_01']['size'];
        $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
        $image_01_folder = '../uploaded_img/' . $image_01;

        if(!empty($image_01)){
            if($image_01_size > 2000000){
                $errorMessage = 'image size is too large!';
            }else{
                $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
                $update_image_01->execute([$image_01, $pid]);
                move_uploaded_file($image_01_tmp_name, $image_01_folder);
                unlink('../uploaded_img/'.$old_image_01);
                $errorMessage[] = 'image 01 updated successfully!';
            }
        }
        
        $old_image_02 = $_POST['old_image_02'];
        $image_02 = $_FILES['image_02']['name'];
        $image_02 = filter_var($image_02, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_02_size = $_FILES['image_02']['size'];
        $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
        $image_02_folder = '../uploaded_img/' . $image_02;

        if(!empty($image_02)){
            if($image_02_size > 2000000){
                $errorMessage = 'image size is too large!';
            }else{
                $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
                $update_image_02->execute([$image_02, $pid]);
                move_uploaded_file($image_02_tmp_name, $image_02_folder);
                unlink('../uploaded_img/'.$old_image_02);
                $errorMessage[] = 'image 02 updated successfully!';
            }
        }

        $old_image_03 = $_POST['old_image_03'];
        $image_03 = $_FILES['image_03']['name'];
        $image_03 = filter_var($image_03, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $image_03_size = $_FILES['image_03']['size'];
        $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
        $image_03_folder = '../uploaded_img/' . $image_03;

        if(!empty($image_03)){
            if($image_03_size > 2000000){
                $errorMessage = 'image size is too large!';
            }else{
                $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
                $update_image_03->execute([$image_03, $pid]);
                move_uploaded_file($image_03_tmp_name, $image_03_folder);
                unlink('../uploaded_img/'.$old_image_03);
                $errorMessage[] = 'image 03 updated successfully!';
            }
        }

        
    }

    var_dump($_POST);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product update</title>

    <!-- link to css file -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <!-- Link to update products css -->
    <link rel="stylesheet" href="../css/update_product.css">
    <!-- link font awesom -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <?php include '../component/admin_header.php';?>

    <!-- update product section starts -->

    <section class="update-product">

    <h1 class="heading">update product</h1>

        <?php
            $update_id = $_GET['update'];
            $show_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $show_products->execute([$update_id]);
            if($show_products->rowCount() > 0){
                while($fetch_products=$show_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
            <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
            <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
            <div class="image-container">
                <div class="main-image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">;
                </div>
                <div class="sub-image">
                    <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">;
                    <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">;
                    <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">;
                </div>
            </div>
            <span>update name</span>
            <input type="text" required placeholder="enter product name" class="box" name="name" maxlength="100" value="<?= $fetch_products['name']; ?>">
            <span>update price</span>
            <input type="number" min="0" max="9999999999" placeholder="enter product price" class="box" name="price"
            onkeypress="if(this.value.length == 10) return false;">
            <span>update details</span>
            <textarea name="details" class="box" placeholder="enter product details" maxlength="500" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
            <!-- <textarea name="details" class="box" placeholder="enter product details" maxlength="500" cols="30" rows="10" value="<?= $fetch_products['details']; ?>"></textarea> -->
            <span>update image_01</span>
            <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <span>update image_02</span>
            <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            <span>update image_03</span>
            <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
            
            <div class="flex-btn">
                <!-- <input type="hidden" name="update" value="1"> -->

                <input type="submit" name="update" class="btn" value="update">
                <a href="products.php" class="option-btn">go back</a>
            </div>
        </form>
        <?php
        }
            }else{
                echo '<p class="empty">no products added yet!</p>';
            }
        ?>
    </section>
    <!-- update product section ends -->


    
    <!-- custom js file link -->
    <script src="../js/update-product.js"></script>
    <script src="../js/admin_script.js"></script>
</body>
</html>
