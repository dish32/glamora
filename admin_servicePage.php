<?php
session_start();

// Optional: Only allow access to admin users
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. Admins only.");
}

$conn = mysqli_connect("localhost", "root", "", "glamorasalon_db");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM service");
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
            font-family: 'Segoe UI', sans-serif;
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
            text-decoration: none;
            margin: 0 15px;
        }

        h2 {
            text-align: center;
            color: var(--dark-brown);
            margin: 20px 0;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid var(--light-brown);
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: var(--dark-brown);
            color: var(--white);
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        tr:hover {
            background-color: #eee;
        }

        .actions button {
            background-color: var(--light-brown);
            border: none;
            padding: 8px 12px;
            margin: 2px;
            cursor: pointer;
            transition: 0.3s;
        }

        .actions button:hover {
            background-color: var(--dark-brown);
            color: var(--white);
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

<table>
    <tr>
        <th>ID</th>
        <th>Service Name</th>
        <th>Description</th>
        <th>Duration</th>
        <th>Price (LKR)</th>
        <th>Actions</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['Service_ID'] ?></td>
            <td><?= $row['Service_Name'] ?></td>
            <td><?= $row['Description'] ?? 'No description' ?></td>
            <td><?= $row['Duration'] ?></td>
            <td><?= $row['Price'] ?></td>
            <td class="actions">
                <a href="edit_service.php?id=<?= $row['Service_ID'] ?>"><button>Edit</button></a>
                <a href="delete_service.php?id=<?= $row['Service_ID'] ?>" onclick="return confirm('Are you sure you want to delete this service?')">
                    <button>Delete</button>
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
