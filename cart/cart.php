<?php
session_start();

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $delete_id) {
            unset($_SESSION['cart'][$key]);
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
    <h2>Your Cart Items</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table border="1">
            <tr>
                <th>Item Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['price']) ?> LKR</td>
                    <td><a href="cart.php?delete=<?= $item['id'] ?>">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        <a href="checkout.php">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</body>
</html>
