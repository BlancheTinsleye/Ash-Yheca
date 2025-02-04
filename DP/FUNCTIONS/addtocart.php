<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . '/DP/MAIN/FUNCTIONS/db.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $timestamp = date('Y-m-d H:i:s');


    $stmt = $conn->prepare("SELECT cart_id, quantity FROM shopping_cart WHERE user_id = ? AND product_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($cart_id, $existing_quantity);
    $stmt->fetch();
    $stmt->close();

    if ($cart_id) {
        
        $new_quantity = $existing_quantity + $quantity;
        $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = ?, updated_at = ? WHERE cart_id = ?");
        if (!$stmt) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("isi", $new_quantity, $timestamp, $cart_id);
    } else {
        
        $stmt = $conn->prepare("INSERT INTO shopping_cart (cart_id, user_id, product_id, quantity, created_at, updated_at) VALUES (NULL, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("iiiss", $user_id, $product_id, $quantity, $timestamp, $timestamp);
    }

    if ($stmt->execute()) {
        
        $referer = $_SERVER['HTTP_REFERER'];
        echo "<script type='text/javascript'>
                alert('Product added to cart successfully.');
                window.location.href = '$referer';
              </script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
