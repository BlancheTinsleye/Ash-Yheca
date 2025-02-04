<?php
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');

// Include other necessary files
include '../FUNCTIONS/language.php';
include '../FUNCTIONS/login_func.php';

// Redirect to the landing page if the user is not logged in
if (!isset($_SESSION['current_user'])) {
    header("Location: /DP/landing.php");
    exit();
}

// Set the active category
$activeCategory = isset($_GET['category']) ? $_GET['category'] : 1;


// Debugging
// echo "Current User: " . htmlspecialchars($_SESSION['current_user']) . "<br>";
// echo "User ID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>

    <link rel="stylesheet" href="STYLES/mga_pinamili_style.css">
    <link rel="stylesheet" href="STYLES/babayaran_style.css">
    <link rel="stylesheet" href="STYLES/ipapadala_style.css">
    <link rel="stylesheet" href="STYLES/parating_style.css">
    <link rel="stylesheet" href="STYLES/ibinalik_style.css">
    <link rel="stylesheet" href="STYLES/nakuha_style.css">
    <link rel="stylesheet" href="STYLES/ikinansela_style.css">
    <link rel="stylesheet" href="STYLES/main_header.css">
    <link rel="stylesheet" href="STYLES/settings_icon_style.css">

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
                    <p><span class="D">DISENYO</span><span class="P">PILIPINO</span></p>
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
        <ul class="ctgries">
            <!-- <li class="ctgry <?//php echo ($activeCategory == 'babayaran') ? 'active' : ''; ?>">
                        <a href="?category=babayaran">Babayaran</a>
                    </li> -->
                    <li class="ctgry <?php echo ($activeCategory == 'ipapadala') ? 'active' : ''; ?>">
                        <a href="?category=ipapadala">Ipapadala pa lamang</a>
                    </li>
                    <li class="ctgry <?php echo ($activeCategory == 'parating') ? 'active' : ''; ?>">
                        <a href="?category=parating">Parating</a>
                    </li>
                    <li class="ctgry <?php echo ($activeCategory == 'ibinalik') ? 'active' : ''; ?>">
                        <a href="?category=ibinalik">Ibinalik</a>
                    </li>
                    <li class="ctgry <?php echo ($activeCategory == 'nakuha') ? 'active' : ''; ?>">
                        <a href="?category=nakuha">Mga Nakuha na</a>
                    </li>
                    <li class="ctgry <?php echo ($activeCategory == 'ikinansela') ? 'active' : ''; ?>">
                        <a href="?category=ikinansela">Mga Ikinansela</a>
                    </li>
                </ul>
        </ul>
    
        <div>
            <?php
            switch ($activeCategory) {
                case 'ipapadala':
                    echo '<div class="column_heading_cont">
                            <div class="column_heading_ipapadala">
                                <p class="ch1_ippdl">
                                    PRODUKTO
                                </p>
                                <p class="ch2_ippdl">
                                    PRESYO
                                </p>
                                <p class="ch3_ippdl">
                                    ILAN
                                </p>
                                <p class="ch4_ippdl">
                                    TOTAL
                                </p>
                            </div>
                        </div>';

                        $all_pending = "SELECT
                            o.user_id, o.total_price, o.order_status, o.shipping_address,
                            o.order_date, oi.product_id, oi.quantity, oi.price AS item_price,
                            p.product_img, o.order_id
                            FROM orders o
                            JOIN order_items oi ON o.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id
                            ORDER BY o.order_date DESC";

                        $pending = $conn->query($all_pending);

                        if ($pending === false) {
                            echo "Error: " . $conn->error . "<br>";
                        } else if ($pending->num_rows > 0) {
                            $orders = $pending->fetch_all(MYSQLI_ASSOC);
                            // echo "Number of orders fetched: " . count($orders) . "<br>";

                            if (empty($orders)) {
                                echo "<p>No orders.</p>";
                            } else {
                                foreach ($orders as $order) {
                                    
                                    if ($_SESSION["user_id"] == $_SESSION['current_user'] && $order['order_status'] == 'shipped') {
                                        $product_img = !empty($order['product_img']) ? htmlspecialchars($order['product_img']) : 'path/to/default_image.png'; // Default image path
                                        echo "
                                            <div class='prdct_cont'>
                                                <img class='prdct_img_nkh' src='$product_img' alt='Product Image'>
                                                <p class='prdct_prc_nkh'>" . htmlspecialchars($order["item_price"]) . "</p>
                                                <p class='ilan_nkh'>" . htmlspecialchars($order["quantity"]) . "</p>
                                                <p class='ttl_nkh'>" . htmlspecialchars($order["item_price"] * $order["quantity"]) . "</p>
                                            </div>
                                        ";
                                    }
                                }
                            }
                        } else {
                            echo "0 results<br>";
                        }

                        $conn->close();
                    
                    break;
                case 'parating':
                    echo '<div class="column_heading_cont">
                            <div class="column_heading_parating">
                            <p class="ch1_prtng">
                                    PRODUKTO
                                </p>
                                <p class="ch2_prtng">
                                    BILANG
                                </p>
                                <p class="ch3_prtng">
                                PRESYO
                                </p>
                                <p class="ch4_prtng">
                                    TOTAL
                                </p>
                            </div>
                        </div>';
                        $all_shipped = "SELECT
                            o.user_id, o.total_price, o.order_status, o.shipping_address,
                            o.order_date, oi.product_id, oi.quantity, oi.price AS item_price,
                            p.product_img, o.order_id
                            FROM orders o
                            JOIN order_items oi ON o.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id
                            ORDER BY o.order_date DESC";

                        $shipped = $conn->query($all_shipped);

                        if ($shipped === false) {
                            echo "Error: " . $conn->error . "<br>";
                        } else if ($shipped->num_rows > 0) {
                            $orders = $shipped->fetch_all(MYSQLI_ASSOC);
                            // echo "Number of orders fetched: " . count($orders) . "<br>";

                            if (empty($orders)) {
                                echo "<p>No orders.</p>";
                            } else {
                                foreach ($orders as $order) {
                                    
                                    if ($_SESSION["user_id"] == $_SESSION['current_user'] && $order['order_status'] == 'pending') {
                                        $product_img = !empty($order['product_img']) ? htmlspecialchars($order['product_img']) : 'path/to/default_image.png'; // Default image path
                                        echo "
                                            <div class='prdct_cont'>
                                                <img class='prdct_img_nkh' src='$product_img' alt='Product Image'>
                                                <p class='prdct_prc_nkh'>" . htmlspecialchars($order["item_price"]) . "</p>
                                                <p class='ilan_nkh'>" . htmlspecialchars($order["quantity"]) . "</p>
                                                <p class='ttl_nkh'>" . htmlspecialchars($order["item_price"] * $order["quantity"]) . "</p>
                                            </div>
                                        ";
                                    }
                                }
                            }
                        } else {
                            echo "0 results<br>";
                        }

                        $conn->close();
                    break;
                case 'ibinalik':
                    echo '<div class="column_heading_cont">
                            <div class="column_heading_ibinalik">
                                <p class="ch1_ibnlk">
                                    PRODUKTO
                                </p>
                                <p class="ch2_ibnlk">
                                    PRESYO
                                </p>
                                <p class="ch3_ibnlk">
                                    ILAN
                                </p>
                                <p class="ch4_ibnlk">
                                    TOTAL
                                </p>
                            </div>
                        </div>';
                    foreach ($prdcts as $index => $prdct) {
                        $checkboxId = 'customCheckbox_' . $prdct['id'];  // Unique ID for each product
                        if ($prdct['ibinalik'] == true){
                            echo '<div class="prdct_cont_ibnlk">
                                    <img class="prdct_img_ibnlk" src="'. htmlspecialchars($prdct['src']) .'">
                                    <p class="prdct_name_ibnlk">' . htmlspecialchars($prdct['prdct_nm']) . '</p>
                                    <p class="prdct_prc_ibnlk">' . htmlspecialchars($prdct['prc']) .'</p>
                                    <p class="ilan_ibnlk">'. htmlspecialchars($prdct['id']) .'</p>
                                    <p class="ttl_ibnlk">'. htmlspecialchars($prdct['id'] * $prdct['prc']) .'</p>
                                    </div>';}
                                };
                    break;
                case 'nakuha':
                    echo '<div class="column_heading_cont">
                            <div class="column_heading_nakuha">
                            <p class="ch1_nkh">
                                    PRODUKTO
                                </p>
                                <p class="ch2_nkh">
                                    BILANG
                                </p>
                                <p class="ch3_nkh">
                                PRESYO
                                </p>
                                <p class="ch4_nkh">
                                    TOTAL
                                </p>
                            </div>
                        </div>';
                        $all_delivered = "SELECT
                            o.user_id, o.total_price, o.order_status, o.shipping_address,
                            o.order_date, oi.product_id, oi.quantity, oi.price AS item_price,
                            p.product_img, o.order_id
                            FROM orders o
                            JOIN order_items oi ON o.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id
                            ORDER BY o.order_date DESC";

                        $delivered = $conn->query($all_delivered);

                        if ($delivered === false) {
                            echo "Error: " . $conn->error . "<br>";
                        } else if ($delivered->num_rows > 0) {
                            $orders = $delivered->fetch_all(MYSQLI_ASSOC);
                            // echo "Number of orders fetched: " . count($orders) . "<br>";

                            if (empty($orders)) {
                                echo "<p>No orders.</p>";
                            } else {
                                foreach ($orders as $order) {
                                    
                                    if ($_SESSION["user_id"] == $_SESSION['current_user'] && $order['order_status'] == 'delivered') {
                                        $product_img = !empty($order['product_img']) ? htmlspecialchars($order['product_img']) : 'path/to/default_image.png'; // Default image path
                                        echo "
                                            <div class='prdct_cont'>
                                                <img class='prdct_img_nkh' src='$product_img' alt='Product Image'>
                                                <p class='prdct_prc_nkh'>" . htmlspecialchars($order["item_price"]) . "</p>
                                                <p class='ilan_nkh'>" . htmlspecialchars($order["quantity"]) . "</p>
                                                <p class='ttl_nkh'>" . htmlspecialchars($order["item_price"] * $order["quantity"]) . "</p>
                                            </div>
                                        ";
                                    }
                                }
                            }
                        } else {
                            echo "0 results<br>";
                        }

                        $conn->close();
                    break;
                case 'ikinansela':
                    echo '<div class="column_heading_cont">
                            <div class="column_heading_kansel">
                                <p class="ch1_iknnsl">
                                    PRODUKTO
                                </p>
                                <p class="ch2_iknnsl">
                                    PRESYO
                                </p>
                                <p class="ch3_iknnsl">
                                    ILAN
                                </p>
                                <p class="ch4_iknnsl">
                                    TOTAL
                                </p>
                            </div>
                        </div>';
                    foreach ($prdcts as $index => $prdct) {
                        $checkboxId = 'customCheckbox_' . $prdct['id'];  // Unique ID for each product
                        if ($prdct['ikinansela'] == true){
                            echo '<div class="prdct_cont_iknnsl">
                                    <img class="prdct_img_iknnsl" src="'. htmlspecialchars($prdct['src']) .'">
                                    <p class="prdct_name_iknnsl">' . htmlspecialchars($prdct['prdct_nm']) . '</p>
                                    <p class="prdct_prc_iknnsl">' . htmlspecialchars($prdct['prc']) .'</p>
                                    <p class="ilan_iknnsl">'. htmlspecialchars($prdct['id']) .'</p>
                                    <p class="ttl_iknnsl">'. htmlspecialchars($prdct['id'] * $prdct['prc']) .'</p>
                                    </div>';}
                                };
                    break;
                    break;
                default:
                    echo '<div class="column_heading_cont">
                                <div class="column_heading_babayaran">
                                    <p class="ch1_bbyrn">
                                        PRODUKTO
                                    </p>
                                    <p class="ch2_bbyrn">
                                        PRESYO
                                    </p>
                                    <p class="ch3_bbyrn">
                                        BILANG
                                    </p>
                                </div>
                            </div>';

                            $all_pending = "SELECT * FROM ordered_products";
                            $pending = $conn->query($all_pending);
    
                            if ($pending->num_rows > 0) {
                                while ($row = $pending->fetch_assoc()) {
                                    // echo $row['total_prc'];
                                    if ($row["user_id"] == $_SESSION['current_user'] && $row['status'] == 'pending') {
                                        echo $row["user_id"];
                                        echo $_SESSION['current_user'];
                                        echo "
                                            <div class='prdct_cont'>
                                                <img class='prdct_img_nkh' src=''>
                                                <p class='prdct_name_nkh'>" . htmlspecialchars($row["product_id"]) . "</p>
                                                <p class='ilan_nkh'>" . htmlspecialchars($row["quantity"]) . "</p>
                                                <p class='prdct_prc_nkh'>" . htmlspecialchars($row["total_prc"]) . "</p>
                                                <p class='ttl_nkh'>" . htmlspecialchars($row["total_prc"] * $row["quantity"]) . "</p>
                                                <button class='impormasyon_bttn'>Tanggapin</button>
                                            </div>
                                        ";
                                    }
                                }
                            } else {
                                echo "0 results";
                            }
    
                            // Close the connection here after all queries
                            $conn->close();
                    // foreach ($prdcts as $index => $prdct) {
                    //     $checkboxId = 'customCheckbox_' . $prdct['id'];  // Unique ID for each product
                    //     if ($prdct['in_cart'] == true){
                    //         echo '<div class="prdct_cont">
                    //                 <input type="checkbox" id="' . $checkboxId . '">
                    //                 <label class="cb-label" for="' . $checkboxId . '"></label>
                    //                 <img class="prdct_img" src="'. htmlspecialchars($prdct['src']) .'">
                    //                 <p class="prdct_name">' . htmlspecialchars($prdct['prdct_nm']) . '</p>
                    //                 <p class="prdct_prc">' . htmlspecialchars($prdct['prc']) .'</p>
                    //                 <div class="inp_bttn_cont">
                    //                     <button class="minus">-</button>
                    //                     <input type="text" aria-valuenow="1" value="1" class="inp_val">
                    //                     <button class="plus">+</button>
                    //                 </div>
                    //                 <button class="ikansela_bttn">Ikansela</button>
                    //             </div>';}
                    //             };
                        }
            ?>
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

    <!-- <div class="prdct_cont">
        <input type="checkbox" id="customCheckbox">
        <label id="cb" for="customCheckbox"></label>
        <img class="prdct_img" src="'. htmlspecialchars($prdct['src']) .'">
        <p class="prdct_name">' . htmlspecialchars($prdct['prdct_nm']) . '</p>
        <p class="prdct_prc">php ' . htmlspecialchars($prdct['prc']) .'</p>
        <div class="inp_bttn_cont">
        <button class="minus">
            -
        </button>
        <input type="text" aria-valuenow= 1, value= 1 class="inp_val">
        <button class="plus">
            +
        </button>
        </div>
            <button class="tanggalin_bttn">Ikansela</button>
        </div>
    </div> -->
    
    <script src="../FUNCTIONS/main.js"></script>

</body>
</html>