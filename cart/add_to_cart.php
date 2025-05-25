<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = [
        $id = $_POST['id'],
        $name = $_POST['name'],
        $price = floatval($_POST['price']);
        $image = $_POST['image'];
       $quantity = intval($_POST['quantity']);
  

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update quantity if item already exists
    $found = false;
    foreach ($_SESSION['cart'] as &$product) {
        if ($product['id'] === $item['id']) {
            $product['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }

   if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => $quantity
        ];

    header("Location: cart.php");
    exit();
}
?>
