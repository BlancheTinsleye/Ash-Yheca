<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED/FUNCTIONS/db.php');

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
        die("Error: Username must be 50 characters or less.");
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
        die("Error: Address must be 50 characters or less.");
    }

    // geripineda

    // $birthDate = new DateTime($birthday);
    // $today = new DateTime();
    // $age = $today->diff($birthDate)->y;

    // if ($age < 15) {
    //     die("Error: You must be at least 15 years old.");
    // }

    
    // if (!preg_match('/^\d{10}$/', $phone_num)) {
    //     die("Error: Phone number must be exactly 10 digits.");
    // }

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
<!-- User id must be generated automatically -->

<form method="post" action="/DP/FUNCTIONS/register.php">
    Username: <input type="text" name="username" required>
    Password: <input type="password" name="password" required>
    Email: <input type="text" name="email" required>

    First Name: <input type="text" name="first_name" required>
    Last Name: <input type="text" name="last_name" required>

    <!-- Birthday: <input type="date" name="birthday" required> -->
    phone_number: <input type="text" name="phone_number" required>
    Address: <input type="text" name="address" required>


    <input type="submit" value="Register">
</form>
