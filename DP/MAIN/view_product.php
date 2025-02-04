<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    include '../FUNCTIONS/language.php';
    include '../FUNCTIONS/login_func.php';

    echo isset($_SESSION['current_user']) ? '' : header("Location: /DP/landing.php");

    if (isset($_SESSION['notification'])) {
        echo '
            <div id="like_message_cont">
                <p>'. htmlspecialchars($_SESSION['notification']) .'</p>
                <span class="close-btn" onclick="close_like_message()">&times;</span>
            </div>
        ';
        // echo "<p style='color: green;'>" . $_SESSION['notification'] . "</p>";
        unset($_SESSION['notification']); // Clear the message after displaying it
    }

    $activePage = isset($_GET['page']) ? $_GET['page'] : 'tahanan';
    $activeCategory = isset($_GET['category']) ? $_GET['category'] : '';

    
    $product_id = $_GET['product_id'] ?? null;

    if ($product_id) {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Display product information using $product array
        } else {
            echo "Product not found.";
        }

        $stmt->close();
    } else {
        // echo "Invalid product.";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="STYLES/view_product_style.css">
        <link rel="stylesheet" href="STYLES/main_header.css">
        <link rel="stylesheet" href="STYLES/settings_icon_style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>DISENYO PILIPINO</title>
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
                        <p><span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">PRODUKTO</span></p>
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
            <div class="vw_prdct_product_info_cont">
                <div class="vw_prdct_img_cont">
                    <img src="<?php echo htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" alt="" class="vw_prdct_img">
                </div>
                <div class="vw_prdct_info_cont">
                    <div class="vw_prdct_bsc_info_cnt">
                        <div class="vw_prdct_nm">
                            <p class="product_name">Product name<br>
                            <?php echo htmlspecialchars($product['name']); ?>
                            </p>
                        </div>
                        <div class="vw_prdct_prc_rate_cont">
                            <div class="vw_prdct_prc_rate_txt_cont">
                                <p class="vw_prdct_prc">Presyo: PHP <?php echo htmlspecialchars($product['price']); ?></p>
                                <p class="vw_prdct_prdct_rate">Rate: <?php echo htmlspecialchars($product['rate']); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="vw_prdct_dskrpsyn_cont">
                        <p class="vw_prdct_dskrpsyn_txt">Description</p>
                        <div class="vw_prdct_dskrpsyn">
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                        </div>
                    </div>
                    <div class="vw_prdct_add_lks_byng_cont">
                        <form action="../FUNCTIONS/add_to_likes.php" method="post">
                            <button class="material-symbols-outlined" id="vw_prdct_add_to_likes_icon">favorite</button>
                            <input type="hidden" name="like_id" value="<?php echo 1; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['current_user']; ?>">
                            <input type="hidden" name="crrnt_page" value="/DP/MAIN/view_product.php?product_id=<?php echo $product_id; ?>">
                        </form>
                        <form method="POST" action="../FUNCTIONS/addtocart.php">
                            <button class="material-symbols-outlined" id="vw_prdct_add_to_byng_icon">shopping_bag</button>
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>"> 
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>"> 
                            <input type="number" name="quantity" value="1" min="1">
                        </form>        
                    </div>
                </div>
                
            </div>
            <div class="vw_prdct_other_cont">
                <div class="vw_prdct_suggested_prdcts_cont">

                    <?php
                        $all_prdcts = "SELECT * FROM products";
                        $result = $conn->query($all_prdcts);
                    
                        if ($result->num_rows > 0) {
                        // output data of each row
                            while($row = $result->fetch_assoc()) {
                                if ($row["group_prdct_num"] == $product['group_prdct_num']) {
                                    echo '
                                        <div class="vw_prdct_suggested_prdcts">
                                            id: '. htmlspecialchars($row["product_id"]).'<br> Name: '. htmlspecialchars($row["name"]).'
                                        </div>
                                    ';
                                    // echo "id: " . $row["product_id"]. " - Name: " . $row["name"]. "<br>";
                                }
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                    
                    <div class="vw_prdct_suggested_prdcts">
                        
                    </div>
                    <div class="vw_prdct_suggested_prdcts">

                    </div>
                    <div class="vw_prdct_suggested_prdcts">

                    </div>
                    <div class="vw_prdct_suggested_prdcts">

                    </div>
                    <div class="vw_prdct_suggested_prdcts">

                    </div>
                </div>
                
                <div class="vw_prdcts_rvw_cont">
                    <p class="reviews_txt">Reviews</p>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut harum inventore est laborum repudiandae odio, dicta doloribus voluptate eos amet unde officia, ducimus reprehenderit repellendus dolore quibusdam ad asperiores fugiat.Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                    <div class="vw_prdcts_rvw">
                        <div class="vw_prdcts_rvw_head">
                            <p class="buyer_name">Buyer</p>
                            <p class="rvw_rate_txt">Review <span class="rvw_rate">* * * * *</span></p>
                        </div>
                        <p class="rvw_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At molestiae atque nihil beatae harum repudiandae, nisi dolorem accusamus, vel deserunt laboriosam animi, expedita molestias aliquid! Saepe hic repudiandae ipsum non!</p>
                    </div>
                        
                    <!-- </div> -->
                </div>
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/SOFENG_PHP/COMPILED/landing.php'">yes</button>  -->
                <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>
    </body>

    <script>
        function close_like_message() {
            document.getElementById('like_message_cont').style.display = 'none';
        }
    </script>

    <script src="../FUNCTIONS/main.js"></script>
</html>