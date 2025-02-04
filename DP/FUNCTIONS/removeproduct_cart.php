<?php
session_start();
// include($_SERVER['DOCUMENT_ROOT'] . '/COMPILED-SEMIFINALS/MAIN/FUNCTIONS/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $cart_id = $_POST['cart_id'];

    $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE cart_id = ?");
    $stmt->bind_param("i", $cart_id);

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
