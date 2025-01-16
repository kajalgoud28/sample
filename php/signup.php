<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "login_system";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname']; // Changed $usname to $uname
    $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username='$uname'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, password) VALUES('$uname', '$psw')";
        if ($conn->query($sql) === TRUE) {
            header("Location:../login.html");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
