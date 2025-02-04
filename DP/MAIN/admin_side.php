<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    
    include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    // include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/db.php');
    include '../FUNCTIONS/language.php';
    
    echo isset($_SESSION['current_user']) ? '' : header("Location: /DP/landing.php");

    

    if (isset($_POST['delete_product_id'])) {
        // header("location: index.php");
        
        $delete_id = intval($_POST['delete_product_id']);
        $delete_sql = "DELETE FROM products WHERE product_id = ?";

        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $_SESSION['alert'] = 'Product deleted successfully.';
        } else {
            $_SESSION['alert'] = 'Error deleting product: ' . $conn->error;
        }

        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    $alert = isset($_SESSION['alert']) ? $_SESSION['alert'] : null;
    unset($_SESSION['alert']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DISENYO PILIPINO</title>

        <link rel="stylesheet" href="STYLES/admin_side_style.css">
        <link rel="stylesheet" href="STYLES/main_header.css">
        <link rel="stylesheet" href="STYLES/settings_icon_style.css ">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=settings" />

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <script>
            window.onload = function () {
                <?php if ($alert):  ?>
                    alert("<?php echo addslashes($alert) ?>");
                <?php endif; ?>
            };
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
                <a href="admin_side.php" class="dp">
                    <span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">ADMIN SIDE</span>
                </a>
            </div>
            <div class="add_prdct_bttn_cont">
                <a href="add_prdct.php">
                    <button class="add_prdct_bttn">Magdagdag ng produkto</button>
                </a>
            </div>
            <div class="add_prdct_bttn_cont">
                <a href="order.php">
                    <button class="add_prdct_bttn">ORDERS</button>
                </a>
            </div>
            <div class="shipped_bttn_cont add_prdct_bttn_cont">
                <a href="shipped.php">
                    <button class="shipped_bttn">SHIPPED</button>
                </a>
            </div>
            <div class="delivered_bttn_cont add_prdct_bttn_cont">
                <a href="delivered.php">
                    <button class="delivered_bttn">DELIVERED</button>
                </a>
            </div>
            <div class="nav_cnt">
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>
    </header>
    
    <main>
        <div class="column_heading_cont">
            <div class="column_heading_as">
                <p class="ch1_as"><?php echo $texts['product'] ?? 'LANGUAGE'; ?></p>
                <p class="ch2_as"><?php echo $texts['price'] ?? 'LANGUAGE'; ?></p>
                <p class="ch3_as"><?php echo $texts['stock'] ?? 'LANGUAGE'; ?></p>
            </div>
        </div>

        <?php
            
            $sql = "SELECT * FROM products"; 
            $result = $conn->query($sql);

            
            if ($result->num_rows > 0) {
                
                foreach ($result as $product) {
                    if (empty($product['product_id'])) {
                        echo '<p>Error: Product ID is missing.</p>';
                        continue;
                    }

                    echo '<div class="prdct_cont">
                                <img class="prdct_img" src="'. htmlspecialchars($product['product_img']) .'" alt="Product Image">
                                <p class="prdct_name">' . htmlspecialchars($product['name']) . '</p>
                                <p class="prdct_prc">' . htmlspecialchars($product['price']) . '</p>
                                <p class="inp_val">' . htmlspecialchars($product['stock']) . '</p>
                                
                            
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_product_id" value="'. htmlspecialchars($product['product_id']) .'">
                                <button type="submit" class="delete_bttn">' . ($texts['remove_bttn'] ?? 'LANGUAGE') . '</button>
                            </form>
                            </div>';
                }
            } else {
                echo "No products found.";
            }
            
            $conn->close();
        ?>
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/logout.php'">yes</button> -->
                <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>




        
    </body>

    

    <script src="../FUNCTIONS/main.js"></script>
</html>
