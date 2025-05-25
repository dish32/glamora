<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'glamorasalon_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$service  = $_POST['service'];
$date     = $_POST['date'];
$time     = $_POST['time'];
$discussion = isset($_POST['discussionDate']) ? $_POST['discussionDate'] : null;
$wedding    = isset($_POST['weddingDate']) ? $_POST['weddingDate'] : null;

$sql = "INSERT INTO bookings (name, email, phone, service, discussion_date, wedding_date, date, time)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $name, $email, $phone, $service, $discussion, $wedding, $date, $time);

if ($stmt->execute()) {
    header("Location: booking.php?status=success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
