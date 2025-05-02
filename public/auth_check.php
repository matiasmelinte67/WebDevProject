<?php
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: register.php");
        exit();
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}