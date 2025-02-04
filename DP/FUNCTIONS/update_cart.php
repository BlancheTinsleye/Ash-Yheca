<?php
session_start();
// include($_SERVER['DOCUMENT_ROOT'] . '/DP/MAIN/FUNCTIONS/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    $updated_at = date('Y-m-d H:i:s'); 

    $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = ?, updated_at = ? WHERE cart_id = ?");
    $stmt->bind_param("isi", $quantity, $updated_at, $cart_id);

    if ($stmt->execute()) {
        header("Location: ../MAIN/bayong.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
