<?php
include 'FUNCTIONS/language.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DISENYO PILIPINO</title>

    <link rel="stylesheet" href="STYLES/landing_page_style.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <section>
        <div class="top_cont">
            <div class="language_cont">
                <label for="languages"><?php echo $texts['language'] ?? 'LANGUAGE'; ?>:</label>
                <!-- Separate form only for language selection -->
                <form id="languageForm">
                    <select class="lang_dd" name="language" id="languages" onchange="changeLanguage(this.value)">
                        <option value="tl" <?php echo ($selected_language === 'tl') ? 'selected' : ''; ?>>TAGALOG</option>
                        <option value="en" <?php echo ($selected_language === 'en') ? 'selected' : ''; ?>>ENGLISH</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="landing_page_main">
            <div class="page_1">
                <div class="bg_lp">
                </div>
                <div class="logo_cont">
                    <p class="logo_txt"><span class="disenyo_txt">DISENYO</span> <span class="pilipino_txt">PILIPINO</span></p>
                </div>
                <div class="bttns_store_cont">
                    <div class="login_create_bttns_cont">
                        <form action="login.php" method="post" class="login_cont">
                            <p class="login_txt"><?php echo $texts['login_txt'] ?? 'LANGUAGE'; ?></p>
                            <button type="submit" class="login_page_bttn"><?php echo $texts['to_login_page_bttn'] ?? 'LANGUAGE'; ?></button>
                        </form>
                        <div class="divider"></div>
                        <div class="create_acc_cont">
                            <p class="gawa_txt"><?php echo $texts['create_account_txt'] ?? 'LANGUAGE'; ?></p>
                            <a href="gawa_account.php" class="gawa_acc_page_bttn"><?php echo $texts['to_create_account_bttn'] ?? 'LANGUAGE'; ?></a href="gawa_account.php">
                        </div>
                    </div>

                    <div class="store_cont">
                        <img src="https://res.cloudinary.com/damtc4g0q/image/upload/v1726725027/sarisaristore_dmkxzs.png" alt="" class="store_img">
                    </div>
                </div>
            </div>
        </div>

        <div class="page_2"></div>

    </section>

    <script>
        function changeLanguage(language) {
            fetch('FUNCTIONS/language.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `language=${language}`
            })
            .then(() => {
                window.location.href = window.location.href; // Forces a page reload without form resubmission
            });
        }
    </script>

</body>
</html>