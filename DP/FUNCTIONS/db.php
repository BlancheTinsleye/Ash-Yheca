<?php
$host = 'localhost';  // Server name
$db = 'disenyo_pilipino'; // Database name
$user = 'root';       // MySQL username
$pass = '';           // MySQL password (empty by default)

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$all_prdcts = "SELECT * FROM products";
$result = $conn->query($all_prdcts);
?>
