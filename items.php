<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    $item = array(
        'id' => $_POST['item_id'],
        'name' => $_POST['item_name'],
        'price' => $_POST['item_price'],
        'quantity' => $_POST['item_quantity']
    );

    $_SESSION['cart'][] = $item;

    header("Location: card.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GLAMORA SKIN CARE</title>
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
      padding: 15px;
      transition: transform 0.3s ease;
      cursor: pointer;
      overflow: hidden;
      position: relative;
    }
    .item:hover {
      transform: scale(1.05);
    }
    .item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .item-details {
      margin-top: 10px;
      text-align: left;
    }
    .item-name {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }
    .item-description {
      font-size: 14px;
      color: #666;
      margin-top: 5px;
    }
    .item-price {
      font-size: 16px;
      font-weight: bold;
      color: #8B4513;
      margin-top: 8px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #fff;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      width: 90%;
      max-width: 500px;
      position: relative;
      transform: scale(0.7);
      animation: zoomIn 0.3s forwards;
    }

    .modal img {
      width: 100%;
      max-height: 250px;
      object-fit: cover;
      border-radius: 10px;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 28px;
      cursor: pointer;
    }

    .order-btn {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 15px;
    }

    .order-btn:hover {
      background-color: #218838;
    }

    .quantity {
      width: 60px;
      font-size: 16px;
      padding: 5px;
      margin-top: 10px;
    }

    @keyframes zoomIn {
      to {
        transform: scale(1);
      }
    }
  </style>
</head>
<body>

<h2>GLAMORA SKIN CARE</h2>
<div class="container">
  <?php 
    $con = mysqli_connect("localhost", "root", "", "glamorasalon_db");
    $sql = "SELECT * FROM products WHERE stock > 0";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $pid = $row[0];
        $name = $row[1];
        $description = $row[2];
        $price = $row[3];
        $image = $row[4];
        $imageUrl = "uploads/".$image;

        echo "
            <div class='item' onclick=\"openModal('$imageUrl', '$name', '$description', '$price', '$pid')\">
                <img src='$imageUrl' alt='$name'>
                <div class='item-details'>
                    <div class='item-name'>$name</div>
                    <div class='item-description'>$description</div>
                    <div class='item-price'>LKR $price</div>
                </div>
            </div>
        ";
    }

    mysqli_close($con);
  ?>
</div>

<!-- MODAL -->
<div id="itemModal" class="modal" onclick="closeModal(event)">
  <div class="modal-content" onclick="event.stopPropagation();">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImage" src="" alt="Product">
    <h2 id="modalName"></h2>
    <p id="modalDescription"></p>
    <h3 id="modalPrice"></h3>

    <form method="POST" action="#">
      <input type="hidden" name="item_id" id="formItemId">
      <input type="hidden" name="item_name" id="formItemName">
      <input type="hidden" name="item_price" id="formItemPrice">
      <input type="number" name="item_quantity" id="formQuantity" class="quantity" value="1" min="1" />
      <button type="submit" name="add_to_cart" class="order-btn">Add to Cart</button>
    </form>
  </div>
</div>

<script>
  function openModal(imageSrc, name, description, price, id) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalName').innerText = name;
    document.getElementById('modalDescription').innerText = description;
    document.getElementById('modalPrice').innerText = "LKR " + price;

    // Set form values
    document.getElementById('formItemId').value = id;
    document.getElementById('formItemName').value = name;
    document.getElementById('formItemPrice').value = price;
    document.getElementById('formQuantity').value = 1;

    document.getElementById('itemModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('itemModal').style.display = 'none';
  }
</script>

</body>
</html>
