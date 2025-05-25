<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>IEAMS Price List</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body {
      background: #fdf7f0;
      margin: 0;
      padding: 30px;
    }
    h2 {
      text-align: center;
      color: #4a2c1e;
      margin-bottom: 40px;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
    }
    .item {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
      cursor: pointer;
      padding: 15px;
      text-align: center;
    }
    .item:hover {
      transform: scale(1.03);
    }
    .item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .item-name {
      font-size: 18px;
      font-weight: bold;
      margin: 10px 0 5px;
      color: #5c4033;
    }
    .item-description {
      font-size: 14px;
      color: #555;
    }
    .item-price {
      margin-top: 8px;
      font-size: 16px;
      font-weight: bold;
      color: #b3561a;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      width: 90%;
      max-width: 500px;
      margin: 10% auto;
      border-radius: 10px;
      text-align: center;
      position: relative;
    }
    .close {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 25px;
      cursor: pointer;
    }
    .modal img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    input[type="datetime-local"] {
      padding: 10px;
      font-size: 16px;
      margin: 10px 0;
      width: 100%;
      max-width: 250px;
    }
    .order-btn {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      margin-top: 10px;
    }
    .order-btn:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

<h2>GLAMORA SALON SERVICES</h2>
<div class="container">

<?php
$con = mysqli_connect("localhost", "root", "", "glamorasalon_db");

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM service";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $Service_ID = $row['Service_ID'];
    $Service_Name = $row['Service_Name'];
    $description = $row['description'];
    $Price = $row['Price'];
    $image = $row['image'];
    $imageUrl = "service/" . $image;

echo "
  <div class='item' onclick=\"openModal('$imageUrl', '$Service_Name', '$description', 'LKR $Price')\">
    <img src='$imageUrl' alt='$Service_Name'>
    <div class='item-name'>$Service_Name</div>
    <div class='item-description'>$description</div>
    <div class='item-price'>LKR $Price</div>
  </div>
";

} 
}else {
  echo "<p style='text-align:center;'>No services available.</p>";
}

mysqli_close($con);
?>

</div>

<!-- Modal Section -->
<div id="itemModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="" alt="">
    <h2 id="modalName"></h2>
    <p id="modalDescription"></p>
    <h3 id="modalPrice"></h3>

    <!-- Booking Form -->
    <form action="booking.php" method="POST">
      <input type="hidden" name="service_name" id="serviceInput">
      <button type="submit" class="order-btn">Book Now</button>
    </form>
  </div>
</div>

<script>
  let appointments = JSON.parse(localStorage.getItem('appointments')) || [];

  function openModal(imageSrc, name, description, price) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalName').innerText = name;
    document.getElementById('modalDescription').innerText = description;
    document.getElementById('modalPrice').innerText = price;
    document.getElementById('serviceInput').value = name;
    document.getElementById('itemModal').style.display = 'block';
  }

  function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
  }
</script>

</body>
</html>
