<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'glamorasalon_db';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$stock_update_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['new_stock'];

    $update_query = "UPDATE products SET stock = '$new_stock' WHERE p_id = '$product_id'";
    if (mysqli_query($conn, $update_query)) {
        $stock_update_msg = "Stock updated successfully for product ID $product_id.";
    } else {
        $stock_update_msg = "Failed to update stock.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --light-brown: #d9b38c;
            --dark-brown: #5c4033;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background-color: var(--light-brown);
            color: var(--dark-brown);
        }

        nav {
            background-color: var(--dark-brown);
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: var(--white);
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--light-brown);
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: var(--dark-brown);
            animation: fadeIn 1s ease;
        }

        .msg {
            background-color: var(--white);
            color: green;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            margin: 20px auto;
            border-radius: 8px;
            width: 80%;
            animation: fadeIn 1s ease;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: var(--white);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            animation: slideUp 0.8s ease;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: var(--dark-brown);
            color: var(--white);
        }

        .actions button,
        input[type="submit"],
        form button {
            background-color: var(--dark-brown);
            color: var(--white);
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .actions button:hover,
        input[type="submit"]:hover,
        form button:hover {
            background-color: #3e2f24;
        }

        input[type="number"] {
            padding: 4px;
            border: 1px solid var(--dark-brown);
            border-radius: 4px;
            width: 60px;
        }

        img {
            border-radius: 4px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

<nav>
    <a href="#bookings">Bookings</a>
    <a href="#products">Products</a>
    <a href="#payment">Payments</a>
    <a href="#orders">Orders</a>
    <a href="#service">Services</a>
    <a href="#users">Users</a>
    <a href="#feedback">Feedback</a>
</nav>

<?php if (!empty($stock_update_msg)): ?>
    <div class="msg"><?= $stock_update_msg ?></div>
<?php endif; ?>

<!-- Bookings Section -->
<a name="bookings"></a>
<h2>All Bookings</h2>
<?php
$booking_query = "SELECT * FROM bookings ORDER BY id DESC";
$booking_result = mysqli_query($conn, $booking_query);
?>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Service</th>
      <th>Discussion Date</th>
      <th>Wedding Date</th>
      <th> Date</th>
      <th>Time</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($booking_result)): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['service']) ?></td>
      <td><?= $row['discussion_date'] ?: '-' ?></td>
      <td><?= $row['wedding_date'] ?: '-' ?></td>
      <td><?= $row['date'] ?></td>
      <td><?= $row['time'] ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>


<!-- Products Section -->
<a name="products"></a>
<h2>All Products</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM products"); ?>
<table>
    <tr>
        <th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Image</th><th>Actions</th><th>Update Stock</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['p_id'] ?></td>
        <td><?= $row['p_name'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['stock'] ?></td>
        <td><img src="<?= $row['image'] ?>" width="50"></td>
        <td class="actions">
            <a href="items.php?p_id=<?= $row['p_id'] ?>"><button>Edit</button></a>
            <a href="delete_product.php?id=<?= $row['p_id'] ?>" onclick="return confirm('Delete product?')"><button>Delete</button></a>
        </td>
        <td>
            <form method="POST" action="#products">
                <input type="hidden" name="product_id" value="<?= $row['p_id'] ?>">
                <input type="number" name="new_stock" value="<?= $row['stock'] ?>" min="0">
                <button type="submit" name="update_stock">Save</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<!-- Sold Out Products -->
<h2>Sold Out Products</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM products WHERE stock = 0"); ?>
<table>
    <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Image</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['p_id'] ?></td><td><?= $row['p_name'] ?></td><td><?= $row['description'] ?></td>
        <td><?= $row['price'] ?></td><td><img src="<?= $row['image'] ?>" width="50"></td>
    </tr>
    <?php } ?>
</table>

<!-- Orders Section -->
<a name="orders"></a>
<h2>All Orders</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM orders"); ?>
<table>
    <tr><th>Order ID</th><th>Supplier ID</th><th>Date</th><th>Payment Type</th><th>Status</th><th>Actions</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['Order_ID'] ?></td><td><?= $row['Supplier_ID'] ?></td><td><?= $row['Date'] ?></td>
        <td><?= $row['Payment_Type'] ?></td><td><?= $row['Status'] ?></td>
       
    </tr>
    <?php } ?>
</table>

<!-- Services Section -->
<a name="service"></a>
<h2>Services</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM service"); ?>
<table>
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['Service_ID'] ?></td><td><?= $row['Service_Name'] ?></td><td><?= $row['Price'] ?></td>
         <td class="actions">
            <a href="service.php?Service_ID=<?= $row['Service_ID'] ?>"><button>Edit</button></a>
            <a href="delete_service.php?Service_ID=<?= $row['Service_ID'] ?>" onclick="return confirm('Delete service?')"><button>Delete</button></a>
        </td>
        <td>
            <form method="POST" action="#products">
                <input type="hidden" name="Service_ID" value="<?= $row['Service_ID'] ?>">
                <input type="number" name="Price" value="<?= $row['Price'] ?>" min="0">
                <button type="submit" name="update_pricek">Save</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<!-- Users Section -->
<a name="users"></a>
<h2>Users</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM users"); ?>
<table>
    <tr><th>ID</th><th>Username</th><th>Email</th><th>DOB</th><th>Phone</th><th>Role</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td><td><?= $row['username'] ?></td><td><?= $row['email'] ?></td>
        </td><td><?= $row['dob'] ?></td><td><?= $row['phone'] ?></td><td><?= $row['role'] ?></td>
    </tr>
    <?php } ?>
</table>

<!-- Feedback Section -->
<a name="feedback"></a>
<h2>Feedback</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM feedback"); ?>
<table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Service Used</th><th>Description</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['f_id'] ?></td><td><?= $row['name'] ?></td><td><?= $row['email'] ?></td>
        <td><?= $row['s_use'] ?></td><td><?= $row['f_description'] ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
