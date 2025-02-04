<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
include '../FUNCTIONS/language.php';
include '../FUNCTIONS/login_func.php';

$categories = [];
$result = $conn->query("SELECT category_id, category_name, parent_id FROM categories");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imageLink = $_POST['image_link'];
    $productName = $_POST['product_name'];
    $productStock = $_POST['product_stock'];
    $productCategory = $_POST['product_category']; 
    $parentCategory = $_POST['parent_category']; 
    $productPrice = $_POST['product_price'];
    $productGroup = $_POST['product_group']; 
    $description = $_POST['description'];

    $currentTimestamp = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO products (product_img, name, stock, group_prdct_num, parent_category, category_id, price, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssiiiiisss", $imageLink, $productName, $productStock, $productGroup, $parentCategory, $productCategory, $productPrice, $description, $currentTimestamp, $currentTimestamp);

        if ($stmt->execute()) {
            $productId = $conn->insert_id;
            header("Location: admin_side.php");
            echo "<script>alert('New product added successfully with ID: $productId');</script>";
            exit();
        } else {
            echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
        }
    } else {
        echo "<script>alert('Statement preparation failed: " . htmlspecialchars($conn->error) . "');</script>";
    }

    $stmt->close();
    $conn->close();
}

function displayParentCategories($categories, $selectedParentId = null) {
    foreach ($categories as $category) {
        if ($category['parent_id'] == 0) {
            $selected = ($category['category_id'] == $selectedParentId) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($category['category_id']) . '" ' . $selected . '>' . htmlspecialchars($category['category_name']) . '</option>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>
    <link rel="stylesheet" href="STYLES/add_prdct_style.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css ">
    <link rel="stylesheet" href="STYLES/main_header.css">
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
                    <span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">ADMIN SIDE | Magdagdag ng produkto</span>
                </a>
            </div>
            <div class="nav_cnt">
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>  
    </header>

    <main>
        <form action="" method="POST" class="add_prdct_cont">
            <div class="img_nm_cont">
                <textarea name="image_link" class="cldnry_link" placeholder="Ilagay ang link ng imahe..." required></textarea>
                <input type="text" name="product_name" class="inpt_name" placeholder="Pangalan ng Produkto" required>
            </div>

            <div class="info_bttn_cont">
                <div>
                    <div class="info_cont">
                        <div class="info_cont1">
                            <p class="prdct_stock_txt">STOCK</p>
                            <p class="prdct_prc_txt">PRESYO</p>
                            <p class="prdct_grp_num_txt">GRP NO.</p>
                            <p class="prdct_ktgry_txt">KATEGORYA</p>
                        </div>
                        <div class="info_cont2">
                            <input type="number" name="product_stock" class="inp_prdct_stock" placeholder="Stock" required>
                            <input type="number" name="product_price" class="inp_prdct_prc" placeholder="Presyo" required>
                            <input type="number" name="product_group" class="inp_grp_num" placeholder="GRP NO">
                            <div class="ktgry_cont">
                                <select name="parent_category" class="mga_ktgrya" id="categories" required>
                                    <option value="">Pumili ng Kategorya</option>
                                    <?php displayParentCategories($categories); ?>
                                </select>
                                <select name="product_category" class="mga_ktgrya" id="child_categories" required>
                                    <option value="">Pumili ng Sub-Kategorya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="dskrpsyn_bttn_cont">
                        <p class="dskrpsyn_txt">Deskripsyon</p>
                        <textarea name="description" class="dskrpsyn_inpt" required></textarea>
                        <div class="bttns">
                            <button type="submit" class="save_prdct_bttn">i-save ang produkto</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/logout.php'">yes</button>     -->
                <button class="yes_bttn" onclick="window.location.href='/COMPILED-SEMIFINALS/FUNCTIONS/logout.php'">yes</button>    
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>







    <section style="display: none;">
        <!-- <div id="settings_cont">
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
        </div> -->
        <div class="top_cont">
            <div class="language_cont">
                <label for="languages">LINGWAHE:</label>
                <select class="lang_dd" name="languages" id="languages">
                    <option value="tagalog">TAGALOG</option>
                    <option value="english">ENGLISH</option>
                </select>
            </div>

            <div class="logo-page_name-icons">
                <div class="logo_cont">
                    <img class="logo" src="https://res.cloudinary.com/damtc4g0q/image/upload/v1726674128/DISENYO_PILIPINO2_atlzui.png" alt="disenyo pilipino logo">
                </div>
                <p class="page_name">ADMIN SIDE | Magdagdag ng Produkto</p>
                <div class="icons_cont">
                    <span class="material-symbols-outlined" id="icon_profile">person</span>
                    <span class="material-symbols-outlined" id="icon_heart">favorite</span>
                    <span class="material-symbols-outlined" id="icon_sb">shopping_bag</span>
                </div>
            </div>
        </div>

        <form action="" method="POST" class="add_prdct_cont">
            <div class="img_nm_cont">
                <textarea name="image_link" class="cldnry_link" placeholder="Ilagay ang link ng imahe..." required></textarea>
                <input type="text" name="product_name" class="inpt_name" placeholder="Pangalan ng Produkto" required>
            </div>

            <div class="info_bttn_cont">
                <div>
                    <div class="info_cont">
                        <div class="info_cont1">
                            <p class="prdct_stock_txt">STOCK</p>
                            <p class="prdct_prc_txt">PRESYO</p>
                            <p class="prdct_ktgry_txt">KATEGORYA</p>
                        </div>
                        <div class="info_cont2">
                            <input type="number" name="product_stock" class="inp_prdct_stock" placeholder="Stock" required>
                            <input type="number" name="product_price" class="inp_prdct_prc" placeholder="Presyo" required>
                            <div class="ktgry_cont">
                                <select name="parent_category" class="mga_ktgrya" id="categories" required>
                                    <option value="">Pumili ng Kategorya</option>
                                    <?php displayParentCategories($categories); ?>
                                </select>
                                <select name="product_category" class="mga_ktgrya" id="child_categories" required>
                                    <option value="">Pumili ng Sub-Kategorya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="dskrpsyn_bttn_cont">
                        <p class="dskrpsyn_txt">Deskripsyon</p>
                        <textarea name="description" class="dskrpsyn_inpt" required></textarea>
                        <div class="bttns">
                            <button type="submit" class="save_prdct_bttn">i-save ang produkto</button>
                            <button type="button" class="kansel_prdct_bttn">I-edit ang produkto</button> 
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        
        document.getElementById('categories').addEventListener('change', function() {
            const parentId = this.value;
            const childSelect = document.getElementById('child_categories');
            childSelect.innerHTML = '<option value="">Pumili ng Sub-Kategorya</option>'; 

            <?php foreach ($categories as $category): ?>
                if (parentId == '<?php echo $category['parent_id']; ?>') {
                    const option = document.createElement('option');
                    option.value = '<?php echo $category['category_id']; ?>';
                    option.textContent = '<?php echo addslashes($category['category_name']); ?>';
                    childSelect.appendChild(option);
                }
            <?php endforeach; ?>
        });


        
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
