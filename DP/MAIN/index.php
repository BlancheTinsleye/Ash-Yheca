<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (!isset($_SESSION['user_id'])) { 
        header("Location: /DP/landing.php");
        exit(); 
    }
}


include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
include '../FUNCTIONS/language.php';

echo isset($_SESSION['user_id']) ? '' : header("Location: /DP/landing.php");

$actveParentCategory = $_GET['page'] ?? '';
$activeCategory = $_GET['category'] ?? '';

// SQL query to fetch products based on parent category and category_id (subcategory)
$query = "SELECT * FROM products WHERE 1=1"; // Start with a base query
$params = [];
$types = "";

// Filter by parent category (if selected)
if ($actveParentCategory) {
    $query .= " AND parent_category = ?";
    $types .= "i"; // Assuming parent_category is an integer
    $params[] = $actveParentCategory;
}

// Filter by category_id (subcategory) if selected
if ($activeCategory) {
    $query .= " AND category_id = ?";
    $types .= "i"; // Assuming category_id is an integer
    $params[] = $activeCategory;
}

// Prepare and execute the query
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}
?>

<!-- Your HTML here -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <link rel="stylesheet" href="STYLES/index_style.css">
    <link rel="stylesheet" href="STYLES/dmt_gmt_pgkn_iba_style.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css ">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=settings" />
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
                    <p><span class="D">DISENYO</span><span class="P">PILIPINO</span></p>
                </a>
            </div>
            <form class="search_bar" method="GET" action="">
                <input class="srch_bx" type="text" name="search" placeholder="Ilagay ang pangalan ng produkto" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="search_icon" type="submit"><span class="material-symbols-outlined" id="search_icon">search</span></button>
            </form>
            
            <div class="nav_cnt">
                <a href="profile.php"><span class="material-symbols-outlined"  id="icon_profile">person</span></a>
                <a href="likes.php"><span class="material-symbols-outlined"  id="icon_heart">favorite</span></a>
                <a href="bayong.php"><span class="material-symbols-outlined"  id="icon_sb">shopping_bag</span></a>
                
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>
    </header>

    <main>
        <div class="navbar">
            <a href="?page=1" class="<?php echo ($actveParentCategory == '1') ? 'active' : ''; ?>"><?php echo $texts['clothes'] ?? 'LANGUAGE'; ?></a>
            <a href="?page=2" class="<?php echo ($actveParentCategory == '2') ? 'active' : ''; ?>"><?php echo $texts['items'] ?? 'LANGUAGE'; ?></a>
            <a href="?page=3" class="<?php echo ($actveParentCategory == '3') ? 'active' : ''; ?>"><?php echo $texts['food'] ?? 'LANGUAGE'; ?></a>
        </div>

        <div class="prdct_cont_search">
            <?php 
                if (isset($_GET['search'])) {
                    
                    $search_query = $_GET['search'];
                    $search_query = $conn->real_escape_string($search_query);
                    $like_query = "%" . $search_query . "%";
                
                    // Show filter when search
                    echo '
                    <form class="filter_form" method="GET" action="">
                        <input type="hidden" name="search" value="' . htmlspecialchars($search_query) . '">
                        <label class="fltr_txt" for="filter_type">Filter:</label>
                        <select id="filter_type" name="filter_type">
                            <option value="">Mamili ng filter</option>
                            <option value="price" ' . (isset($_GET['filter_type']) && $_GET['filter_type'] === 'price' ? 'selected' : '') . '>Presyo</option>
                            <option value="rating" ' . (isset($_GET['filter_type']) && $_GET['filter_type'] === 'rating' ? 'selected' : '') . '>Marka</option>
                        </select>
                
                        <label for="order_type"></label>
                        <select id="order_type" name="order_type">
                            <option value="">Mamili ng pagkakasunod</option>
                            <option value="asc" ' . (isset($_GET['order_type']) && $_GET['order_type'] === 'asc' ? 'selected' : '') . '>Pataas</option>
                            <option value="desc" ' . (isset($_GET['order_type']) && $_GET['order_type'] === 'desc' ? 'selected' : '') . '>Pababa</option>
                        </select>
                    
                        <button type="submit" class="ayusin_bttn">Ayusin</button>
                    </form>
                    ';
                }
                    
                if (isset($_GET['search'])) {
                    $search_query = $_GET['search'];
                    $search_query = $conn->real_escape_string($search_query);
                    $like_query = "%" . $search_query . "%";
                    
                        
                    $filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : null;
                    $order_type = isset($_GET['order_type']) ? $_GET['order_type'] : null;
                    $order_by = "";
                    
    
                    if ($filter_type === 'price') {
                        if ($order_type === 'asc') {
                            $order_by = "ORDER BY products.price ASC";
                        } elseif ($order_type === 'desc') {
                            $order_by = "ORDER BY products.price DESC";
                        }
                    } elseif ($filter_type === 'rating') {
                        if ($order_type === 'asc') {
                            $order_by = "ORDER BY products.rate ASC";
                        } elseif ($order_type === 'desc') {
                            $order_by = "ORDER BY products.rate DESC";
                        }
                    }
                    
                       
                    $query = "
                        SELECT products.product_id, products.product_img, products.name, products.price, products.rate
                        FROM products 
                        LEFT JOIN categories AS direct_category ON products.category_id = direct_category.category_id 
                        LEFT JOIN categories AS parent_category ON products.parent_category = parent_category.category_id 
                        WHERE (products.name LIKE ? 
                        OR direct_category.category_name LIKE ? 
                        OR parent_category.category_name LIKE ?)
                        $order_by
                    ";
                    
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("sss", $like_query, $like_query, $like_query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                        
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <a href="view_product.php?product_id=' . htmlspecialchars($row['product_id']) . '">
                                <div class="search_rslt_cont">
                                    <img class="prdct_img" src="' . htmlspecialchars($row['product_img']) . '" alt="' . htmlspecialchars($row['name']) . '">
                                    <div class="info_cont_search">
                                        <p class="">' . htmlspecialchars($row['name']) . '</p>
                                        <p class="">' . htmlspecialchars($row['price']) . '</p>
                                        <p class="">' . htmlspecialchars($row['rate']) . ' Stars</p>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo "<p>No products found.</p>";
                    }
                
                    $stmt->close();
                }
            ?>
            </div>
            
            <div class="prdct_fltr_cont">
                <div class="categories-products-container">
    
                    <?php if ($actveParentCategory == '1'): ?>
                        <ul class="ctgrs_cnt">
                            <li class="ctgry <?php echo ($activeCategory == 4) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=1&category=4"><?php echo $texts['for_girls'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 5) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=1&category=5"><?php echo $texts['for_boys'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 6) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=1&category=6"><?php echo $texts['for_kids'] ?? 'LANGUAGE'; ?></a>
                            </li>
                        </ul>
                    <?php elseif ($actveParentCategory == '2'): ?>
                        <ul class="ctgrs_cnt">
                            <li class="ctgry <?php echo ($activeCategory == 7) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=2&category=7"><?php echo $texts['for_home'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 8) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=2&category=8"><?php echo $texts['for_kitchen'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 9) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=2&category=9"><?php echo $texts['for_outside'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 10) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=2&category=10"><?php echo $texts['for_stuffs'] ?? 'LANGUAGE'; ?></a>
                            </li>
                        </ul>
                    <?php elseif ($actveParentCategory == '3'): ?>
                        <ul class="ctgrs_cnt">
                            <li class="ctgry <?php echo ($activeCategory == 11) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=3&category=11"><?php echo $texts['side_dish'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 12) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=3&category=12"><?php echo $texts['sweets'] ?? 'LANGUAGE'; ?></a>
                            </li>
                            <li class="ctgry <?php echo ($activeCategory == 13) ? 'active' : ''; ?>">
                                <a class="cry" href="?page=3&category=13"><?php echo $texts['salty'] ?? 'LANGUAGE'; ?></a>
                            </li>
                        </ul>
                    <?php endif; ?>
    
                    
            
                    <div class="prdcts_cont" id="prdcts_cnt">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($product = $result->fetch_assoc()): ?>
                                <div class="product">
                                    <a class="clck_product" href="view_product.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">
                                        <img class="prdct_img" src="<?php echo htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        <p class="prdct_name"><?php echo htmlspecialchars($product['name']); ?></p>
                                        <p class="prdct_prc">Presyo: PHP <?php echo htmlspecialchars($product['price']); ?></p>
                                    </a>
                                </div>
            
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No products found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    
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
    </main>


    

    <script src="../FUNCTIONS/main.js"></script>
</body>
</html>