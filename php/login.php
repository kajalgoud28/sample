<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "login_system";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];
    $role = $_POST['role'];

    if ($role === "admin") {
        // Check if the entered credentials match the fixed admin credentials
        $admin_username = "kajal";
        $admin_password = "1"; // Adjusted password

        // You should ideally store hashed passwords even for admin accounts
        if ($uname === $admin_username && password_verify($psw, password_hash($admin_password, PASSWORD_BCRYPT))) {
            $_SESSION['username'] = $uname;
            $_SESSION['role'] = 'admin';  // Set role session variable
            $_SESSION['admin_logged_in'] = true;

            // Retrieve user_id for admin
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $uname);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['user_id'] = $row['id'];  // Store user_id in session
            }
            
            $stmt->close();

            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Invalid admin credentials!";
        }
    } else {
        // Regular user login process
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($psw, $row['password'])) {
                $_SESSION['username'] = $uname;
                $_SESSION['user_logged_in'] = true;

                // Retrieve user_id for the logged-in user
                $_SESSION['user_id'] = $row['id'];  // Store user_id in session

                // Update logged_in status with current datetime for user
                $stmt = $conn->prepare("UPDATE users SET logged_in = NOW() WHERE username = ?");
                $stmt->bind_param("s", $uname);
                if ($stmt->execute()) {
                    header("Location: ../index.php");  // Redirect to user homepage
                    exit();
                } else {
                    echo "Error updating user login time: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "Username not found!";
        }
    }
}

$conn->close();
?>
