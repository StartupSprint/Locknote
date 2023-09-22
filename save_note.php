<?php
$code = $_POST['code'];
$note = $_POST['note'];

// Create a database connection (replace with your database credentials)
$servername = "sql211.infinityfree.com";
$username = "if0_35085005";
$password = "z93UAb75vWW";
$dbname = "if0_35085005_locknote";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape the input to prevent SQL injection (better to use prepared statements)
$code = $conn->real_escape_string($code);
$note = $conn->real_escape_string($note);

// Insert the data into the database
$sql = "INSERT INTO notes (code, note) VALUES ('$code', '$note')";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();
?>
