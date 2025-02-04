<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /DP/landing.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
include '../FUNCTIONS/language.php';
include '../FUNCTIONS/login_func.php';


$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>
    <link rel="stylesheet" href="STYLES/faqs_style.css">
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
                <p><span class="D">DISENYO</span><span class="P">PILIPINO</span><span class="page_name">FAQs</span></p>
            </a>
        </div>
        
        <div class="nav_cnt">
            <!-- <a href="profile.php"><span class="material-symbols-outlined" id="icon_profile">person</span></a>
            <a href="likes.php"><span class="material-symbols-outlined" id="icon_heart">favorite</span></a>
            <a href="bayong.php"><span class="material-symbols-outlined" id="icon_sb">shopping_bag</span></a> -->
            <a class="material-symbols-outlined" id="menu_icon" onclick="close_menu()">menu</a> 
        </div>
    </div>

</header>

<main>
    <img class="faqs_img" src="https://res.cloudinary.com/damtc4g0q/image/upload/v1732061738/23_oyvhen.jpg" alt="faqs">
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
        <button class="yes_bttn" onclick="window.location.href='/DP/FUNCTIONS/logout.php'">yes</button>
        <button class="no_bttn" id="no_bttn" onclick="close_question()">no</button>
    </div>
</div>

<script src="../FUNCTIONS/main.js"></script>
</body>
</html>
