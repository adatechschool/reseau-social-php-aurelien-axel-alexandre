<?php
session_start();

if (isset($_SESSION['connected_id'])) {
    $userId = $_SESSION['connected_id'];
    //echo "<pre>" . print_r($userId, 1) . "</pre>";
} else {
    header('Location: login.php');
    exit();
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    logout();
}
?>