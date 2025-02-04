<?php
session_start(); // Start a session
include($_SERVER['DOCUMENT_ROOT'] . '/DP/FUNCTIONS/db.php');
// include($_SERVER['DOCUMENT_ROOT'] . '/SOFENG_PHP/COMPILED-SEMIFINALS/FUNCTIONS/db.php');


// Capture the form data
if (!isset($_POST['product_id'], $_POST['user_id'], $_POST['crrnt_page'])) {
    die("Required fields are missing.");
}

$product_id = $_POST['product_id'];
$user_id = $_POST['user_id'];
$crrnt_page = $_POST['crrnt_page'];

// Check if the same product_id and user_id already exist in the 'likes' table
$check_query = $conn->prepare("SELECT * FROM likes WHERE product_id = ? AND user_id = ?");
$check_query->bind_param("ii", $product_id, $user_id);
$check_query->execute();
$result = $check_query->get_result();

if ($result->num_rows > 0) {
    // If the record exists, delete it
    $delete_query = $conn->prepare("DELETE FROM likes WHERE product_id = ? AND user_id = ?");
    $delete_query->bind_param("ii", $product_id, $user_id);

    if ($delete_query->execute()) {
        // Set a session message for record removal
        $_SESSION['notification'] = "You have removed your like for this product.";
        header("Location: $crrnt_page");
        exit;
    } else {
        echo "Error deleting record: " . $delete_query->error;
        exit;
    }
}

// Insert data into the 'likes' table (exclude like_id)
$sql = $conn->prepare("INSERT INTO likes (product_id, user_id) VALUES (?, ?)");
$sql->bind_param("ii", $product_id, $user_id);

if ($sql->execute()) {
    // Set a session message for record addition
    $_SESSION['notification'] = "You have liked this product.";
    header("Location: $crrnt_page");
    exit;
} else {
    echo "Error: " . $sql->error;
}

$conn->close();
?>
