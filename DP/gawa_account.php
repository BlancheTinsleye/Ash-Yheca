<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
include '/xampp/htdocs/DP/FUNCTIONS/language.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password

    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    // $birthday = $_POST['birthday'];
    $phone_num = $_POST['phone_number'];
    $address = $_POST['address'];
    $role_id = 1; 


    // Error handling
    

    if (strlen($username) < 7) {
        die("Error: Username must be 8 characters or more.");
    }

    if (strlen($last_name) < 2) {
        die("Error: Last name must be at least 2 letters long.");
    }

    if (strlen($first_name) < 3) {
        die("Error: First name must be at least 3 letters long.");
    }

    if (strlen($email) < 10) {
        die("Error: Invalid email.");
    }

    if (strlen($password) < 8) {
        die("Error: Password must be at least 8 characters long.");
    }

    if (strlen($address) < 10 || strlen($email) > 255) {
        die("Error: Address must be 10 characters or less.");
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        die("Error: Username already taken. Please choose a different username.");
    }

    
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, phone_number, address, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssi", $username, $password, $email, $first_name, $last_name, $phone_num, $address, $role_id);

   
    if ($stmt->execute()) {
        $last_id = $stmt->insert_id; 
        $formatted_id = sprintf("%011d", $last_id);
        echo "New record created successfully. User ID: " . $formatted_id;
    } else {
        echo "Error: " . $stmt->error;
    }

  
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="STYLES/header_login-gawa_style.css">
        <link rel="stylesheet" href="STYLES/gawa_account_style.css">
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
                        <p class="page_name">PAGGAWA NG ACCOUNT</p>
                    </div>
                    <!-- <div class="icons_cont">
                        <a href="login.php"><span class="material-symbols-outlined" id="icon_profile">person</span></a>
                        <a href="likes.php"><span class="material-symbols-outlined" id="icon_heart">favorite</span></a>
                        <a href="bayong.php"><span class="material-symbols-outlined" id="icon_sb">shopping_bag</span></a>
                    </div> -->
                </div>
            </div>
            <div class="canvas">
                <form action="/DP/FUNCTIONS/register.php" method="POST" class="register_cont">
                    <!-- <div class="mid_cont"> -->
                        <div class="just_cont">
                            <p class="tittle"><?php echo $texts['create_account_txt'] ?? 'LANGUAGE'; ?></p>
                        </div>
                        <div class="just_cont">
                            <input type="text" name="username" class="form" placeholder="<?php echo $texts['username'] ?? 'LANGUAGE'; ?>" required>
                            <input type="email" name="email" class="form" placeholder="<?php echo $texts['email'] ?? 'LANGUAGE'; ?>" required>
                        </div>
                        <div class="just_cont">
                            <input type="text" name="first_name" class="form" placeholder="<?php echo $texts['first_name'] ?? 'LANGUAGE'; ?>" required>
                            <input type="text" name="last_name" class="form" placeholder="<?php echo $texts['surname'] ?? 'LANGUAGE'; ?>" required>
                        </div>
                        <div class="just_cont">
                            <input type="text" name="address" class="form" placeholder="<?php echo $texts['address'] ?? 'LANGUAGE'; ?>" required>
                            <input type="text" name="phone_number" class="form" placeholder="<?php echo $texts['number'] ?? 'LANGUAGE'; ?>" required>
                        </div>
                        <div class="just_cont">
                            <input type="password" name="password" class="form" placeholder="<?php echo $texts['password'] ?? 'LANGUAGE'; ?>..." required>
                            <!-- <input  type="password" name="password" class="form" placeholder="<?php echo $texts['check_password'] ?? 'LANGUAGE'; ?>" required> -->
                        </div>
                        <div class="just_cont2">
                            <button type="submit" class="sunod"><?php echo $texts['next_bttn'] ?? 'LANGUAGE'; ?></button>
                        </div>
                    <!-- </div> -->
                </form>
            </div>
        </section>
        
    </body>

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
</html>