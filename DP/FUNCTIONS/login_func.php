<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';



$current_user = null;
// echo $current_user;
$sample = 'Hi';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetching user_id along with password and role_id
    $stmt = $conn->prepare("SELECT user_id, password, role_id FROM users WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role_id);
    $stmt->fetch();
    $stmt->close();

    // Verifying the password
    if ($hashed_password !== null && password_verify($password, $hashed_password)) {
        // Successful login
        $_SESSION['username'] = $username;
        $_SESSION['role_id'] = $role_id;
        $_SESSION['user_id'] = $user_id;

        // Fetch the role name
        $role_stmt = $conn->prepare("SELECT role_name FROM roles WHERE role_id = ?");
        if (!$role_stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $role_stmt->bind_param("i", $role_id);
        $role_stmt->execute();
        $role_stmt->bind_result($role_name);
        $role_stmt->fetch();
        $role_stmt->close();

        // Redirect based on role
        if ($role_name === 'Admin') {
            $_SESSION['role_name'] = $role_name;
            $_SESSION['current_user'] = $_SESSION['user_id'];
            header("Location: ../MAIN/admin_side.php");
        } else {
            // $current_user = $_SESSION['user_id'];
            $_SESSION['current_user'] = $_SESSION['user_id'];

            // echo $current_user;
            header("Location: ../MAIN/index.php");
        }
    } else {
        // Failed login - Redirect with error
        header("Location: ../login.php?error=invalid");
    }
}

?>
