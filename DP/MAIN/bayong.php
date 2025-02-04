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
// include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/DP/FUNCTIONS/db.php');

$user_id = $_SESSION['user_id'];  

$query = "SELECT sc.cart_id, sc.quantity, p.product_id, p.name, p.price, p.product_img 
        FROM shopping_cart sc 
        JOIN products p ON sc.product_id = p.product_id
        WHERE sc.user_id = ?"; 
$stmt = $conn->prepare($query); 

if ($stmt === false) { 
    die("Prepare failed: " . htmlspecialchars($conn->error)); 
} 

$stmt->bind_param("i", $user_id);
$stmt->execute(); 
$result = $stmt->get_result(); 
if ($result === false) { 
    die("Execute failed: " . htmlspecialchars($stmt->error)); 
} 
    
$prdcts = [];
while ($row = $result->fetch_assoc()) {
    $prdcts[] = $row; 
    error_log("Product ID: " . $row['product_id']);
} 
    
$stmt->close(); 
$conn->close(); 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>
    <link rel="stylesheet" href="STYLES/bayong_style.css">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script>
        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.prdct_cont').forEach(form => {
                const checkbox = form.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    const price = parseFloat(form.querySelector('.prdct_prc').textContent.replace('php ', ''));
                    const quantity = parseInt(form.querySelector('.inp_val').value);
                    total += price * quantity;
                }
            });
            document.querySelector('.total_cont .ttl').textContent = total.toFixed(2);
        }

        function changeQuantity(button, change) {
            const input = button.parentElement.querySelector('.inp_val');
            let newValue = parseInt(input.value) + change;
            if (newValue < 1) newValue = 1; 
            input.value = newValue;
            updateTotal();
            button.closest('form').submit();
        }
    </script>
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
                    <p><span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">Bayong</span></p>
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
    <div class="added_to_cart_prdcts">
            <div class="column_heading">
                <p class="ch1">PRODUKTO</p>
                <p class="ch2">PRESYO</p>
                <p class="ch3">BILANG</p>
            </div>
        </div>

        <?php
        // Display products with unique checkbox IDs and hidden cart_id field
        foreach ($prdcts as $product) {
            $checkboxId = 'customCheckbox_' . $product['cart_id'];
            echo '
                <form class="prdct_cont" action="/DP/FUNCTIONS/update_cart.php" method="POST">
                    <input type="hidden" name="cart_id" value="' . htmlspecialchars($product['cart_id']) . '">
                    <input type="checkbox" id="' . $checkboxId . '" 
                           data-cart-id="' . htmlspecialchars($product['cart_id']) . '" 
                           data-product-id="' . htmlspecialchars($product['product_id']) . '" 
                           data-name="' . htmlspecialchars($product['name']) . '" 
                           data-price="' . htmlspecialchars($product['price']) . '" 
                           data-img="' . htmlspecialchars($product['product_img']) . '" 
                           data-quantity="' . htmlspecialchars($product['quantity']) . '" 
                           onchange="updateTotal()">
                    <label class="cb-label" for="' . $checkboxId . '"></label>
                    <img class="prdct_img" src="'. htmlspecialchars($product['product_img']) .'">
                    <p class="prdct_name">' . htmlspecialchars($product['name']) . '</p>
                    <p class="prdct_prc">php ' . htmlspecialchars($product['price']) .'</p>
                    <div class="inp_bttn_cont">
                        <button type="button" class="minus" onclick="changeQuantity(this, -1)">-</button>
                        <input type="text" name="quantity" aria-valuenow="' . htmlspecialchars($product['quantity']) . '" value="' . htmlspecialchars($product['quantity']) . '" class="inp_val" oninput="updateTotal()">
                        <button type="button" class="plus" onclick="changeQuantity(this, 1)">+</button>
                    </div>
                    <form action="" method="">
                        <input type="hidden" name="cart_id" value="' . htmlspecialchars($product['cart_id']) . '">
                        <button type="submit" class="tanggalin_bttn" formaction="/DP/FUNCTIONS/removeproduct_cart.php" formmethod="POST">Tanggalin</button>
                    </form>
                </form>';
        }
        
        ?>

        <div class="filler_cont">
            &nbsp;
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
            <div class="log_out_bttn_cont" >
                <form action="../FUNCTIONS/logout.php"><button class="yes_bttn" >yes</button></form>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>

    
    
    <form class="lower_cont">
        <div class="total_cont">
            <p class="ttl_txt">TOTAL</p>
            <p class="php_txt">php</p>
            <p class="ttl">0.00</p>
        </div>
        <a href="check_out.php"><p class="checkout_bttn">i-checkout</p></a>
    </form>
    <script src="../FUNCTIONS/main.js"></script>
</body>

</html>
