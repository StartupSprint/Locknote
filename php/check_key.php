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

    // Check if the key exists in the database
    $sql = "SELECT * FROM keylist WHERE `key` = '$encryptionKey'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $response = array('exists' => true);
        echo json_encode($response);
    } else {
        $response = array('exists' => false);
        echo json_encode($response);
    }
} else {
    $response = array('exists' => false);
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>
