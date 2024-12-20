<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "space_registration";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database checked/created successfully.<br>";
} else {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    dob DATE NOT NULL,
    package VARCHAR(50) NOT NULL,
    preferences TEXT,
    payment VARCHAR(20) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table checked/created successfully.<br>";
} else {
    die("Error creating table: " . $conn->error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $dob = htmlspecialchars($_POST['dob']);
    $package = htmlspecialchars($_POST['package']);
    $preferences = htmlspecialchars($_POST['preferences']);
    $payment = htmlspecialchars($_POST['payment']);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, dob, package, preferences, payment) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $dob, $package, $preferences, $payment);

    if ($stmt->execute()) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Phone:</strong> $phone</p>";
        echo "<p><strong>Date of Birth:</strong> $dob</p>";
        echo "<p><strong>Selected Package:</strong> $package</p>";
        echo "<p><strong>Special Requirements:</strong> $preferences</p>";
        echo "<p><strong>Payment Mode:</strong> $payment</p>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request method.";
}
$conn->close();
?>
