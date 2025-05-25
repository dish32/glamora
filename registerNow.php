<?php
// Step 1: Connect to MySQL
$host = "localhost";
$user = "root"; // default for WAMP
$password = "";
$db = "glamorasalon_db"; // your correct database name

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Get form data safely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $role = $_POST['role'] ?? '';

    // ✅ Add this debug line to log the data
    file_put_contents("debug_log.txt", "Username: $username, Email: $email, Role: $role\n", FILE_APPEND);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, PASSWORD, dob, phone, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $username, $email, $hashed_password, $dob, $phone, $role);
        if ($stmt->execute()) {
            echo "✅ Registration successful!";
        } else {
            echo "❌ Error while inserting: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "❌ Prepare failed: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Styling remains unchanged (from your original) */
        body {
            font-family: Arial, sans-serif;
            background: url('register.png') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            flex-direction: column;
        }
        .form-container {
            background: rgba(210, 180, 140, 0.9);
            padding: 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #8B4513;
            margin-bottom: 5px;
        }
        h1 {
            font-family: 'Great Vibes', cursive;
            font-size: 28px;
            color: #5C4033;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #5C4033;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="date"], select {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #8B4513;
            background-color: #F5F5DC;
            color: #5C4033;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #8B4513;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #A0522D;
        }
        .notification {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #008000;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .notification.error {
            background: #FF0000;
        }
        .cookie-popup {
            display: none;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #5C4033;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .cookie-popup button {
            background: #8B4513;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('notification').innerText = '✅ Form submitted';
            document.getElementById('notification').style.display = 'block';
        });
    </script>";
}
?>

<div id="cookiePopup" class="cookie-popup">
    This website uses cookies to improve your experience. 
    <button onclick="acceptCookies()">Accept</button>
</div>

<div class="form-container">
    <h2>REGISTER NOW</h2>
    <h1>Then Enhance Your Beauty</h1>   

    <form method="post" name="registernow" action="#">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <!-- ✅ Role Dropdown -->
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <input type="submit" value="Register">
    </form>
</div>

<div id="notification" class="notification"></div>

<script>
    window.onload = function() {
        if (!localStorage.getItem("cookiesAccepted")) {
            document.getElementById("cookiePopup").style.display = "block";
        }
    };
    function acceptCookies() {
        localStorage.setItem("cookiesAccepted", "true");
        document.getElementById("cookiePopup").style.display = "none";
    }
</script>

</body>
</html>
