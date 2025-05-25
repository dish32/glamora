<?php
session_start();
$conn = new mysqli("localhost", "root", "", "glamorasalon_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    $sql = "SELECT * FROM users WHERE email=? AND role=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $email, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();


            if (password_verify($password, $user['PASSWORD'])) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['islogin'] = true;

                header("Location: redirect-users.php") ;
                

                exit;
            } else {
                echo "fail_password";
            }
        } else {
            echo "fail_user";
        }

        $stmt->close();
    } else {
        echo "query_error";
    }

    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Salon Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      overflow: hidden;
      position: relative;
    }

    .video-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .video-background video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      width: 320px;
      text-align: center;
      backdrop-filter: blur(10px);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      color: #fff;
      font-size: 24px;
    }

    select, input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.8);
      color: #333;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #c4a484;
      border: none;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: 0.3s;
    }

    button:hover {
      background-color: #a37f53;
    }

    .register-link {
      margin-top: 10px;
      color: #fff;
      font-size: 14px;
    }

    .register-link a {
      color: #5c4033;
      text-decoration: none;
      font-weight: bold;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .cookie-banner {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      width: 300px;
      display: none;
      justify-content: space-between;
      align-items: center;
    }

    .cookie-banner button {
      background: #ff5e78;
      border: none;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="video-background">
    <video autoplay muted loop>
      <source src="salon-bg.mp4" type="video/mp4">
    </video>
  </div>

  <div class="login-container">
    <h2>Welcome Back!</h2>
    <form id="loginForm" method="post" action="#">
      <select name="role" id="role" required>
        <option value="" disabled selected>Select Role: Admin or Customer</option>
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
      </select>
      <input type="email" name="email" id="email" placeholder="Email" required>
      <input type="password" name="password" id="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <div style="margin-top: 20px;"> 
        <button type="button" onclick="window.location.href='index.html'" style="padding: 10px 20px; background-color: transparent; color: white; border: 2px solid white; border-radius: 8px; cursor: pointer;">
          ← Back
        </button>
      </div>
    </form>
    <p class="register-link">You haven't an account? <a href="registerNow.php">Register</a></p>
  </div>

  <div class="cookie-banner" id="cookie-banner">
    <p>We use cookies to improve your experience.</p>
    <button onclick="acceptCookies()">Accept</button>
  </div>

  
</body>
</html>
