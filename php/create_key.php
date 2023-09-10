<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "localnotedb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);   

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the encryption key from the POST request
$data = json_decode(file_get_contents("php://input"));

if (isset($data->encryptionKey)) {
    $encryptionKey = mysqli_real_escape_string($conn, $data->encryptionKey);

    // Create a new row for the key in the database
    $sql = "INSERT INTO keylist (`key`, note) VALUES ('$encryptionKey', '')";

    if ($conn->query($sql) === TRUE) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
} else {
    $response = array('success' => false);
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
