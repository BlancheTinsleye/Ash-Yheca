<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    
    include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    // include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    include '../FUNCTIONS/language.php';
    include '../FUNCTIONS/login_func.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>

    <link rel="stylesheet" href="STYLES/busisi_edit_style.css">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <!-- <link rel="stylesheet" href="STYLES/header2_style.css"> -->
    <link rel="stylesheet" href="STYLES/settings_icon_style.css ">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=settings" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

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
                    <span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">ADMIN SIDE | I-edit ang produkto</span>
                </a>
            </div>
            <div class="nav_cnt">
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>  
    </header>
    <main>
        <div class="busisiin_prdct_cont">
            <div class="img_nm_cont">
                <?php

                    if (isset($_GET['product_id'])) {
                        $product_id = intval($_GET['product_id']); 
                        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
                        $stmt->bind_param("i", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            $crrnt_prdct = $result->fetch_assoc(); 
                        } else {
                            echo 'Product not found.';
                            exit;
                        }
                        
                        $stmt->close();
                    } else {
                        echo 'No product ID provided.';
                        exit;
                    }

                    echo '
                        <img src="'. htmlspecialchars($crrnt_prdct['product_img']) .'" class="prdct_img" alt="">
                        <form action="">
                            <input type="text" class="prdct_nm_inpt" placeholder="'. htmlspecialchars($crrnt_prdct['name']) .'">
                        </form>
                    '
                ?>
            </div>


            <div class="info_bttn_cont">
                <div>
                    <!-- <form action="">
                        <p class="prdct_id_txt">ID ng Produkto</p>
                    </form> -->
                    <div class="info_cont">
                        <div class="info_cont1">
                            <?php
                                echo '
                                    <p class="prdct_id_txt">'. ($texts['prdct_id'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_stock_txt">'. ($texts['stock'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_prc_txt">'. ($texts['price'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_grp_num_txt">'. ($texts['price'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_ktgry_txt">'. ($texts['categories'] ?? 'LANGUAGE') .'</p>
                                '
                            ?>
                        </div>
                        <div class="info_cont2">
                        

                            <?php
                                $sql = "SELECT * FROM categories ORDER BY parent_id, category_name"; 
                                $result = $conn->query($sql);

                                $categories = [];
                                $result = $conn->query("SELECT * FROM categories"); 
                                while ($row = $result->fetch_assoc()) {
                                    $categories[] = $row;
                                }

                                function displayParentCategories($categories, $selectedParentId = null) {
                                    foreach ($categories as $category) {
                                        if ($category['parent_id'] == 0) { 
                                            $selected = ($category['category_id'] == $selectedParentId) ? 'selected' : '';
                                            echo '<option value="'. htmlspecialchars($category['category_id']) .'" ' . $selected . '>' . htmlspecialchars($category['category_name']) . '</option>';
                                        }
                                    }
                                }

                                function displayChildCategories($categories, $parentId) {
                                    foreach ($categories as $category) {
                                        if ($category['parent_id'] == $parentId) { 
                                            echo '<option value="'. htmlspecialchars($category['category_id']) .'">' . htmlspecialchars($category['category_name']) . '</option>';
                                        }
                                    }
                                }

                                $selectedParentId = isset($_POST['parent_categories']) ? $_POST['parent_categories'] : null;
                                ?>


                            <form method="POST" action="" class="info_cont2_form">
                                
                                <p class="show_prdct_id"><?php echo $crrnt_prdct['product_id']?></p>
                                <input class="inp_prdct_stock" name="stock" value="<?php echo htmlspecialchars($crrnt_prdct['stock']); ?>" aria-valuenow="<?php echo htmlspecialchars($crrnt_prdct['stock']); ?>">
                                <input class="inp_prdct_prc" name="price" value="<?php echo htmlspecialchars($crrnt_prdct['price']); ?>" aria-valuenow="<?php echo htmlspecialchars($crrnt_prdct['price']); ?>">
                                <input class="inp_grp_num" name="grp_num" value="<?php echo htmlspecialchars($crrnt_prdct['group_prdct_num']); ?>" aria-valuenow="<?php echo htmlspecialchars($crrnt_prdct['group_prdct_num']); ?>">
                                <div class="ctgrs_cont">
                                    <select class="mga_ktgrya" name="parent_categories" id="parent_categories" onchange="this.form.submit()">
                                        <option value="">Select a parent category</option>
                                        <?php displayParentCategories($categories, $selectedParentId); ?>
                                    </select>

                                    <select class="mga_ktgrya" name="child_categories" id="child_categories">
                                        <option value="">Select a child category</option>
                                        <?php
                                        if ($selectedParentId) {
                                            displayChildCategories($categories, $selectedParentId);
                                        }
                                        ?>
                                    </select>
                                    </div>
                                
                            </form>   


                                <?php
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        if (isset($_POST['product_id'], $_POST['stock'], $_POST['price'])) {
                                            $productId = $_POST['product_id'];
                                            $newStock = $_POST['stock'];
                                            $newPrice = $_POST['price'];
                                    
                                            
                                            $stmt = $conn->prepare("UPDATE products SET stock = ?, price = ? WHERE product_id = ?");
                                            $stmt->bind_param("dii", $newStock, $newPrice, $productId);
                                    
                                            if ($stmt->execute()) {
                                                echo "<p>Product updated successfully!</p>";
                                            } else {
                                                echo "<p>Error updating product: " . $conn->error . "</p>";
                                            }
                                    
                                            $stmt->close();
                                        } else {
                                            echo "<p>Please fill in all fields.</p>";
                                        }
                                    }
                                ?>
                        </div>
                    </div>


                

                    <div class="dskrpsyn_bttn_cont">
                        <p class="dskrpsyn_txt">Deskripsyon</p>
                        <textarea class="dskrpsyn_inpt" name="" id=""></textarea>
                        <div class="bttns">
                            <button type="submit" class="save_prdct_bttn"><?php echo $texts['AS_save_edit_bttn'] ?? 'LANGUAGE'; ?></button>
                            <a href="busisi.php?product_id=<?php echo htmlspecialchars($crrnt_prdct['product_id']); ?>">
                                <button type="button" class="kansel_prdct_bttn"><?php echo $texts['cancel_edit_bttn'] ?? 'LANGUAGE'; ?></button>
                            </a>
                        </div>
                    </div> 
                </div>
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/SOFENG_PHP/DP/FUNCTIONS/logout.php'">yes</button> -->
                <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>

                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>


    
    <script src="../FUNCTIONS/main.js"></script>
</body>
</html>