<?php
// insert_order.php
require 'db_connection.php'; // your database connection

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['user_id'], $data['total_amount'], $data['order_date'])) {
    $userId = $data['user_id'];
    $totalAmount = $data['total_amount'];
    $orderDate = $data['order_date'];

    $stmt = $conn->prepare("INSERT INTO order_details(user_id, total_amount, order_date) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $userId, $totalAmount, $orderDate);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid input.";
}
?>