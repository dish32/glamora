<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect('localhost', 'root', '', 'glamorasalon_db');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $sql = "INSERT INTO feedback (name, email, s_use, rating, f_description) 
            VALUES ('$name', '$email', '$service', '$rating', '$feedback')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>document.addEventListener('DOMContentLoaded', () => { document.getElementById('thankYouModal').style.display = 'flex'; });</script>";
    } else {
        echo "<script>alert('Failed to submit feedback. Please try again.');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Feedback - Glamora Salon</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      background: #fff6ee;
      color: #5c4033;
      overflow-x: hidden;
    }

    h1 {
      text-align: center;
      font-size: 2.5em;
      color: #a0522d;
      margin: 30px 0;
      animation: fadeInDown 1s ease-in-out;
    }

    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
    }

    .card {
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    input, select, textarea {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border: 1px solid #c4a484;
      border-radius: 8px;
      background: #fffaf0;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    .stars {
      display: flex;
      gap: 5px;
      font-size: 24px;
      margin-top: 10px;
    }

    .stars input {
      display: none;
    }

    .stars label {
      cursor: pointer;
      transition: transform 0.2s;
    }

    .stars label:hover,
    .stars label:hover ~ label,
    .stars input:checked ~ label {
      color: gold;
      transform: scale(1.2);
    }

    button {
      background-color: #a0522d;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #8b4513;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
      animation: fadeIn 0.5s ease;
    }

    .modal-content h2 {
      margin-bottom: 10px;
      color: #5c4033;
    }

    .modal-content button {
      margin-top: 20px;
      background-color: #5c4033;
    }

    .image-top {
      width: 100%;
      height: auto;
      border-radius: 15px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>We Value Your Feedback</h1>

    <img src="feedbacks.png" alt="Customer Reviews" class="image-top">

    <div class="card">
      <form method="post" action="">
        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" required>

        <label for="service">Service/Product Used</label>
        <select name="service" required>
          <option value="">-- Select --</option>
          <option value="Salon Service">Salon Service</option>
          <option value="Beauty Product">Beauty Product</option>
        </select>

        <label>Rate Our Service</label>
        <div class="stars">
          <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
          <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
          <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
          <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
          <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
        </div>

        <label for="feedback">Your Feedback</label>
        <textarea name="feedback" rows="5" required></textarea>

        <button type="submit">Submit Feedback</button>
      </form>
    </div>
  </div>

  <div id="thankYouModal" class="modal">
    <div class="modal-content">
      <h2>Thank You!</h2>
      <p>Your feedback has been successfully submitted.</p>
      <button onclick="document.getElementById('thankYouModal').style.display='none'">Close</button>
    </div>
  </div>

</body>
</html>
