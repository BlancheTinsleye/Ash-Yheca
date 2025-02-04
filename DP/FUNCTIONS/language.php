<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection (update credentials)
$host = 'localhost';
$dbname = 'disenyo_pilipino';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Set language in session or default to Tagalpg
if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];
}
$selected_language = $_SESSION['language'] ?? 'tl';

// Fetch translations for selected language
function getTranslations($pdo, $language_code) {
    $stmt = $pdo->prepare("SELECT key_name, translation_text FROM language_translations WHERE language_code = :language_code");
    $stmt->execute(['language_code' => $language_code]);
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

// Fetch translations and set defaults if not in database
$texts = getTranslations($pdo, $selected_language);
// $texts = array_merge([
//     'language' => 'LANGUAGE', // Default values
//     'login' => 'MAG LOG-IN',
//     'create_account' => 'GUMAWA NG ACCOUNT',
// ], $texts);


?>
