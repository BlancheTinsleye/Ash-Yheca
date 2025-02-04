<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /DP/landing.php");
    exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/DP/MAIN/FUNCTIONS/db.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    
    if ($conn->connect_error) {
        die('Connection Error: ' . $conn->connect_error);
    }

    
    $conn->begin_transaction();

    try {
        
        $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param('si', $order_status, $order_id);

        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();

        if ($order_status === 'shipped') {
            
            $stmt = $conn->prepare("SELECT product_id, quantity FROM order_items WHERE order_id = ?");
            if ($stmt === false) {
                throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
            }
            $stmt->bind_param('i', $order_id);
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
            }
            $result = $stmt->get_result();
            $order_items = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            // stock in products
            foreach ($order_items as $item) {
                $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
                if ($stmt === false) {
                    throw new Exception('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt->bind_param('ii', $item['quantity'], $item['product_id']);
                if (!$stmt->execute()) {
                    throw new Exception('Execute failed: ' . htmlspecialchars($stmt->error));
                }
                $stmt->close();
            }
        }

        $conn->commit();

        if ($order_status === 'shipped') {
            echo "<script>
                alert('Order status updated to shipped successfully.');
                window.location.href = '/COMPILED-SEMIFINALS/MAIN/shipped.php';
            </script>";
        } elseif ($order_status === 'delivered') {
            echo "<script>
                alert('Order status updated to delivered successfully.');
                window.location.href = '/COMPILED-SEMIFINALS/MAIN/delivered.php';
            </script>";
        } else {
            echo "<script>
                alert('Order status updated successfully.');
                window.location.href = '/COMPILED-SEMIFINALS/MAIN/orders.php';
            </script>";
        }
    } catch (Exception $e) {

        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
