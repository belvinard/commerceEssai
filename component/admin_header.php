<!-- Display error message -->
<?php
// Reporting error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if 'admin_id' session variable is set
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page or handle the situation as per your requirement
    header('Location: admin_login.php');
    exit(); // Make sure to exit after redirecting
}

$admin_id = $_SESSION['admin_id'];
//echo "Admin ID set in session: " . $_SESSION['admin_id'] . "<br>";
$select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Debug output
// echo '<pre>';
// print_r($fetch_profile);
// echo '</pre>';

// Check if $fetch_profile is an array before accessing its elements
/*if (is_array($fetch_profile) && isset($fetch_profile['name'])) {
    echo "<p>{$fetch_profile['name']}</p>";
} else {
    echo "<p>No profile found</p>";
}*/

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

<header class="header">
    <section class="flex">
        <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>
        <nav class="navbar">
            <a href="../admin/dashboard.php">home</a>
            <a href="../admin/products.php">products</a>
            <a href="../admin/placed_orders.php">orders</a>
            <a href="../admin/admin_accounts.php">admin</a>
            <a href="../admin/users_accounts.php">users</a>
            <a href="../admin/messages.php">messages</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="profile">
            <?php
            // Check if $fetch_profile is an array before accessing its elements
            if (is_array($fetch_profile) && isset($fetch_profile['name'])) {
                echo "<p>{$fetch_profile['name']}</p>";
            } else {
                echo "<p>No profile found</p>";
            }
            ?>
            <a href="../admin/update_profile.php" class="btn">update profile</a>
            <div class="flex-btn">
                <a href="../admin/admin_login.php" class="option-btn">login</a>
                <a href="../admin/register_admin.php" class="option-btn">register</a>
            </div>
            <a href="../component/admin_logout.php" class="delete-btn" onclick="return confirm('log out from this website?');">
                logout
            </a>
        </div>
    </section>
</header>
