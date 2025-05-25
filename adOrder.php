<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'glamorasalon_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Order_ID      = $_POST['Order_ID'];
$id    = $_POST['id'];
$Date    = $_POST['Date'];
$Payment_Type  = $_POST['Payment_Type'];
$Status     = $_POST['Status'];


$sql = "INSERT INTO orders (Order_ID, id, Date, Payment_Type, Status)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $Order_ID, $id, $Date, $Payment_Type, $Status);

if ($stmt->execute()) {
    header("Location: cart.php?status=success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
