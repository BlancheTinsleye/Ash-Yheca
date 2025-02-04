<?php
session_start();
include 'db.php';

$message = null;



    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            background-color: #f6e5c3;
            position: relative;
        }

        .message_cont {
            height: 300px;
            width: 400px;
            background-color: #1a7a69;

            position: absolute;
            top: 50%;
            left: 50%;
            translate: -50% 60%;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .message_cont p, a {
            font-family: 'Courier New';
            font-size: 24px;
            color: #f6e5c3;
            width: 300px;
            
        }

        .message_cont a {
            text-decoration: none;
            background-color: #f6e5c3;
            color: #1a7a69;
            text-align: center;
            margin-top: 20px;

        }

        p {
            color: pink;
        }

    </style>
</head>
<body>

    <?php
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
                die("
                    <div class='message_cont'>
                        <p>Error: Username must be 50 characters or less.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: Username must be 50 characters or less.");
            }
        
            if (strlen($last_name) < 2) {
                die("
                    <div class='message_cont'>
                        <p>Error: Last name must be at least 2 letters long.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: Last name must be at least 2 letters long.");
            }
        
            if (strlen($first_name) < 3) {
                die("
                    <div class='message_cont'>
                        <p>Error: First name must be at least 3 letters long.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: First name must be at least 3 letters long.");
            }
        
            if (strlen($email) < 10) {
                die("
                    <div class='message_cont'>
                        <p>Error: Invalid email.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: Invalid email.");
            }
        
            if (strlen($password) < 8) {
                die("
                    <div class='message_cont'>
                        <p>Error: Password must be at least 8 characters long.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: Password must be at least 8 characters long.");
            }
        
            // if (strlen($address) < 10 || strlen($email) > 255) {
            //     die("Error: Address must be 10 characters or less.");
            // }
        
            // geripineda
        
            // $birthDate = new DateTime($birthday);
            $today = new DateTime();
            // $age = $today->diff($birthDate)->y;
        
            // if ($age < 15) {
            //     die("Error: You must be at least 15 years old.");
            // }
        
            
            if (!preg_match('/^\d{10}$/', $phone_num)) {
                die("
                    <div class='message_cont'>
                        <p>Error: Phone number must be exactly 10 digits.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
            }
        
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        
            if ($count > 0) {
                die("
                    <div class='message_cont'>
                        <p>Error: Username already taken. Please choose a different username.</p>
                        <a href='../gawa_account.php'>go back</a>
                    </div>
                ");
                // die("Error: Username already taken. Please choose a different username.");
            }
        
            
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, first_name, last_name, phone_number, address, role_id) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)");
        
            $stmt->bind_param("sssssssi", $username, $password, $email, $first_name, $last_name, $phone_num, $address, $role_id);
        
           
            if ($stmt->execute()) {
                $last_id = $stmt->insert_id; 
                $formatted_id = sprintf("%011d", $last_id);
                // echo "New record created successfully. User ID: " . $formatted_id;
                echo "
                    <div class='message_cont'>
                        <p>ACCOUNT SUCCESSFULLY CREATED</p>
                        <a href='../login.php.php'>done</a>
                    </div>
                ";
                
                // header("Location: /COMPILED-SEMIFINALS/login.php");
            } else {
                echo "Error: " . $stmt->error;
            }
        
          
            $stmt->close();
        }
    ?>
    
</body>
</html>


<!-- User id must be generated automatically -->

<!-- <form method="post" action="">
    Username: <input type="text" name="username" required>
    Password: <input type="password" name="password" required>
    Email: <input type="text" name="email" required>

    First Name: <input type="text" name="first_name" required>
    Last Name: <input type="text" name="last_name" required>

    Birthday: <input type="date" name="birthday" required>
    phone_number: <input type="text" name="phone_number" required>
    Address: <input type="text" name="address" required>


    <input type="submit" value="Register">
</form> -->

