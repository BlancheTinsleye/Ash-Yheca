<?php

    include '../FUNCTIONS/login_func.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $current_user = null;

    if ($current_user == null) {
        session_destroy();
        header("Location: /DP/landing.php");

    }

?>