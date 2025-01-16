<?php
include '../php/connection.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];
$comments = $_POST['comments'];

// Check if all fields are filled
if (empty($name) || empty($email) || empty($phone) || empty($service) || empty($date) || empty($time)) {
    echo "<script>alert('Please fill in all required fields.');window.history.back(); </script>";
    exit();
}

// Insert data into the database
$sql = "INSERT INTO appointments (name, email, phone, service, date, time, comments)
        VALUES ('$name', '$email', '$phone', '$service', '$date', '$time', '$comments')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../index.php?booking=success");
    exit();
}

 else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
