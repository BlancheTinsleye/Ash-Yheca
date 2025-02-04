<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /DP/landing.php");
    exit();
}
include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
include '../FUNCTIONS/language.php';

$user_id = $_SESSION['user_id'];

// Fetch user information
$query = "SELECT first_name, last_name, address, email, phone_number FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <link rel="stylesheet" href="STYLES/check_out_style.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css">
    <script src="/DP/FUNCTIONS/main.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>Disenyo Pilipino</title>
</head>
<body>
<header class="header_cont">
    <div class="language_cont">
        <label for="languages"><?php echo $texts['language'] ?? 'LANGUAGE'; ?>:</label>
        <form id="languageForm">
            <select class="lang_dd" name="language" id="languages" onchange="changeLanguage(this.value)">
                <option value="tl" <?php echo ($selected_language === 'tl') ? 'selected' : ''; ?>>TAGALOG</option>
                <option value="en" <?php echo ($selected_language === 'en') ? 'selected' : ''; ?>>ENGLISH</option>
            </select>
        </form>
    </div>
        
    <div class="main_header_cont">
        <div class="logo_cont">
            <a href="index.php" class="dp">
                <p><span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">CHECK OUT</span></p>
            </a>
        </div>
        
        <div class="nav_cnt">
            <a href="profile.php"><span class="material-symbols-outlined" id="icon_profile">person</span></a>
            <a href="likes.php"><span class="material-symbols-outlined" id="icon_heart">favorite</span></a>
            <a href="bayong.php"><span class="material-symbols-outlined" id="icon_sb">shopping_bag</span></a>
            
            <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
        </div>
    </div>
</header>

<main>
    <div class="container">
        <form class="scrollable-cont">
                <div class="box product-info">
                    <?php
                    if (isset($_COOKIE['checkedProducts'])) {
                        $checkedProducts = json_decode($_COOKIE['checkedProducts'], true);
                    } else {
                        $checkedProducts = [];
                    }
                    if (!is_array($checkedProducts)) {
                        $checkedProducts = [];
                    }
                    foreach ($checkedProducts as $product) {
                        echo '
                        <div class="info-cont">
                            <div class="product-image">
                                <img src="' . htmlspecialchars($product['img']) . '" alt="Product Image">
                            </div>
                            <div class="form-cont">
                                <label class="tittle">' . htmlspecialchars($product['name']) . '</label>
                                <label>Presyo (PHP): ' . htmlspecialchars($product['price']) . '</label>
                                <label>Ilan: ' . htmlspecialchars($product['quantity']) . '</label>
                            </div>
                        </div>
                        ';
                    }
                    ?>
                </div>
                <div class="order-cont">
                    <div class="total-section">
                        <label>Total:</label>
                        <input type="text" id="total" value="<?php echo array_reduce($checkedProducts, function($carry, $item) {
                            return $carry + $item['price'] * $item['quantity'];
                        }, 0); ?>" readonly>
                    </div>
                </div>
        </form>

            <!-- Buyer Information Section -->
            <form class="box buyer-info">
                <label class="tittle">Pangalan ng Bumibili: <?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['last_name']); ?></label>
                <label class="address">Address: <?php echo htmlspecialchars($user['address']); ?></label>
                <label class="email">Email: <?php echo htmlspecialchars($user['email']); ?></label>
                <label class="numero">Numero: <?php echo htmlspecialchars($user['phone_number']); ?></label>
                <!-- <label for="payment">Mode of Payment: </label> -->
                <div class="butt-cont">
                    <div class="buttons">
                        <button class="buy-button" id="bilhinButton" type="button">Bilhin</button>
                    </div>
                </div>
            </form>
    </div>
</main>

<div id="menu_cont">
        <a class="faqs_bttn">FAQs</a>
        <button class="logout" id="logout_btn">Log out</button>
        <span class="close-btn" onclick="close_menu()">&times;</span>
    </div>
    <div id="logout_cont">
        <div class="question">
            are you sure?
        </div>
        <div class="log_out_bttn_cont">
            <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
            <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let bilhinButton = document.getElementById('bilhinButton');
        if (bilhinButton) {
            bilhinButton.addEventListener('click', function() {
                let checkedProducts = JSON.parse(localStorage.getItem('checkedProducts')) || [];

                $.ajax({
                    url: '/DP/FUNCTIONS/process_checkout.php',
                    type: 'POST',
                    data: { cartItems: JSON.stringify(checkedProducts) },
                    success: function(response) {
                        console.log(response); 

                        localStorage.removeItem('checkedProducts');
                        document.cookie = "checkedProducts=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                        window.location.href = '/DP/MAIN/index.php';
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        }
    });



    // Other JS functions for handling menu and logout
    function close_menu() {
        document.getElementById('menu_cont').style.display = 'none';
    }
    function close_question() {
        document.getElementById('logout_cont').style.display = 'none';
    }
    document.getElementById("logout_btn").addEventListener("click", function() {
        let logout = document.getElementById("logout_cont");
        logout.style.display = "flex";
    });
    document.getElementById("menu_icon").addEventListener("click", function() {
        let menu_cont = document.getElementById("menu_cont");
        menu_cont.style.display = "flex";
    });
</script>
</body>
</html>
