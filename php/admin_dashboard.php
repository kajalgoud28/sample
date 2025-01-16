<?php
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Redirect to the home page if not an admin
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "login_system";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user credentials
$sql = "SELECT id, username, role, logged_in FROM users";  // Adjusted SQL query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome to the Admin Dashboard</h1>
    </header>

    <main>
        <h2 align="center">Admin Users Table</h2>
        <div>
            <table align="center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        
                        <th>Role</th>
                        
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            
                            echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                            
                            echo "<td>" . htmlspecialchars($row['logged_in']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div><br>
    </main>
</body>
</html>
