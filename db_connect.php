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

// Handle stock update form submission
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #555;
            color: white;
        }
        .actions button {
            margin: 0 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .msg {
            text-align: center;
            padding: 10px;
            color: green;
            font-weight: bold;
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
<?php $result = mysqli_query($conn, "SELECT * FROM bookings"); ?>
<table>
    <tr>
        <th>ID</th><th>Full Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Date</th><th>Time</th><th>Message</th><th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['b_id'] ?></td><td><?= $row['full_name'] ?></td><td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td><td><?= $row['service'] ?></td><td><?= $row['preferred_date'] ?></td>
        <td><?= $row['time'] ?></td><td><?= $row['message'] ?></td>
        <td class="actions">
            <a href="edit_booking.php?id=<?= $row['b_id'] ?>"><button>Edit</button></a>
            <a href="delete_booking.php?id=<?= $row['b_id'] ?>" onclick="return confirm('Are you sure?')"><button>Delete</button></a>
        </td>
    </tr>
    <?php } ?>
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
        <td><?= $row['name'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['stock'] ?></td>
        <td><img src="<?= $row['image'] ?>" width="50"></td>
        <td class="actions">
            <a href="items.html?p_id=<?= $row['p_id'] ?>"><button>Edit</button></a>
            <a href="delete_product.php?id=<?= $row['p_id'] ?>" onclick="return confirm('Delete product?')"><button>Delete</button></a>
        </td>
        <td>
            <form method="POST" action="#products">
                <input type="hidden" name="product_id" value="<?= $row['p_id'] ?>">
                <input type="number" name="new_stock" value="<?= $row['stock'] ?>" min="0" style="width: 60px;">
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
        <td><?= $row['p_id'] ?></td><td><?= $row['name'] ?></td><td><?= $row['description'] ?></td>
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
        <td><?= $row['Payement_Type'] ?></td><td><?= $row['Status'] ?></td>
        <td class="actions">
            <a href="edit_order.php?id=<?= $row['Order_ID'] ?>"><button>Edit</button></a>
            <a href="delete_order.php?id=<?= $row['Order_ID'] ?>" onclick="return confirm('Delete order?')"><button>Delete</button></a>
        </td>
    </tr>
    <?php } ?>
</table>

<!-- Services Section -->
<a name="service"></a>
<h2>Services</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM service"); ?>
<table>
    <tr><th>ID</th><th>Name</th><th>Duration</th><th>Price</th><th>Actions</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['Service_ID'] ?></td><td><?= $row['Service_Name'] ?></td><td><?= $row['Duration'] ?></td><td><?= $row['Price'] ?></td>
        <td class="actions">
            <a href="edit_service.php?id=<?= $row['Service_ID'] ?>"><button>Edit</button></a>
            <a href="delete_service.php?id=<?= $row['Service_ID'] ?>" onclick="return confirm('Delete service?')"><button>Delete</button></a>
        </td>
    </tr>
    <?php } ?>
</table>

<!-- Users Section -->
<a name="users"></a>
<h2>Users</h2>
<?php $result = mysqli_query($conn, "SELECT * FROM users"); ?>
<table>
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>DOB</th><th>Phone</th><th>Role</th></tr>
    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td><td><?= $row['username'] ?></td><td><?= $row['email'] ?></td>
        <td><?= $row['PASSWORD'] ?></td><td><?= $row['dob'] ?></td><td><?= $row['phone'] ?></td><td><?= $row['role'] ?></td>
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
