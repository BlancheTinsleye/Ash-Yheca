<?php
include($_SERVER['DOCUMENT_ROOT'] . '/DP/MAIN/FUNCTIONS/db.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch user information
$query = "SELECT address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$userResult = $stmt->get_result();
$user = $userResult->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartItems = json_decode($_POST['cartItems'], true);

    if (!$cartItems) {
        echo "No items to process.";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $total_price = array_reduce($cartItems, function($carry, $item) {
        return $carry + $item['price'] * $item['quantity'];
    }, 0);
    $order_status = 'pending'; 
    $shipping_address = $user['address']; 
    $order_date = date('Y-m-d H:i:s');


    $sql = "INSERT INTO orders (user_id, total_price, order_status, shipping_address, order_date) 
    VALUES ('$user_id', '$total_price', '$order_status', '$shipping_address', '$order_date')";

    if (!mysqli_query($conn, $sql)) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }


    $order_id = mysqli_insert_id($conn);


    
    foreach ($cartItems as $item) {
        $cart_id = $item['cart_id'];
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, order_date) 
            VALUES ('$order_id', '$product_id', '$quantity', '$price', '$order_date')";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }

        $deleteSql = "DELETE FROM shopping_cart WHERE cart_id = '$cart_id'";
        if (!mysqli_query($conn, $deleteSql)) {
            echo "Error deleting cart item: " . mysqli_error($conn);
            exit;
        }
    }

echo "Order successfully placed and cart items deleted!";

    
    

    echo "Order successfully placed!";
}
?>

<script>
    function clearLocalStorage() {
        localStorage.clear();
        console.log("Local storage cleared.");
    }

    clearLocalStorage();
</script>
