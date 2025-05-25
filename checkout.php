<?php
session_start();

// Example: Clear the cart after checkout
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

echo "<script>alert('Thank you for your purchase!'); window.location.href='cart.php';</script>";
?>
