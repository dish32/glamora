<?php
// booking.php - top section: handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $service = $_POST["service"];

    // DB Connection
    $conn = new mysqli("localhost", "root", "", "glamora_db"); // update with your DB details

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO bookings (name, email, service) VALUES ('$name', '$email', '$service')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking successful!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glamora - Elevate Your Charming Look</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Top Bar */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: black;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Hero Content */
        .hero-content {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }

        .book-btn {
            background-color: white;
            color: black;
            padding: 15px 30px;
            border: 2px solid black;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .book-btn:hover {
            background-color: black;
            color: white;
        }

        /* Features Section */
        .features {
            display: flex;
            justify-content: space-around;
            padding: 30px;
            background-color: #fff;
        }

        .feature {
            text-align: center;
            font-weight: bold;
        }

        /* Footer */
        .footer-bar {
            background-color: black;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <header>
        <h1 class="logo">Glamora</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="service.php">Services</a></li>
                <li><a href="items.php">Products</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="card.php">Cart</a></li>
                <li><a href="feedbacks.php">Feedback</a></li>
            </ul>
        </nav>
    </header>

    <!-- Background Video -->
    <div class="video-background">
        <video autoplay muted loop>
            <source src="home2.mp4" type="video/mp4">
            
        </video>
    </div>

    <div class="hero-content">
        <h1></h1>
        
    </div>

    <!-- Features Section -->
    <section class="features">
        <div class="feature">
            <p>My 100% Trusted Preferred Hair Salon</p>
        </div>
        <div class="feature">
            <p>1.4K+ Regular Clients</p>
        </div>
        <div class="feature">
            <p>True Passion For Barbering</p>
        </div>
    </section>

    <!-- Footer -->
    <div class="footer-bar">
        <p>&copy; 2025 Glamora Salon | All Rights Reserved</p>
    </div>
  <script>
    function goToBooking() {
        const userConfirmation = confirm("Are you sure you want to register?");
        if (userConfirmation) {
            window.location.href = "booking.php"; // ← Redirects to booking.php
        } else {
            alert("Booking cancelled.");
        }
    }
</script>

  
</body>
</html>

