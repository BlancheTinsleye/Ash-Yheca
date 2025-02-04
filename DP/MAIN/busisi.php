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

    <link rel="stylesheet" href="STYLES/busisi_style.css">
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
                    <span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">ADMIN SIDE | Busisiin ang produkto</span>
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
                        <p class="prdct_nm">'. htmlspecialchars($crrnt_prdct['name']) .'</p>
                    '
                ?>
            </div>

            <div class="info_bttn_cont">
                <div>
                    <div class="info_cont">
                        <div class="info_cont1">
                            <?php
                                echo '
                                    <p class="prdct_id_txt">'. ($texts['prdct_id'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_stock_txt">'. ($texts['stock'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_prc_txt">'. ($texts['price'] ?? 'LANGUAGE') .'</p>
                                    <p class="prdct_grp_num_txt">GRP NO</p>
                                    <p class="prdct_ktgry_txt">'. ($texts['categories'] ?? 'LANGUAGE') .'</p>
                                '
                            ?>
                        </div>
                        <div class="info_cont2">
                            
                            <?php

                                $formatted_prod_id = sprintf("%011d", $product_id);
                                // print_r($crrnt_prdct);
                                $group_prct_num = isset($crrnt_prdct['group_prdct_num']) ? htmlspecialchars($crrnt_prdct['group_prdct_num']) : 'N/A';

                                echo '
                                    <p class="show_prdct_id">00'.  htmlspecialchars($crrnt_prdct['product_id']) .'</p>
                                    <p class="show_prdct_stock">'. htmlspecialchars($crrnt_prdct['stock']) .'</p>
                                    <p class="show_prdct_prc"><span class="php_txt">php </span>'. htmlspecialchars($crrnt_prdct['price']) .'</p>
                                    <p class="show_prdct_grp_num">'. $group_prct_num .'</p>
                                    <div class="ktgry_cont">
                                        <select class="mga_ktgrya" name="categories" id="categories">
                                            <option value="Kategorya_1">Kategorya 1</option>
                                            <option value="Kategorya_2">Kategorya 2</option>
                                        </select>
                                    </div>
                                    '
                                    ?>
                        </div>
                    </div>
                    <div class="dskrpsyn_bttn_cont">
                        <p class="dskrpsyn_txt"><?php echo $texts['description'] ?? 'LANGUAGE'; ?></p>
                        <p class="dskrpsyn_inpt" name="" id="" > <?php ($crrnt_prdct['description'])?></p>
                        
                        <?php

                        $sql = "SELECT * FROM products"; 
                        $result = $conn->query($sql);
                        
                        echo '
                            <form action="busisi_edit.php" class="bttn_cont">
                            <input type="hidden" name="product_id" value="'. htmlspecialchars($crrnt_prdct['product_id']) .'">
                            <button type="submit" class="edit_prdct_bttn">'. ($texts['AS_edit_prdct_bttn'] ?? 'LANGUAGE') .'</button>
                            </form>';
                        ?>
                        
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/SOFENG_PHP/DP/FUNCTIONS/logout.php'">yes</button>     -->
                <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>






    <section style="display: none;">
        <div class="header_cont">
                <div id="settings_cont">
                    <button class="logout" id="logout_btn">Log out</button>
                    <span class="close-btn" onclick="close_settings()">&times;</span>
                </div>

                <div id="logout_cont">
                    <div class="question">
                        are you sure?
                    </div>
                    <div class="log_out_bttn_cont">
                        <button class="yes_bttn">yes</button>
                        <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
                    </div>
                </div>
            <div class="top_cont">
                <div class="language_cont">
                <label for="languages"><?php echo $texts['language'] ?? 'LANGUAGE'; ?>:</label>
                    <form id="languageForm">
                        <select class="lang_dd" name="language" id="languages" onchange="changeLanguage(this.value)">
                            <option value="tl" <?php echo ($selected_language === 'tl') ? 'selected' : ''; ?>>TAGALOG</option>
                            <option value="en" <?php echo ($selected_language === 'en') ? 'selected' : ''; ?>>ENGLISH</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="logo-page_name-icons">
                <div class="logo_cont">
                    <a href="" class="logo_txt">
                        <p class="D">DISENYO</p>
                        <p class="P">PILIPINO</p>
                    </a>
                    <!-- <img class="logo" src="https://res.cloudinary.com/damtc4g0q/image/upload/v1726674128/DISENYO_PILIPINO2_atlzui.png" alt="disenyo pilipino logo"> -->
                </div>
                <p class="page_name">ADMIN SIDE | Busisiin ang Produkto</p>
                <div class="icons_cont">
                    <!-- <span class="material-symbols-outlined" id="icon_profile">person</span>
                    <span class="material-symbols-outlined" id="icon_heart">favorite</span>
                    <span class="material-symbols-outlined" id="icon_sb" >shopping_bag</span> -->
                    <a class="material-symbols-outlined" id="icon_settings">settings</a>

                </div>
            </div>
        </div>

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
                    <p class="prdct_nm">'. htmlspecialchars($crrnt_prdct['name']) .'</p>
                '
            ?>
        </div>

        <div class="info_bttn_cont">
            <div>
                <div class="info_cont">
                    <div class="info_cont1">
                        <?php
                            echo '
                                <p class="prdct_id_txt">'. ($texts['prdct_id'] ?? 'LANGUAGE') .'</p>
                                <p class="prdct_stock_txt">'. ($texts['stock'] ?? 'LANGUAGE') .'</p>
                                <p class="prdct_prc_txt">'. ($texts['price'] ?? 'LANGUAGE') .'</p>
                                <p class="prdct_ktgry_txt">'. ($texts['categories'] ?? 'LANGUAGE') .'</p>
                            '
                        ?>
                    </div>
                    <div class="info_cont2">
                        
                        <?php

                            $formatted_prod_id = sprintf("%011d", $product_id);
                            echo '
                                <p class="show_prdct_id">00'.  htmlspecialchars($crrnt_prdct['product_id']) .'</p>
                                <p class="show_prdct_stock">'. htmlspecialchars($crrnt_prdct['stock']) .'</p>
                                <p class="show_prdct_prc"><span class="php_txt">php </span>'. htmlspecialchars($crrnt_prdct['price']) .'</p>
                                <div class="ktgry_cont">
                                    <select class="mga_ktgrya" name="categories" id="categories">
                                        <option value="Kategorya_1">Kategorya 1</option>
                                        <option value="Kategorya_2">Kategorya 2</option>
                                    </select>
                                </div>
                                '
                                ?>
                    </div>
                </div>
                <div class="dskrpsyn_bttn_cont">
                    <p class="dskrpsyn_txt"><?php echo $texts['description'] ?? 'LANGUAGE'; ?></p>
                    <p class="dskrpsyn_inpt" name="" id="" > <?php ($crrnt_prdct['description'])?></p>
                    
                    <?php

                    $sql = "SELECT * FROM products"; 
                    $result = $conn->query($sql);
                    
                    echo '
                        <form action="busisi_edit.php" class="bttn_cont">
                        <input type="hidden" name="product_id" value="'. htmlspecialchars($crrnt_prdct['product_id']) .'">
                        <button type="submit" class="edit_prdct_bttn">'. ($texts['AS_edit_prdct_bttn'] ?? 'LANGUAGE') .'</button>
                        </form>';
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
    </section>
    <script>

        function close_menu() {
            document.getElementById('menu_cont').style.display = 'none';
        }

        function close_question() {
            document.getElementById('logout_cont').style.display = 'none';
        }
        
        document.getElementById("logout_btn").addEventListener("click", function() {
            // Show the notification
            let logout = document.getElementById("logout_cont");
            logout.style.display = "flex";
            
        });

        document.getElementById("menu_icon").addEventListener("click", function() {
            // Show the notification
            let menu_cont = document.getElementById("menu_cont");
            menu_cont.style.display = "flex";
            
        });
        
        function changeLanguage(language) {
            fetch('../FUNCTIONS/language.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `language=${language}`
            })
            .then(response => location.reload()); // Reloads the page to apply the new language
        }
    </script>
</body>
</html>