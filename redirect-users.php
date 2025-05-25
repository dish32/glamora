<?php
session_start();

if (!isset($_SESSION['role'])) {
    // Not logged in
    header("Location: customer-login.php");
    exit;
}

if ($_SESSION['role'] === 'admin') {
    header("Location: admin.php");
} else if ($_SESSION['role'] === 'customer') {
    header("Location: home.php");
} else {
    echo "Unknown role!";
}
exit;
