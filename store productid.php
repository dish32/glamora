<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pid'])) {
    $_SESSION['pid'] = $_POST['pid']; // Store admin ID in session

    // Redirect to the admin registration page
    header("Location: card.php");
    exit();
} else {
    // Redirect back if accessed incorrectly
    header("Location: items.php"); // Change this to your actual dashboard file
    exit();
}
?>