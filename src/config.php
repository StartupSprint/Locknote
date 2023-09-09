<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "localnotedb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully"; // This message indicates a successful connection
}
?>