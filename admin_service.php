<?php
session_start();

// Admin access check
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. Admins only.");
}

$conn = mysqli_connect("localhost", "root", "", "glamorasalon_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update logic
$update_msg = "";
if (isset($_POST['update_service'])) {
    $id = $_POST['id'];
    $name = $_POST['service_name'];
    $desc = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

    $update_query = "UPDATE service SET Service_Name='$name', Description='$desc', Duration='$duration', Price='$price' WHERE Service_ID='$id'";
    if (mysqli_query($conn, $update_query)) {
        $update_msg = "Service updated successfully.";
    } else {
        $update_msg = "Failed to update service.";
    }
}

// Fetch services
$result = mysqli_query($conn, "SELECT * FROM service");

// Get service to edit if 'edit' is set
$edit_id = isset($_GET['edit']) ? $_GET['edit'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Services</title>
    <style>
        :root {
            --light-brown: #d9b38c;
            --dark-brown: #5c4033;
            --white: #ffffff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--white);
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: var(--dark-brown);
            color: var(--white);
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: var(--white);
            margin: 0 15px;
            text-decoration: none;
        }

        h2 {
            text-align: center;
            color: var(--dark-brown);
            margin-top: 20px;
        }

        .msg {
            text-align: center;
            color: green;
            font-weight: bold;
            margin: 10px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid var(--light-brown);
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: var(--dark-brown);
            color: var(--white);
        }

        tr:nth-child(even) {
            background-color: #f9f6f2;
        }

        .actions button {
            background-color: var(--light-brown);
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: var(--dark-brown);
            color: var(--white);
        }

        input[type="text"], input[type="number"] {
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<nav>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_services.php">Manage Services</a>
    <a href="logout.php">Logout</a>
</nav>

<h2>Admin - Manage Services</h2>

<?php if ($update_msg): ?>
    <div class="msg"><?= $update_msg ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Service Name</th>
        <th>Description</th>
        <th>Duration</th>
        <th>Price (LKR)</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <?php if ($edit_id == $row['Service_ID']) { ?>
            <!-- Edit form -->
            <form method="POST" action="admin_services.php">
                <tr>
                    <td><?= $row['Service_ID'] ?></td>
                    <td><input type="text" name="service_name" value="<?= $row['Service_Name'] ?>"></td>
                    <td><input type="text" name="description" value="<?= $row['Description'] ?>"></td>
                    <td><input type="text" name="duration" value="<?= $row['Duration'] ?>"></td>
                    <td><input type="number" name="price" value="<?= $row['Price'] ?>"></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['Service_ID'] ?>">
                        <button type="submit" name="update_service">Save</button>
                        <a href="admin_services.php"><button type="button">Cancel</button></a>
                    </td>
                </tr>
            </form>
        <?php } else { ?>
            <!-- Normal row -->
            <tr>
                <td><?= $row['Service_ID'] ?></td>
                <td><?= $row['Service_Name'] ?></td>
                <td><?= $row['Description'] ?></td>
                <td><?= $row['Duration'] ?></td>
                <td><?= $row['Price'] ?></td>
                <td class="actions">
                    <a href="admin_services.php?edit=<?= $row['Service_ID'] ?>"><button>Edit</button></a>
                    <a href="delete_service.php?id=<?= $row['Service_ID'] ?>" onclick="return confirm('Are you sure?')"><button>Delete</button></a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>

</body>
</html>
