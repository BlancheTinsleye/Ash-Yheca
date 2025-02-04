<?php
    // PAKI AYOS NA LANG PI ANG PATH    
    // include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/UserSide/FUNCTIONS/db.php');


    $activeCategory = isset($_GET['category']) ? $_GET['category'] : 1;
    $prdcts = null
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DISENYO PILIPINO</title>

        <link rel="stylesheet" href="STYLES/search_style.css">
        <link rel="stylesheet" href="STYLES/header_one_style.css">

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
            <form class="search_bar" method="GET" action="">
                <input class="srch_bx" type="text" name="search" placeholder="Ilagay ang pangalan ng produkto" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button class="search_icon" type="submit"><span class="material-symbols-outlined" id="search_icon">search</span></button>
            </form>
            
            <div class="nav_cnt">
                <a href="profile.php"><span class="material-symbols-outlined" id="icon_profile">person</span></a>
                <a href="likes.php"><span class="material-symbols-outlined" id="icon_heart">favorite</span></a>
                <a href="bayong.php"><span class="material-symbols-outlined" id="icon_sb">shopping_bag</span></a>
                
                <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
            </div>
        </div>
    </header>

    <main>
    <div class="sort_cont">
                <p class="sort_txt">I-sort:</p>
                <div class="categories_cont">
                    <label class="mga_ktgry" for="categories">MGA KATEGORYA:</label>
                        <select class="ctgry_slct" name="categories" id="categories">
                            <option value="damit">Damit</option>
                            <option value="gamit">Gamit</option>
                            <option value="pagkain">Pakain</option>
                        </select>
                </div>
                <div class="prices_cont">
                    <label class="presyo" for="prices">Presyo</label>
                        <select class="prc_slct" name="price" id="price">
                            <option value="100">< 100</option>
                            <option value="200">< 200</option>
                            <option value="300">< 300</option>
                        </select>
                    <label class="types" for="prices">Mga Uri</label>
                        <select class="uri_slct" name="type" id="type">
                            <option value="100">< 100</option>
                            <option value="200">< 200</option>
                            <option value="300">< 300</option>
                        </select>
                </div>
                    
                <div class="prices_cont">
                    <label class="grado" for="ratings">Presyo</label>
                        <select class="rating_slct" name="rating" id="rating">
                            <option value="1">< 1</option>
                            <option value="2">< 2</option>
                            <option value="3">< 3</option>
                            <option value="4">< 4</option>
                            <option value="5"> 5</option>
                        </select>
                </div>
            </div>

            <div class="sorted_prdcts_cont">
                <?php
                    if ($prdcts) {
                        foreach ($prdcts as $prdct) {
                            echo '<div class="prdct_cont">
                                    <img class="prdct_img" src="'. htmlspecialchars($prdct['src']) .'">
                                    <p class="prdct_name">' . htmlspecialchars($prdct['prdct_nm']) . '</p>
                                    <p class="prdct_prc">presyo: php ' . htmlspecialchars($prdct['prc']) .'</p>
                                    <p class="prdct_rate">grado: '. htmlspecialchars($prdct['rate']) .'</p>
                                </div>';
                        }
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
            <div class="log_out_bttn_cont" >
                <form action="../FUNCTIONS/logout.php"><button class="yes_bttn" >yes</button></form>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>

        <script src="../FUNCTIONS/main.js"></script>
    </body>
</html>