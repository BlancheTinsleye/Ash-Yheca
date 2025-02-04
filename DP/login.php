<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');

include 'FUNCTIONS/language.php';

$error = isset($_GET['error']) && $_GET['error'] === 'invalid';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="STYLES/header_login-gawa_style.css">
        <link rel="stylesheet" href="STYLES/login_style.css">
        <link rel="stylesheet" href="STYLES/invalid_notif_style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>DISENYO PILIPINO</title>

        
    </head>
    <body>
        <section class="section_cont">
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
            <div class="header_cont">
                <div class="logo-page_name-icons">
                    <div class="logo_cont">
                        <a class="logo" href="index.php">
                            <!-- <img class="img" src="DATABASE/IMG/sarisaristore.png" alt="LOGO"> -->
                            <p class="D">DISENYO</p>
                            <p class="P">PILIPINO</p>
                        </a>
                        <p class="page_name"><?php echo $texts['login_txt'] ?? 'LANGUAGE'; ?></p>
                    </div>
                    <!-- <div class="icons_cont">
                        <a href="login.php"><span class="material-symbols-outlined" id="icon_profile">person</span></a>
                        <a href="likes.php"><span class="material-symbols-outlined" id="icon_heart">favorite</span></a>
                        <a href="bayong.php"><span class="material-symbols-outlined" id="icon_sb">shopping_bag</span></a>
                    </div> -->
                </div>
            </div>
            <div class="img-logo_form_cont">
                <div class="img-logo_cont">
                    <img class="img-logo" src="https://res.cloudinary.com/damtc4g0q/image/upload/v1726725027/sarisaristore_dmkxzs.png" alt="LOGO">
                </div>
                <div class="form_cont">
                    <div class="mid_cont">
                        <div class="log">
                            <label for="mid_cont" class="login-label"><?php echo $texts['pn_login'] ?? 'LANGUAGE'; ?></label>
                        </div>

                        <?php if ($error): ?>
                            <div id="errorModal" class="modal">
                                <div class="modal-content">
                                    <span class="close-btn" onclick="closeModal()">&times;</span>
                                    <p><?php echo $texts['notif_inv_login'] ?? 'LANGUAGE'; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <form action="FUNCTIONS/login_func.php" method ="post"  class="input">
                            <input name="username" class="username" placeholder="Numero / Email / Username" required>
                            <input type="password" name="password" class="password" placeholder="password" required>
                            <input type="submit" class="login" value="<?php echo $texts['login_bttn'] ?? 'LANGUAGE'; ?>"></input>
                        </form>
                         
                        <nav class="gawa">
                            <label for="gawa-nav" class="la"><?php echo $texts['ask_no_account'] ?? 'LANGUAGE'; ?>? </label>
                            <a href="gawa_account.php" id="gawa-nav" class="gawa-nav"><p><?php echo $texts['to_create_account_bttn'] ?? 'LANGUAGE'; ?></p></a>
                        </nav>
                    </div>
                </div>    
            </div>
        </section>
        <?php
            // session_start();
            // $servername = "localhost"; 
            // $username = "your_username"; 
            // $password = "your_password"; 
            // $dbname = "disenyo_pilipino";

            // $conn = new mysqli($servername, $username, $password, $dbname);

            // if ($conn->connect_error) {
            //     die("Connection failed: " . $conn->connect_error);
            // }

            // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //     $email = $_POST['email'];
            //     $password = $_POST['password'];

            //     $sql = "SELECT * FROM users WHERE email='$email'";
            //     $result = $conn->query($sql);

            //     if ($result->num_rows > 0) {
            //         $row = $result->fetch_assoc();
            //         if (password_verify($password, $row['password'])) {
            //             $_SESSION['user_id'] = $row['id'];
            //             header("Location: index.php");
            //             exit;
            //         } else {
            //             echo "<script>alert('Invalid password.');</script>";
            //         }
            //     } else {
            //         echo "<script>alert('No user found with that email.');</script>";
            //     }
            // }

            // $conn->close();
        ?>

    <div class="invld_notif">


    </div>

    </body>

    <script>
        // JavaScript to control the popup modal
        function closeModal() {
            document.getElementById('errorModal').style.display = 'none';
        }

        // Show the modal if there's an error
        window.onload = function() {
            <?php if ($error): ?>
                document.getElementById('errorModal').style.display = 'block';
            <?php endif; ?>
        };

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
</html>