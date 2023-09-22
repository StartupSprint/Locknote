<?php
$servername = "sql211.infinityfree.com";
$username = "if0_35085005"; // Replace with your MySQL username
$password = "z93UAb75vWW"; // Replace with your MySQL password
$dbname = "if0_35085005_locknote"; // Replace with your MySQL database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to database: $dbname"; // This message indicates a successful connection
}

// Close the connection when done
$conn->close();
?>
