<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /DP/landing.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/DP/MAIN/FUNCTIONS/db.php');
include '../FUNCTIONS/language.php';
include '../FUNCTIONS/login_func.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check connection
if ($conn->connect_error) {
    die('Connection Error: ' . $conn->connect_error);
}

// Fetch orders with products and product images that are not shipped
$sql = "
SELECT
    o.user_id,
    o.total_price,
    o.order_status,
    o.shipping_address,
    o.order_date,
    oi.product_id,
    oi.quantity,
    oi.price AS item_price,
    p.product_img,
    o.order_id
FROM
    orders o
JOIN
    order_items oi ON o.order_id = oi.order_id
JOIN
    products p ON oi.product_id = p.product_id
WHERE
    o.order_status != 'shipped'
ORDER BY
    o.order_date DESC
";

$result = $conn->query($sql);

if (!$result) {
    die('Query Error: ' . $conn->error);
}

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
} else {
    echo 'No orders found.';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>
    <link rel="stylesheet" href="STYLES/order_style.css">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <header class="header_cont">
        <div class="language_cont">
            </form>
        </div>
        <div class="main_header_cont">
            <div class="logo_cont">
                <a href="admin_side.php" class="dp">
                    <p><span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">Order</span></p>
                </a>
            </div>
            <div class="nav_cnt">
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>
    </header>

    <main>
        <div class="column_heading_cont">
            <div class="column_heading_nakuha">
                <p class="ch1_nkh">PRODUKTO</p>
                <p class="ch2_nkh">BILANG</p>
                <p class="ch3_nkh">PRESYO</p>
                <p class="ch4_nkh">TOTAL</p>
            </div>
        </div>
        <?php
        if (empty($orders)) {
            echo "<p>No orders.</p>";
        } else {
            foreach ($orders as $order) {
                $product_img = !empty($order['product_img']) ? htmlspecialchars($order['product_img']) : 'path/to/default_image.png'; // Default image path

                echo "
                    <div class='prdct_cont'>
                        <img class='prdct_img_nkh' src='$product_img' alt='Product Image'>
                        <p class='prdct_name_nkh'>" . htmlspecialchars($order["order_id"]) . "</p>
                        <p class='ilan_nkh'>" . htmlspecialchars($order["quantity"]) . "</p>
                        <p class='prdct_prc_nkh'>" . htmlspecialchars($order["item_price"]) . "</p>
                        <p class='ttl_nkh'>" . htmlspecialchars($order["item_price"] * $order["quantity"]) . "</p>
                        <form action='/DP/FUNCTIONS/update_orderstatus.php' method='POST'>
                            <input type='hidden' name='order_id' value='" . htmlspecialchars($order["order_id"]) . "'>
                            <input type='hidden' name='order_status' value='shipped'>
                            <button class='impormasyon_bttn' type='submit'>Ipinadala na</button>
                        </form>
                    </div>
                ";
            }
        }
        ?>
    </main>

    <div id="menu_cont">
        <a class="faqs_bttn">FAQs</a>
        <button class="logout" id="logout_btn">Log out</button>
        <span class="close-btn" onclick="close_menu()">&times;</span>
    </div>
    <div id="logout_cont">
        <div class="question">are you sure?</div>
        <div class="log_out_bttn_cont">
            <form action="../FUNCTIONS/logout.php"><button class="yes_bttn">yes</button></form>
            <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
        </div>
    </div>
    <script src="../FUNCTIONS/main.js"></script>
</body>
</html>
