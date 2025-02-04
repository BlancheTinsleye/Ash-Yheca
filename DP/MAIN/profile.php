<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    
    include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    // include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
    include '../FUNCTIONS/language.php';
    include '../FUNCTIONS/login_func.php';
    
    echo isset($_SESSION['current_user']) ? '' : header("Location: /DP/landing.php");
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="STYLES/profile_style.css">
        <link rel="stylesheet" href="STYLES/settings_icon_style.css ">
        <link rel="stylesheet" href="STYLES/main_header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=settings" />
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
        <div class="welcome-section">
            <div class="mabuhay-text">
                <svg viewBox="40 0 450 250">
                    <path id="curve" fill="transparent" d="M 50 150 Q 250 -10 450 150" />
                    <text fill="#FDD943" font-size="100" font-weight="bold">
                        <textPath href="#curve" startOffset="10%">
                            Mabuhay!
                        </textPath>
                    </text>
                </svg>
            </div>
            <div class="welcome-text">
                <div class="mensahe">
                    <p>Kamusta ka?</p>
                    <p>nawa'y masaya ka</p>
                </div>
            </div>
        </div>
        <form class="info_cnt">
            <div class="profile">
                <img src="#" alt="profile">
            </div>
            <div class="info">
                <div class="f">
                    <p>Pangalan...</p>
                    <p>Email</p>
                </div>
                <div class="f">
                    <p>User Id</p>
                    <p>Address</p>
                </div>
                <div class="f">
                    <p>Numero</p>
                </div>
                <div class="bttns_cont">
                    <a href="mga_pinamili.php" class="view_pinamili">history</a>
                    <!-- <form href="mga_pinamili.php" class="view_mga_pinamili">
                    </form> -->
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
                <!-- <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>     -->
                <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
                <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
            </div>
        </div>

    </body>

    <script src="../FUNCTIONS/main.js"></script>
</html>